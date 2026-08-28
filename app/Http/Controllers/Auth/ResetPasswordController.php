<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Models\Establishment;
use App\Models\School;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends  BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function resetPasswordByAdmin(ResetPasswordRequest $request)
    {
        $permittedRoles = [1,2,3]; // liste des roles qui peuvent faire cette action

        try {
            // On vérifie donc premièrement que l'utilisateur authentifié a le droit d'effectuer cette action

            $user = User::select('users.id as id','roles.id as role_id','roles.name as role','roles.description as role_description','roles.type as typeRole')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.id', Auth::user()->id)->first();

            if(!in_array($user->role_id, $permittedRoles)){
                return $this->sendError("Vous n'avez pas le droit d'effectuer cette action", [], 403);
            }

            // On peut donc mettre à jour le mot de passe de l'utilisateur passé en request

            $user = User::findOrFail($request->idUser);
            $user->password = bcrypt($request->password);
            $user->save();

            Log::critical("maj du password d'un user.", ['author' => Auth::user()->id, 'concerned_user' => $user->id]);

            // Envoi de mail avec le nouveau mot de passe ssi cet utilisateur possède une @ email
            if(!is_null($user->email)){
                // envoi du mot passe par mail
                $school = School::find($user->idSchool);
                $establishment = Establishment::first();

                $data = [
                    'author' => Auth::user(),
                    'username' => $user->username,
                    'password' => $request->password,
                    'key' => $establishment->cle,
                    'loginUrl' => "https://app.ms-school.net/",
                    'school' => $school
                ];

                $user->sendMail($user->email, $school->name, "emails.reset-password", $data, "Mot de passe modifié sur MS-School");
            }

            return $this->sendResponse("Mot de passe changé avec succès", "success");
        } catch (\Throwable $th){
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }
}
