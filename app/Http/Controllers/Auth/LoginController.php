<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Http\Requests\LogoutUserRequest;
use App\Models\Establishment;
use App\Models\Fee;
use App\Models\FeeUser;
use App\Models\MobileBuildVersion;
use App\Models\Permission;
use App\Models\School;
use App\Providers\RouteServiceProvider;
use App\Traits\CheckIfRegistrationFeeIsPaidTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Admin\UserLoginResource;

/**
 * @group Authentication
 */
class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    use CheckIfRegistrationFeeIsPaidTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     *  Log in the new user
     *
     * @unauthenticated
     *
     * @param LoginRequest $request
     * @return UserLoginResource|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request){
        try {

            if(!Auth::attempt($request->only(['username', 'password']))) {
                //return $this->error('', 'Credentials do not match', 401);
                return $this->sendError("Le nom d'utilisateur ou mot de passe est incorrect");
            }

            $user = User::select('users.id as id','users.username as username','users.name as name','users.scholar_type as scholar_type','users.phone as phone','roles.id as role_id','roles.name as role','roles.description as role_description','users.adresse as adresse','users.photo as photo','users.idSchool as idSchool','users.idSection as idSection','users.idLevel as idLevel','users.idClasse as idClasse','users.idClasse as idClasse','users.idCycle as idCycle','users.whatsapp_number as whatsapp_number','roles.type as typeRole')
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('username', $request->username)->first();

            if(!empty($user->idSchool)){
                $user = User::select('users.id as id','users.username as username','users.name as name','users.scholar_type as scholar_type','users.phone as phone','roles.id as role_id','roles.name as role','roles.description as role_description','users.adresse as adresse','users.photo as photo','users.idSchool as idSchool','users.idSection as idSection','users.idLevel as idLevel','users.idClasse as idClasse','users.idClasse as idClasse','users.idCycle as idCycle','roles.type as typeRole','schools.scholar_level as scholar_level','users.whatsapp_number as whatsapp_number')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->join('schools','schools.id','=','users.idSchool')
                        ->where('username', $request->username)->first();
            }

            // On va vérifier si il a payé l'inscription etc...
            /**
             * registrationPaid => [
             *  true => Université & payé
             *  false => Université & non payé
             *  null => Autre
             * ]
             */
            $registrationPaid = null;

//            $school = School::find($user->idSchool);

            // Si ce n'est pas University ou si ce n'est pas l'étudidant, on ne fait rien de plus
//            if(!is_null($school) && $school->scholar_level == "University" && $user->role == "Inscription"){
//                // On vérifie si il a terminé le paiement de l'inscription
//
//                $fee_user = FeeUser::join('fees', 'fees.id', '=', 'fee_user.idFee')
//                    ->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
//                    ->where(function($query) {
//                        $query->where('fees.name', 'like', '%Registration%')
//                            ->orWhere('fees.name', 'like', '%Inscription%');
//                    })
//                    ->where('fee_user.idSchool', $school->id)
//                    ->where('fee_user.idStudent', $user->id)
//                    ->where('fee_has_level.level_id', $user->idLevel)
//                    ->where('fee_user.solvable', 'terminé')
//                    ->select('fee_user.solvable', 'fees.name')
//                    ->first();
//
//                $registrationPaid = !is_null($fee_user);
//            }

            $user->registrationPaid = $this->isRegistrationPaid($user->id); //$registrationPaid;
//            $user->registrationPaid = $this->isRegistrationPaid($user->idSchool, $user->id, $user->role, $user->idLevel); //$registrationPaid;

            $build = MobileBuildVersion::orderBy('id', 'desc')->first();
            $user->build_number = $build->build_number;
            $user->build_number_verified = $build->verified;
            $user->pay_om_fees = Establishment::first()->pay_om_fees;

            // Indiquer si des frais obligatoires sont encore dus (pour les étudiants)
            $user->fees_required = false;
            if (isset($user->role_id) && $user->role_id == 8) {
                $user->fees_required = $this->hasUnpaidRequiredFees($user->id);
            }

            return UserLoginResource::make($user);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Déconnecter l'utilisateur connecté
     *
     * @unauthenticated
     * @return \Illuminate\Http\Response
     */
    public function logout(LogoutUserRequest $request)
    {
        // on supprime le device key sur le compte

        $user = Auth::user();

        if(!is_null($user->device_key)){
            $valueToRemove = $request->token;

            $user_devices = explode(";;;", $user->device_key);

            // Recherche de l'index de l'élément à retirer
            if (($key = array_search($valueToRemove, $user_devices)) !== false) {
                unset($user_devices[$key]); // Suppression de l'élément
            }

            $user->device_key = implode(";;;", array_unique($user_devices));
            $user->save();
        }

        Auth::user()->currentAccessToken()->delete();

        return $this->sendResponse("OK",'You have successfully been logged out and your token has been deleted');
    }
}
