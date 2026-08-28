<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendMailJob;
use App\Mail\WelcomeUserMail;
use App\Models\Classes;
use App\Models\Establishment;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\MailTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group Authentication
 */
class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // bonne methode qui marche avec angular
    public function uploadphotos(Request $request)
    {
        $file = $request->file('photo');
        $uploadPath = "public/profil";
        $originalImage = $file->getClientOriginalName();
        $re = $file->move($uploadPath,$originalImage);
        if ($re) {
            normalize_image_orientation($re->getPathname());
        }
        return response()->json(['chemin' => $re->getPathname()]);
    }

    /**
     * Enregistrer un nouvel utilisateur
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function signup(RegisterRequest $request)
    {
        try {
            $input = $request->all();

            if(!isset($input['idSchool'])){
                $input['idSchool'] = null;

                if($input['role'] == 8){
                    $classe = Classes::find($input['idClasse']);

                    $input['idSchool'] = $classe->idSchool;
                }
            }

            if(!is_null($request['username'])){
                // On va vérifier que le username saisit n'existe pas encore dans la BD
                $user = User::where('username', $input['username'])->count();
                if($user != 0){
                    return $this->sendError("Impossible de créer un compte en utilisant ce username");
                }
            }

            if(!empty($input['password'])){
                $mdp = $input['password'];
                $input['password'] = bcrypt($input['password']);
            }else{
                $input['password'] = null;
            }

            DB::beginTransaction();

            // TODO: On génère le matricule ici avant d'envoyer en BD
            $matricule = $input['matricule'] ?? null;

            if($input['role']==8 && is_null($matricule)){
                $classe = Classes::find($input['idClasse']);

                $school = School::find($classe->idSchool);
                $section = Section::find($classe->idSection);

                $year = substr(date('Y'), 2, 2);
                $section = strtoupper(substr($section->name, 0, 3));

                if($section == "FRA") $section = "FR"; // On renomme pour francophone en FR
                if($section == "ANG") $section = "EN"; // On renomme pour anglophone en EN

                // Si $school->matricule_code est null, on ne génère pas du tout de matricule
                $matricule = (!is_null($school->matricule_code) && !empty($school->matricule_code))
                    ? User::generateMatricule($school->matricule_code, $year, $section)
                    : null; // on a pas le choix, il n'aura juste pas de matricule pour le moment


                //La section de l'eleve vient de sa classe
                $input['idSection'] = $classe->idSection;
            }

            $user = User::create([
                'name' => $input['name'],
                'firstname' => $input['firstname'] ?? null,
                'placeofbirth' => $input['placeofbirth'] ?? null,
                'situation' => $input['situation'] ?? null,
                'repeater' => $input['repeater'] ?? null,
                'cni' => $input['cni'] ?? '',
                'email' => $input['email'] ?? null,
                'whatsapp_number' => $input['whatsapp_number'] ?? null,
                'photo' => $request['photo'] ?? null,
                'profession' => $request['profession'] ?? null,
                'bank_name' => $request['bank_name'] ?? null,
                'bank_rib' => $request['bank_rib'] ?? null,
//                'number_days_off' => $request['number_days_off'] ?? 0,
                'password' => $input['password'] ?? null,
                'username' => $input['username'] ?? null,
                'phone' => $input['phone'] ?? null,
                'adresse' => $input['adresse'] ?? null,
                'nationality' => $input['nationality'] ?? null,
                'mother' => $input['mother'] ?? null,
                'tutor' => $input['tutor'] ?? null,
                'phone_2' => $input['phone_2'] ?? null,
                'phone_3' => $input['phone_3'] ?? null,
                'phone_4' => $input['phone_4'] ?? null,
                'phone_5' => $input['phone_5'] ?? null,
                'phone_6' => $input['phone_6'] ?? null,
                'observation' => $input['observation'] ?? null,
                'gender' => $input['gender'],
                'adresse_2' => $input['adresse_2'] ?? null,
                'adresse_tutor' => $input['adresse_tutor'] ?? null,
                'gender_2' => $input['gender_2'] ?? null,
                'gender_tutor' => $input['gender_tutor'] ?? null,
                'birthday' => $input['birthday'] ?? null,
                'city' => $input['city'] ?? null,
                'fit' => $input['fit'] ?? null,
                'desease' => $input['desease'] ?? null,
                'matricule' => $matricule, // on envoie ici ce qui vient plus haut
                'country' => $input['country'] ?? null,
//                'idCampus' => $input['idCampus'] ?? null,
                'salary' => $input['salary'] ?? null,
                'hourlyPrice' => $input['hourlyPrice'] ?? null,
                'grade' => $input['grade'] ?? null,
                'anciennete' => $input['anciennete'] ?? null,
                'cat' => $input['cat'] ?? null,
                'ech' => $input['ech'] ?? null,
                'hiring_date' => $input['hiring_date'] ?? null,
                'num_cnps' => $input['num_cnps'] ?? null,
                'niu' => $input['niu'] ?? null,
                'agence' => $input['agence'] ?? null,
                'service' => $input['service'] ?? null,
                'categorie' => $input['categorie'] ?? null,
                'num_dipe' => $input['num_dipe'] ?? null,
                'date_embauche' => $input['date_embauche'] ?? null,
                'idMatter' => $input['idMatter'] ?? null,
                'idParent' => $input['idParent'] ?? null,
                'idLevel' => $input['idLevel'] ?? null,
                'idCycle' => $input['idCycle'] ?? null,
                'idClasse' => $input['idClasse'] ?? null,
                'idClasse2' => $input['idClasse2'] ?? null,
                'old_classe' => $input['old_classe'] ?? null,
                'idClassePrincipal' => $input['idClassePrincipal'] ?? null,
                'idOptionLevel' => $input['idOptionLevel'] ?? null,
                'idSchool' => $input['idSchool'] ?? null,
                'idSection' => $input['idSection'] ?? null,
                'idBourse' => $input['idBourse'] ?? null,
            ]);

            if($input['role'] == 8){
                $classe = Classes::find($input['idClasse']);

                $user->update([
                    'idSchool' => $classe->idSchool,
                    'idSection' => $classe->idSection,
                    'idLevel' => $classe->idLevel,
                ]);
            }
            $user->assignRole($input['role']);
            if($request['matter'] != null){
                $user->matters()->sync($request['matter']);
            }

            if($request['classes'] != null){
                $user->classes()->sync($request['classes']);
            }

            $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
            $success['name'] =  $user->name;

            //On ajoute la photo si il a soumis
//            if(!is_null($request->photo)){
//                $file = $request->file('photo');
//                $uploadPath = "public/profil";
//                $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                $file->move($uploadPath,$originalImage);
//
//                $user->photo = $originalImage;
//                $user->save();
//            }

            if(!is_null($input['idSchool'])){
                $school = School::find($input['idSchool']);

                if(in_array($school->scholar_level, ["University", "CF"])){
                    $user->update([
                        'codeun' => User::generateUser('codeun'),
                        'codedeux' => User::generateUser('codedeux')
                    ]);
                }
            }

//            if(!is_null($user->email) && !is_null($user->username) && !is_null($user->password) && !is_null($input['idSchool'])){
//                // TODO : On envoie le mail avec les credentials (username, password, cle)
//

//
//                $data = [
//                    'username' => $user->username,
//                    'password' => $request->password,
//                    'key' => $establishment->cle,
//                    'loginUrl' => "https://app.ms-school.net/",
//                    'school' => $school
//                ];
//
//                $user->sendMail($user->email, $school->name, "emails.registration", $data, "Création de compte sur MS-School");
//            }

            if (
                !empty($user['username']) &&
                !empty($user['email']) &&
                filter_var($user['email'], FILTER_VALIDATE_EMAIL)
            ) {
                $school = School::find($input['idSchool']);
                $establishment = Establishment::first();

                $mailable = new WelcomeUserMail(
                    $school,
                    $user,
                    $establishment['cle'],
                    $request->password
                );
                $recipients = [
                    $user['email']
                ];


                SendMailJob::dispatch($mailable, $recipients, 'smtp_for_welcome');
            }

            DB::commit();

            return $this->sendResponse($success, 'User created successfully.');
        } catch (\Throwable $th) {
//            return  $this->sendError($th->getMessage());

            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }

    }
}
