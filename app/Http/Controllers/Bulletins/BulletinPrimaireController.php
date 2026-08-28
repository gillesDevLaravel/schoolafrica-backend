<?php

namespace App\Http\Controllers\Bulletins;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GenererBulletinPrimaireSequenceRequest;
use App\Http\Requests\Admin\GenererBulletinPrimaireTrimestreRequest;
use App\Http\Requests\Admin\ListUsersWithMonthlyAssessmentsPDFRequest;
use App\Http\Requests\Admin\PvPrimaireTrimestreRequest;
use App\Http\Requests\Admin\StatistiquesAnnuellesRequest;
use App\Http\Requests\AfficherNotesPrimaireRequest;
use App\Http\Requests\GenererBulletinPrimaireRequest;
use App\Http\Resources\AnnualDecisionResource;
use App\Models\AcademicYear;
use App\Models\Assessment;
use App\Models\AssessmentHasAssessmentType;
use App\Models\AssessmentHasTypeEvaluation;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Establishment;
use App\Models\Key;
use App\Models\Matter;
use App\Models\MatterGroup;
use App\Models\OptionLevel;
use App\Models\Permission;
use App\Models\Rating;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\School;
use App\Models\Section;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use App\Services\PensionUserService;
use App\Traits\BulletinPrimaireTrait;
use App\Traits\DataBulletinsTrait;
use App\Traits\DeletePDFTmpFilesTrait;
use App\Traits\ManageDirectoryTrait;
use App\Traits\PvUtilitaires;
use ArrayObject;
use Dompdf\Dompdf;
use Google\Service\Classroom\Student;
use Google\Service\WorkloadManager\Evaluation;
use Hamcrest\Type\IsString;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Mockery\Exception;
use setasign\Fpdi\Fpdi;
use stdClass;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

/**
 * @group Bulletins Primaire
 */
class BulletinPrimaireController extends BaseController
{
    use DeletePDFTmpFilesTrait, ManageDirectoryTrait, PvUtilitaires, DataBulletinsTrait, BulletinPrimaireTrait;

    protected $pensionUserService;
    private $listRoleSimple = [7, 8];

    public function __construct(PensionUserService $pensionUserService)
    {
        $this->pensionUserService = $pensionUserService;
    }

    /**
     * Générer bulletin(s) primaire séquence
     *
     * @param GenererBulletinPrimaireSequenceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinPrimaireSequence(GenererBulletinPrimaireSequenceRequest $request)
    {
        set_time_limit(3000);
        try {
            //return $this->getRole();
            /**
             * PAYLOAD VALIDE
             * BD: juniors
             * { "username":"fondateur", "password":"000000", "idClasse": 10, "idUser":7, "idOptionLevel": 1, "idAssessmentType": 1, "route": "juniors", "lang": "fr" }
             * { "username": "fondateur", "password": "000000", "idClasse": 17, "idAssessmentType": 7, "idTrimestre": 4, "idUser": 472, "lang": "en", "route": "juniors", "forSolvables": true }
             */

            $this->createDirectory('pdfs');
            ini_set('max_execution_time', 300);
            //TODO: Récupérer les données ici pour le primaire
            $requestData = $request->validated();

            $classe = Classes::find($requestData['idClasse']);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $assessmentType = AssessmentType::find($request->idAssessmentType);
            $num_sequence = $assessmentType->name[strlen($assessmentType->name)-1];

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $idUser = $requestData['idUser'] ?? null; //NB: On va garder cette valeur parce qu'on ne veut pas l'envoyer au endpoint qui récupère les notes de tous les étudiants
            unset($requestData['idUser']);

//Block de vérification des insolvables
            $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
            //return $insolvables;

            //Vérification directe si on veut pour un seul utilisateur
            if($idUser != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                if(!is_null($request['forSolvables']) && $request['forSolvables'] && !$this->isSolvable($insolvables, $idUser)){
                    return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                }
            }
            else if ($idUser != null && !$this->isSolvable($insolvables, $idUser)){
                return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
            }
//Fin de vérification des insolvables

// Vérification spécifique pour parents et élèves : paiement de la tranche 2
            if (in_array($this->getRole()->id, [7,8]) && $idUser != null) {
                $requestDataX = $request->validated();
                $requestDataX['idSchool'] = $classe->idSchool;
                $requestDataX['nameTranche'] = 2;
                $insolvablesTranche2 = $this->pensionUserService->insolvablePensionUser($requestDataX)['data'];
                if (in_array($idUser, $insolvablesTranche2)) {
                    return $this->sendError("Veuillez payer la tranche 2 pour télécharger le bulletin");
                }
            }

//Block de vérification des insolvables
            $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
            //return $insolvables;

            //Vérification directe si on veut pour un seul utilisateur
            if($idUser != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                if(!is_null($request['forSolvables']) && $request['forSolvables'] && !$this->isSolvable($insolvables, $idUser)){
                    return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                }
            }
            else if ($idUser != null && !$this->isSolvable($insolvables, $idUser)){
                return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
            }
//Fin de vérification des insolvables

            //TODO: TOUJOURS désactiver le Cache avant de push
            Cache::forget("infosBulletinsPrimaireSequence" . $request->idClasse);
            $infosBulletins = cache()->remember("infosBulletinsPrimaireSequence".$request->idClasse, 36000, function() use ($requestData) {
                return $this->bulletinSequence($requestData)->getData();
            });

            if($infosBulletins->success != true || $infosBulletins->data->effectifClasse == 0){
                return $this->sendError($infosBulletins->message);
            }

            $json_data = $infosBulletins->data;

//            return response()->json($json_data);

            $zip_file = "Bul-prim-".Str::slug($classe->name)."-sequence-".Str::slug($assessmentType->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $route = $request->route;
            $liensBulletins = array();

            $moyenneStudents = array();
            $sequence_name = "moyenneSequence".$num_sequence;

            $moyenne_generale = round($infosBulletins->data->moyennesGenerales[$num_sequence-1], 2);

            foreach ($infosBulletins->data->user as $userData) {
                $moyenneStudents[] = @$userData->$sequence_name;
            }

            arsort($moyenneStudents);

            $moyenneStudents = array_values($moyenneStudents);

            if(!is_null($request->idUser)){
                $idUser = $request->idUser;

                $infosBulletins->data->user = collect($infosBulletins->data->user)->filter(function($user) use ($idUser) {
                    return $user->id == $idUser;
                })->values();
            }

            if(count((array)$infosBulletins->data->user) == 0){
                return $this->sendError("idStudent {$idUser} invalide");
            }

            // On trouve les moyennes en grades (je sais pas comment dire ça ... regarde juste le code et tu vas comprendre)
            $legend_of_grade = [
                'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud < 10;
                })),
                'nye_color' => "db0b32",
                'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 10 && $moyenneStud < 15;
                })),
                'ae_color' => "fdaa3e",
                'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 15 && $moyenneStud < 18;
                })),
                'me_color' => "0080ff",
                'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 18;
                })),
                'abe_color' => "008000",
            ];

            for ($case = 0; $case < count($infosBulletins->data->user); $case++){
                $user = $infosBulletins->data->user[$case];

                //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                if($this->isSolvable($insolvables, $user->id) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))) {

                    $nbreReussite = count(array_filter($moyenneStudents, function($moyenneStud) {
                        return $moyenneStud >= 10;
                    })); // Nombre d'élèves ayant plus de 10/20 de moyenne
                    $dompdf = new Dompdf();

                    $data = [
                        'effectifClasse' => $json_data->effectifClasse,
                        'classe' => $classe,
                        'teacher_principal' => $classe->teacher,
                        'user' => $user,
//                        'rang_sequence' => $user->$sequence,
                        'section' => $section,
                        'assessmentType' => $assessmentType,
                        'school' => $school,
                        'establishment' => $establishment,
                        'code_couleurs' => $code_couleurs,
                        'num_sequence' => $num_sequence, // 1, 2, 3, ....
                        'moyennes' => $moyenneStudents,
                        'first_moyenne' => $moyenneStudents[0],
                        'last_moyenne' => end($moyenneStudents),
                        'class_average' => $moyenne_generale,
                        'class_success_percentage' => round(($nbreReussite * 100) / $json_data->effectifClasse, 2),
                        'legend_of_grade' => $legend_of_grade,
                        'route' => $route
                    ];

//                    return $data;

                    $filename = Str::slug($json_data->user[$case]->name);

                    $folder = "bulletin.primaire.sequence";

                    (view()->exists($folder . "." . $route))
                        ? $vue = $folder . "." . $route
                        : $vue = $folder . ".default";

                    // Récupérer la vue
                    $view = View::make($vue)->with($data);
                    //$view = View::make('receipt')->with($formattedData);

                    // Récupérer le contenu de la vue
                    $html = $view->render();

                    // Charger le contenu HTML dans Dompdf
                    $dompdf->loadHtml($html);

                    // (Optionnel) Définir la taille et l'orientation du papier
                    $dompdf->setPaper('A4', 'portrait');

                    // Exécuter le rendu du PDF
                    $dompdf->render();

                    file_put_contents(public_path("pdfs/$filename-bulletin-primaire-sequence.pdf"), $dompdf->output());

                    if (count($infosBulletins->data->user) > 1) {

                        $zip->addFile("pdfs/$filename-bulletin-primaire-sequence.pdf");

                        $liensBulletins[] = public_path("pdfs/$filename-bulletin-primaire-sequence.pdf");
                    } else {
                        return $this->sendResponse(asset("pdfs/$filename-bulletin-primaire-sequence.pdf"), "Bulletin primaire");
                    }
                }

            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin primaire");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer PV séquence du primaire
     *
     * @param ListUsersWithMonthlyAssessmentsPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function pvPrimaireSequence(ListUsersWithMonthlyAssessmentsPDFRequest $request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             *
             * BD: juniors
             * { "username":"fondateur", "password":"000000", "idClasse":17, "idAssessmentType":7, "idUser":472, "lang":"en" }
             *
             * BD: moderne
             * { "username":"fondateur", "password":"000000", "idClasse": 1, "idAssessmentType": 1, "idOptionLevel": "", "sortUsers": "merit", "lang": "fr" }
             * { "username":"fondateur", "password":"000000", "idClasse": 1, "idAssessmentType": 1, "idOptionLevel": "", "sortUsers": "merit", "lang": "fr", "forSolvables":true }
             */

            $this->createDirectory('pdfs');

            $classe = Classes::findOrFail($request->idClasse);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $assessmentType = AssessmentType::findOrFail($request->idAssessmentType);
            $num_sequence = substr($assessmentType->name, -1, 1);

            $requestData = $request->validated();
            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $sortUsers = $requestData['sortUsers'] ?? "alphabetical";

            $idOptionLevel = $request['idOptionLevel'] ?? null;

            //TODO: décommenter la ligne suivante AVANT de push
            Cache::forget("infosBulletinsPrimaireSequence" . $request->idClasse);
            $infosBulletins = cache()->remember("infosBulletinsPrimaireSequence".$request->idClasse, 3600, function() use ($requestData) {
                return $this->bulletinSequence($requestData)->getData();
            });

            if(!$infosBulletins->success){
                return $this->sendError($infosBulletins->message);
            }

            if(count($infosBulletins->data->user) == 0){
                return $this->sendError("Pas d'élèves avec de notes pour ces données");
            }

            $json_data = $infosBulletins->data;

//            return response()->json($infosBulletins);

            $assessments = array();

            $to_max = 0;

            foreach ($infosBulletins->data->user[0]->matterGroup as $matterGroup) {
                foreach ($matterGroup->assessment as $assessment) {
                    $assessments[] = [
                        'nameMatter' => $assessment->nameMatter,
                        'codeMatter' => $assessment->codeMatter,
                        'libelleMatter' => $assessment->libelleMatter,
                        'notemax' => $assessment->notemax,
                    ];

                    $to_max += $assessment->notemax;
                }
            }

            // On va compter à partir de la table Ratings
            $nbre_boys_compose =  DB::table('ratings as r')
                ->join('users as u', 'u.id', '=', 'r.idStudent')
                ->where('r.idClasse', $request->idClasse)
                ->where('r.idAssessmentType', $request->idAssessmentType)
                ->whereIn('u.gender', ['homme', 'male'])
                ->distinct('u.id')
                ->count('u.id');

            $nbre_girls_compose = DB::table('ratings as r')
                ->join('users as u', 'u.id', '=', 'r.idStudent')
                ->where('r.idClasse',  $request->idClasse)
                ->where('r.idAssessmentType', $request->idAssessmentType)
                ->whereIn('u.gender', ['femme', 'female'])
                ->distinct('u.id')
                ->count('u.id');

            $nbre_passed = $nbre_failed = $nbre_boys_passed = $nbre_girls_passed = $nbre_girls_failed = $nbre_boys_failed = 0;

            $moyenneStudents = array();
            $sequence_name = "moyenneSequence".$num_sequence;
            $total_note_assessment = "total_note_assessment".$num_sequence;

            foreach ($infosBulletins->data->user as $userData) {
                $moyenneStudents[] = @$userData->$sequence_name;

                if(in_array($userData->gender, ['Male', 'male', 'Homme', 'homme', 'M'])){
                    if(@$userData->$sequence_name >= 10){
                        $nbre_boys_passed++;
                        $nbre_passed++;
                    }else{
                        $nbre_boys_failed++;
                        $nbre_failed++;
                    }
                }else{
                    if(@$userData->$sequence_name >= 10){
                        $nbre_girls_passed++;
                        $nbre_passed++;
                    }else{
                        $nbre_girls_failed++;
                        $nbre_failed++;
                    }
                }
            }

            arsort($moyenneStudents);

            $moyenneStudents = array_values($moyenneStudents);

            $legend_of_grade = [
                'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud < 10;
                })),
                'nye_color' => "db0b32",
                'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 10 && $moyenneStud < 15;
                })),
                'ae_color' => "fdaa3e",
                'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 15 && $moyenneStud < 18;
                })),
                'me_color' => "0080ff",
                'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 18;
                })),
                'abe_color' => "008000",
            ];

            $exam_statistics = [
                'nbre_passed' => $nbre_passed,
                'nbre_failed' => $nbre_failed,
                'nbre_boys_passed' => $nbre_boys_passed,
                'nbre_boys_failed' => $nbre_boys_failed,
                'nbre_girls_passed' => $nbre_girls_passed,
                'nbre_girls_failed' => $nbre_girls_failed
            ];

            $nbreReussite = count(array_filter($moyenneStudents, function($moyenneStud) {
                return $moyenneStud >= 10;
            })); // Nombre d'élèves ayant plus de 10/20 de moyenne

            $moyenne_generale = round($infosBulletins->data->moyennesGenerales[$num_sequence-1], 2); //round(array_sum(array_map('floatval', $moyenneStudents)) / count($moyenneStudents), 2);

            $users = User::select('users.id as id','users.name as name')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->where('ratings.idAssessmentType', $request['idAssessmentType'])
                ->where('users.idClasse',$request['idClasse'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->join('matter','matter.id','=','ratings.idMatter')
                        ->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->where('users.deleted',0)
                ->distinct('users.id')
                ->get();

            $infosGeneralesClasse = [
                'nbre_boys' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->whereIn('users.gender', ['homme', 'Male', 'M'])
                    ->count(),
                'nbre_boys_compose' => User::select('users.id as id','users.name as name')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                    ->where('ratings.idAssessmentType', $request['idAssessmentType'])
                    ->where('users.idClasse',$request['idClasse'])
                    ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                        $query->join('matter','matter.id','=','ratings.idMatter')
                            ->where('matter.idOptionLevel', $idOptionLevel);
                    })
                    ->where('users.deleted',0)
                    ->distinct('users.id')
                    ->whereIn('users.gender', ['homme', 'Male', 'M'])
                    ->count(),
                'nbre_girls' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->whereIn('users.gender', ['femme', 'Female', 'F'])
                    ->count(),
                'nbre_girls_compose' => User::select('users.id as id')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                    ->where('ratings.idAssessmentType', $request['idAssessmentType'])
                    ->where('users.idClasse',$request['idClasse'])
                    ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                        $query->join('matter','matter.id','=','ratings.idMatter')
                            ->where('matter.idOptionLevel', $idOptionLevel);
                    })
                    ->where('users.deleted',0)
                    ->whereIn('users.gender', ['femme', 'Female', 'F'])
                    ->distinct('users.id')
                    ->count(),
                'moyenne_generale' => $moyenne_generale,
                'class_percentage_success' => round(($nbreReussite*100) / $json_data->effectifClasse, 2)."%",

                'nouveaux_m' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('situation','new')
                    ->whereIn('gender', ['homme', 'Male', 'M'])
                    ->count(),
                'nouveaux_f' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('situation','new')
                    ->whereIn('gender', ['femme', 'Female', 'F'])
                    ->count(),
                'nouveaux_total' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('situation','new')
                    ->count(),

                'redoublants_m' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('repeater','1')
                    ->whereIn('gender', ['homme', 'Male', 'M'])
                    ->count(),
                'redoublants_f' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('repeater','1')
                    ->whereIn('gender', ['femme', 'Female', 'F'])
                    ->count(),
                'redoublants_total' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('repeater','1')
                    ->count(),

                'effectif_general_m' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('gender',"Male")
                    ->count(),
                'effectif_general_f' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->where('gender',"Female")
                    ->count(),
                'effectif_general_total' => User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.id',8)
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->count(),
            ];

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $usersData = $infosBulletins->data->user;
            // On classe les élèves par ordre de mérite si demandé
            if($sortUsers == "merit"){
                usort($usersData, function ($a, $b) use($sequence_name) {
                    return $b->$sequence_name <=> $a->$sequence_name;
                });
            }

            $data = [
                'effectifClasse' => $json_data->effectifClasse,
                'students' => $usersData, //$infosBulletins->user,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $classe->name,
                'school' => $school,
                'section' => $section,
                'total_note_max' => $to_max, //$infosBulletins->data->classTotalNotesMax,
                'assessmentType' => $assessmentType,
                'trimestre' => $assessmentType->trimestre,
                'assessments' => $assessments,
                'infosGeneralesClasse' => $infosGeneralesClasse,
                'code_couleurs' => $code_couleurs,
                'exam_statistics' => $exam_statistics,
                'legend_of_grade' => $legend_of_grade,
                'num_total_note_assessment' => "total_note_assessment" . mb_substr($assessmentType->name,-1),
                'numTotalSequenceUser' => "totalSequence". mb_substr($assessmentType->name,-1) ."User",
                'numMoyenneSequence' => "moyenneSequence" . mb_substr($assessmentType->name,-1),
                'num_rang_moyenneSequence' => "rang_moyenneSequence" . mb_substr($assessmentType->name,-1)
            ];

//            return $data;

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.pv.primaire.sequence')->with($data);
//            $view = View::make('documents.users-list-with-monthly-assessments')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'landscape');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "users-".Str::slug($classe->name)."-with-monthly-assessments.pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de {$classe->name} avec évaluations mensuelle");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function bulletinSequence(array $request){
        try {

            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.nationality as nationality','users.photo as photo','users.city as city',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->where('ratings.idAssessmentType', $request['idAssessmentType'])
                ->where('users.idClasse',$request['idClasse'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->join('matter','matter.id','=','ratings.idMatter')
                        ->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->where('users.deleted',0)
                ->distinct('users.id')
                ->orderBy("users.name", "asc")
                ->get();

            $tabNote['user'] = $entete;

            $effectifClasse = count($entete);

            $tabNote['effectifClasse'] = $effectifClasse;

            if($entete->count() == 0){
                Log::critical("Aucun élève avec de notes pour ces données" . " in file " . BulletinPrimaireController::class);
                return $this->sendError("Aucun élève avec de notes pour ces données");
            }

            for ($i=0; $i < $entete->count(); $i++) {

                // le nombre total d'évaluations que l'élève a composé..
                // on s'en servira(si >=70% du total des évaluations) pour savoir si il doit être inclus pour calculer la moyenne générale de sa classe
                // ou même si il doit avoir un rang
                $totalNbreEvaluationsComposes = 0;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                        $query->where('matter_group.idOptionLevel', $idOptionLevel);
                    })
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $matterGroupIDs = $matterGroup->pluck('id')->toArray();

                $tabNote['user'][$i]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                if($matterGroup->count() == 0){
                    throw new \Exception("Aucun groupe de matière trouvé");
                }

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
                        ->orderBy("id", "asc")
                        ->get();

                    // On va modifier la notemax de chaque évaluation pour cet enfant (dans la mesure où il n'a pas composé sur tous ces types)
                    foreach ($assessment as $key_tmp_assessment => $assess) {
                        $tmp_te_s = $assess->typeEvaluations;
                        $final_notemax_for_assessment = 0;

                        // On va check si l'utilisateur a une note sur ce type_eval pour cette évaluation
                        foreach ($tmp_te_s as $tmp_type){
                            $studentHasNote = Rating::join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_type_id','=','ratings.idAssessmentType')
                                ->where('ratings.idClasse',$request['idClasse'])
                                ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                                ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                                ->where('ratings.idTypeEvaluation', $tmp_type->id)
                                ->where('ratings.idAssessment', $assess['id'])
                                ->count();

                            if($studentHasNote != 0) $final_notemax_for_assessment += $assess[Str::slug($tmp_type->name, "_")];
                        }

                        $assessment[$key_tmp_assessment]['notemax'] = $final_notemax_for_assessment;
                    }

                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'] = $assessment;

                    // TODO: On va plutôt avoir la somme des notemax des matières pour lesquelles l'élèves a effectivement composé
                    $total_notemax_assessment = 0;

                    // on récupère toutes les évaluations où le type ci a composé
                    $evals_compose = Rating::select('idAssessment', 'idTypeEvaluation' ,'te.name as te_name', 'a.*')
                        ->join('type_evaluation as te', 'te.id','=','idTypeEvaluation')
                        ->join('assessments as a', 'a.id','=','ratings.idAssessment')
                        ->join('matter','matter.id','=','ratings.idMatter')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->where([
                            'idStudent' => $tabNote['user'][$i]['id'],
                            'idAssessmentType' => $request['idAssessmentType']
                        ])
                        ->get();

                    // on somme les notes des types_evaluations (pas des notemax)
                    foreach ($evals_compose as $item) {
                        $tmp_te_name = $item['te_name'];
                        $total_notemax_assessment += $item[Str::slug($tmp_te_name, '_')];
                    }

//                    $total_notemax_assessment = Assessment::select(DB::raw('SUM(notemax) as total_notemax'))
//                        ->from(function (Builder $query) use ($request, $tabNote, $i, $idOptionLevel) {
//                            $query->select('a.notemax', 'a.id')
//                                ->from('ratings AS r')
//                                ->join('assessments AS a', 'a.id', '=', 'r.idAssessment')
//                                ->where('r.idClasse', $request['idClasse'])
//                                ->where('r.idStudent', $tabNote['user'][$i]['id'])
//                                ->where('r.idAssessmentType', $request['idAssessmentType'])
//                                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
//                                    $query
//                                        ->join('matter', 'matter.id', '=', 'r.idMatter')
//                                        ->where('matter.idOptionLevel', $idOptionLevel);
//                                })
//                                ->groupBy('a.id', 'a.notemax');
//                        })
//                        ->value('total_notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        // On veut compter le nombre d'évaluations que cet élève a composé.
                        // Donc si il existe une note (sur table ratings) pour ce $k évaluation, on compte l'évaluation comme composé
                        $hasStudentWriteAssessment = Rating::where('idAssessment', $assessment[$k]['id'])
                            ->where('idStudent', $tabNote['user'][$i]['id'])
                            ->where('idAssessmentType', $request['idAssessmentType'])
                            ->count();

                        if($hasStudentWriteAssessment != 0){
                            $totalNbreEvaluationsComposes++;
                        }
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','type_evaluation.libelle','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

                        $totalSequence1 = null;
                        $totalSequence2 = null;
                        $totalSequence3 = null;
                        $totalSequence4 = null;
                        $totalSequence5 = null;
                        $totalSequence6 = null;
                        $totalSequence7 = null;
                        $totalSequence8 = null;

                        $total_note_assessment1 = null;
                        $total_note_assessment2 = null;
                        $total_note_assessment3 = null;
                        $total_note_assessment4 = null;
                        $total_note_assessment5 = null;
                        $total_note_assessment6 = null;
                        $total_note_assessment7 = null;
                        $total_note_assessment8 = null;
                        //$total_notemax_assessment = $total_notemax_assessment + $assessment[$k]['notemax'];

                        for ($l=0; $l < $typeEvaluation->count(); $l++) {
//                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }
//
                            if(!empty($assessment[$k]['orale'])){
                                if($typeEvaluation[$l]['name'] == "Orale")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['orale'];
                            }

                            if(!empty($assessment[$k]['ecrit'])){
                                if($typeEvaluation[$l]['name'] == "Ecrit")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['ecrit'];
                            }

                            if(!empty($assessment[$k]['written'])){
                                if($typeEvaluation[$l]['name'] == "Written")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['written'];
                            }

                            if(!empty($assessment[$k]['attitude'])){
                                if($typeEvaluation[$l]['name'] == "Attitude")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['attitude'];
                            }

                            if(!empty($assessment[$k]['savoir_etre'])){
                                if($typeEvaluation[$l]['name'] == "Savoir être")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['savoir_etre'];
                            }

                            if(!empty($assessment[$k]['pratical'])){
                                if($typeEvaluation[$l]['name'] == "Pratical")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['pratical'];
                            }

                            if(!empty($assessment[$k]['pratique'])){
                                if($typeEvaluation[$l]['name'] == "Pratique")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['pratique'];
                            }

                            $rating_exits = null;
                            for ($m=0; $m < $trimestre->count(); $m++) {
                                $assessmentType = AssessmentType::select('id','name')
                                    ->where('idSchool',$request['idSchool'])
                                    ->where('idSection',$request['idSection'])
                                    ->where('idTrimestre',$trimestre[$m]['id'])
                                    ->get();
//
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users','users.id','=','ratings.idStudent')
                                        ->where('users.deleted',0) // on ne récupère pas les notes des personnes supprimées
//                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('ratings.idAssessment',$assessment[$k]['id'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();
//    ----------------------------------------------- on ajoute des valeurs -----------------------------------------------
//                                    // On détermine le rang de cet étudiant sur cette évaluation précise
                                    $ratings['rang'] = (isset($ratings->value))
                                        ? Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->join('matter','matter.id','=','ratings.idMatter')
                                            ->join('users','users.id','=','ratings.idStudent')
                                            ->where('users.deleted',0) // on ne récupère pas les notes des personnes supprimées
                                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                            ->where('assessment_type.id',$assessmentType[$n]['id'])
                                            ->where('ratings.idClasse',$request['idClasse'])
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->where('ratings.value','>', $ratings->value)
                                            ->count() + 1
                                        : "-";
//
//                                    // On détermine le nombre de personnes ayant réussi (ils ont une note >= à note/2) pour cette évaluation précise (oral, écrit, pratique, ...)
                                    $tmp_note = Str::slug($typeEvaluation[$l]['name'], '_');
                                    $nbreSucceed = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users','users.id','=','ratings.idStudent')
                                        ->where('users.deleted',0) // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idClasse',$request['idClasse'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->where('ratings.value','>=', $assessment[$k][$tmp_note]/2)
                                        ->count();

                                    // Pour calculer la moyenne sur le typeEvaluation de cette matière, on divise par le nombre d'étudiants qui ont effectivement composé
                                    // (qui peut être inférieur à l'effectif réel de la classe)
                                    $effectifAssessmentTypeEvaluation = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
                                            'idAssessmentType' => $assessmentType[$n]['id'],
                                            'idTypeEvaluation' => $typeEvaluation[$l]['id']
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    $ratings['success_percentage'] = ($effectifAssessmentTypeEvaluation != 0)
                                        ? round(($nbreSucceed * 100) / $effectifAssessmentTypeEvaluation, 2)
                                        : null;
//
                                    // On détermine la moyenne générale de la classe sur cette évaluation
                                    $gen_avg = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users','users.id','=','ratings.idStudent')
                                        ->where('users.deleted',0) // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idClasse',$request['idClasse'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->sum('ratings.value');


                                    $tmp_type_evaluation_name = Str::slug($typeEvaluation[$l]['name'], "_");
                                    $tmp_type_evaluation_notemax = $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k][$tmp_type_evaluation_name];

                                    $ratings['g_avg'] = (($effectifAssessmentTypeEvaluation !=0) && ($tmp_type_evaluation_notemax > 0))
                                        ? number_format(($gen_avg*20) / ($effectifAssessmentTypeEvaluation*$tmp_type_evaluation_notemax), 2) //round($gen_avg / $effectifClasse, 2);
                                        : null;

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    // La note de l'élève sur cette matière/évaluation (tous typeEvaluation condonfus)
                                    $studentNoteOnAssessment = Rating::select('ratings.value as value')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->sum('ratings.value');

                                    // Les notes de tous les élèves sur cette matière/évaluation (tous typeEvaluation condonfus)
                                    $classeNotesOnAssesment = Rating::where('ratings.idClasse', $request['idClasse'])
                                        ->where('idAssessmentType', $assessmentType[$n]['id'])
                                        ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                        ->join('users','users.id','=','ratings.idStudent')
                                        ->where('users.deleted',0) // on ne récupère pas les notes des personnes supprimées
                                        ->groupBy('idStudent')
                                        ->selectRaw('SUM(value) as note')
                                        ->pluck('note')
                                        ->toArray();

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['note_on_assessment'] = (!is_null($studentNoteOnAssessment)) ? $studentNoteOnAssessment : null;
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['rank_on_assessment'] = (!is_null($studentNoteOnAssessment))
                                        ? count(array_filter($classeNotesOnAssesment, function($note) use ($studentNoteOnAssessment) {
                                            return $note > $studentNoteOnAssessment;
                                        })) + 1
                                        : null;

                                    $notemax = $assessment[$k]['notemax'];

                                    // On détermine le nombre d'élèves ayant composé cette évaluation
                                    $effectifAssessment = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
                                            'idAssessmentType' => $assessmentType[$n]['id'],
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    // On compte le nombre d'élèves ayant la moyenne sur cette évaluation
                                    $nbreSuccessOnAssessment = count(array_filter($classeNotesOnAssesment, function($note) use ($notemax) {
                                        return $note >= ($notemax/2);
                                    }));

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['nbreSuccessOnAssessment'] = ($nbreSuccessOnAssessment != 0 && $effectifAssessment!=0)
                                        ? ($nbreSuccessOnAssessment*100) / ($effectifAssessment) ?? 1
                                        : null;
//    ----------------------------------------------- on ajoute des valeurs -----------------------------------------------

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(isset($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch (mb_substr($assessmentType[$n]['name'], -1)) {
//                                            switch ($assessmentType[$n]['id']) {
                                                case "1":
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case "2":
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case "3":
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case "4":
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case "5":
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case "6":
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case "7":
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case "8":
                                                    $totalSequence8 = $totalSequence8 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment8 = $total_note_assessment8 + $ratings['value'];
                                                    }
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                    }
                                }

                                if($rating_exits == 3){
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }
                            }
                        }

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
                        $trimestre1 = null ;
                        $trimestre2 = null ;
                        $trimestre3 = null ;
                        if(empty($totalSequence1) || empty($totalSequence2) || empty($totalSequence3)){
                            $trimestre1 = array($totalSequence1,$totalSequence2,$totalSequence3,null);
                        }else if(!empty($totalSequence1) && !empty($totalSequence2) && !empty($totalSequence3)){
                            $trimestre1 = array($totalSequence1,$totalSequence2,$totalSequence3,$totalSequence1+$totalSequence2+$totalSequence3);
                        }

                        if(empty($totalSequence4) || empty($totalSequence5) || empty($totalSequence6)){
                            $trimestre2 = array($totalSequence4,$totalSequence5,$totalSequence6,null);
                        }else if(!empty($totalSequence41) && !empty($totalSequence5) && !empty($totalSequence6)){
                            $trimestre2 = array($totalSequence4,$totalSequence5,$totalSequence6,$totalSequence4+$totalSequence5+$totalSequence6);
                        }

                        if(empty($totalSequence7) || empty($totalSequence8)){
                            $trimestre3 = array($totalSequence7,$totalSequence8,null);
                        }else if(!empty($totalSequence7) && !empty($totalSequence8)){
                            $trimestre3 = array($totalSequence7,$totalSequence8,$totalSequence7+$totalSequence8);
                        }

                        $sommeTrimestre = array($trimestre1,$trimestre2,$trimestre3);
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;
                        $totalSequence7User = $totalSequence7User + $totalSequence7;
                        $totalSequence8User = $totalSequence8User + $totalSequence8;
                    }
                }

//                if($total_notemax_assessment != 0){
                $tabNote['user'][$i]['totalNoteMax'] = $total_notemax_assessment;
                $tabNote['user'][$i]['totalSequence1User'] = $totalSequence1User;
                $tabNote['user'][$i]['totalSequence2User'] = $totalSequence2User;
                $tabNote['user'][$i]['totalSequence3User'] = $totalSequence3User;
                $tabNote['user'][$i]['totalSequence4User'] = $totalSequence4User;
                $tabNote['user'][$i]['totalSequence5User'] = $totalSequence5User;
                $tabNote['user'][$i]['totalSequence6User'] = $totalSequence6User;
                $tabNote['user'][$i]['totalSequence7User'] = $totalSequence7User;
                $tabNote['user'][$i]['totalSequence8User'] = $totalSequence8User;
                $tabNote['user'][$i]['moyenneSequence1'] = ($total_notemax_assessment!=0) ? ($totalSequence1User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence2'] = ($total_notemax_assessment!=0) ? ($totalSequence2User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence3'] = ($total_notemax_assessment!=0) ? ($totalSequence3User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence4'] = ($total_notemax_assessment!=0) ? ($totalSequence4User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence5'] = ($total_notemax_assessment!=0) ? ($totalSequence5User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence6'] = ($total_notemax_assessment!=0) ? ($totalSequence6User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence7'] = ($total_notemax_assessment!=0) ? ($totalSequence7User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence8'] = ($total_notemax_assessment!=0) ? ($totalSequence8User * 20) / $total_notemax_assessment : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence1'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence1User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence2'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence2User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence3'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence3User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence4'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence4User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence5'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence5User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence6'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence6User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence7'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence7User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
//                $tabNote['user'][$i]['moyenneSequence8'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence8User * 20)) / $total_notemax_assessment, 2) : null; //number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
//                }
                $tabNote['user'][$i]['totalNbreEvaluationsComposes'] = $totalNbreEvaluationsComposes;
            }

            /******************************************************Debut calcul rang ********************************************/

            //TODO: On compte le nombre d'évaluations que chaque enfant doit effectuer...
            // PS: si après il a composé -70% de toutes les évaluations,
            // (1) on ne va pas l'inclure dans le calcul de la moyenne générale de la classe
            // (2) on ne l'inclut pas dans les moyennes et donc il n'aura pas de rang comme les autres
            $nbreTotalEvaluations = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                ->join('matter','matter.id','=','assessments.idMatter')
                ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                ->where('assessments.idSchool',$request['idSchool'])
                ->where('assessments.idSection',$request['idSection'])
                ->where('assessments.idClasse',$request['idClasse'])
                ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->count();

            // Tableau des séquences
            $sequences = ['moyenneSequence1', 'moyenneSequence2', 'moyenneSequence3', 'moyenneSequence4', 'moyenneSequence5', 'moyenneSequence6', 'moyenneSequence7', 'moyenneSequence8'];

            // Tableau associatif pour stocker les rangs pour chaque séquence
            $rangsParSequence = [];

            $moyennesGenerales = []; // moyennes générales de la classe

            // Boucle sur chaque séquence
            foreach ($sequences as $sequence) {
                // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                $moyennes = [];
                foreach ($tabNote['user'] as $userId => $user) {
                    $totalNbreEvaluationsComposes = $user['totalNbreEvaluationsComposes'];

                    if(($totalNbreEvaluationsComposes*100 / $nbreTotalEvaluations) >= 70){
                        $moyennes[$userId] = $user[$sequence];
                    }
                }

                // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                arsort($moyennes);

                $moyennesGenerales[] = (count($moyennes) > 0)
                    ? array_sum($moyennes) / count($moyennes)
                    : null; // on détermine la moyenen générale de la classe pour cette séquence

                // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                $rangs = [];
                $rank = 1;
                foreach ($moyennes as $userId => $moyenne) {
                    $rangs[$userId] = $rank;
                    $rank++;
                }

                // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                foreach ($tabNote['user'] as $userId => &$user) {
                    $user['rang_'.$sequence] = @$rangs[$userId] ?? null; // certains ne seront pas dans ce tableau de $rags
                }

                // Stocker les rangs dans le tableau global
                $rangsParSequence[$sequence] = $rangs;
            }

            // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément

            /******************************************************fin calcul rang ********************************************/

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            $tabNote['classTotalNotesMax'] = Assessment::select(DB::raw('SUM(notemax) as total_notemax'))
                ->from(function (Builder $query) use ($request, $idOptionLevel) {
                    $query->select('a.notemax')
                        ->from('ratings AS r')
                        ->join('assessments AS a', 'a.id', '=', 'r.idAssessment')
                        ->where('r.idClasse', $request['idClasse'])
                        ->where('r.idAssessmentType', $request['idAssessmentType'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query
                                ->join('matter', 'matter.id', '=', 'r.idMatter')
                                ->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->groupBy('a.id', 'a.notemax');
                })
                ->setBindings([$request['idClasse'], $request['idAssessmentType']])
                ->value('total_notemax');

            $tabNote['nbreTotalEvaluations'] = $nbreTotalEvaluations;
            $tabNote['moyennesGenerales'] = $moyennesGenerales;

            return $this->sendResponse($tabNote, 'Bulletins');
        }
        catch (\Throwable $th) {
            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Générer bulletin(s) trimestre du Primaire
     *
     * @param GenererBulletinPrimaireTrimestreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinPrimaireTrimestre(GenererBulletinPrimaireTrimestreRequest $request)
    {
        ini_set('max_execution_time', 300);
        set_time_limit(0);

        try {
            /**
             * PAYLOAD VALIDE
             * BD: juniors
             * { "username":"fondateur", "password":"000000", "idClasse": 2, "idOptionLevel": 1, "idAssessmentType": 1, "idTrimestre":1, "route": "juniors", "lang": "fr" }
             *
             * BD: u989816557_lesalouettes
             * { "username":"fondateur", "password":"000000", "idClasse":18, "idTrimestre":7, "idUser":208, "lang":"en", "route":"juniors" }
             */

            $this->createDirectory('pdfs');
            ini_set('max_execution_time', 300);
            //TODO: Récupérer les données ici pour le primaire
            $requestData = $request->validated();

            $classe = Classes::find($requestData['idClasse']);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $trimestre = Trimestre::find($request->idTrimestre);
            $num_trimestre = mb_substr($trimestre->name, -1, 1);
            $assessmentType = $trimestre->assessmentTypes()->first();
            $num_sequence = $assessmentType->name[strlen($assessmentType->name)-1];

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $requestData['idAssessmentType'] = $assessmentType->id;
            $requestData['typeBulletin'] = "trimestre";
            $idUser = $requestData['idUser'] ?? null; //NB: On va garder cette valeur parce qu'on ne veut pas l'envoyer au endpoint qui récupère les notes de tous les étudiants
            unset($requestData['idUser']);

//Block de vérification des insolvables
            $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
            //return $insolvables;

            //Vérification directe si on veut pour un seul utilisateur
            if($idUser != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                if(!is_null($request['forSolvables']) && $request['forSolvables'] && !$this->isSolvable($insolvables, $idUser)){
                    return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                }
            }
            else if ($idUser != null && !$this->isSolvable($insolvables, $idUser)){
                return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
            }
//Fin de vérification des insolvables

            //TODO: TOUJOURS désactiver le Cache avant de push
            Cache::forget("infosBulletinsPrimaireTrimestre" . $request->idClasse);
            $infosBulletins = (object) cache()->remember("infosBulletinsPrimaireTrimestre".$request->idClasse, 36000, function() use ($requestData) {
                return $this->bulletinPrimaireSequence($requestData);
            });

            if(count($infosBulletins->user) == 0){
                return $this->sendError("Pas d'élèves avec de notes pour ces données");
            }

            $json_data = $infosBulletins;

//            return response()->json([
//                'da' => $json_data
//            ]);

            $zip_file = "Bul-prim-".Str::slug($classe->name)."-trimestre-".Str::slug($trimestre->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $route = $request->route;
            $liensBulletins = array();

            $moyenneStudents = array();
            $sequence_name = "moyenneSequence".$num_trimestre;

            $moyenne_generale = round(@$infosBulletins->moyennesGenerales[$num_trimestre-1], 2);

            foreach ($infosBulletins->user as $key => $userData) {
                $tmp_moyenne_trim = 0; $nbreMoyennes = 0;

                if(!is_null($userData->moyenneTrim)) $moyenneStudents[] = $userData->moyenneTrim;

//                $tmp_moyenne_trim
//
//                foreach($trimestre->assessmentTypes as $sequence){
//                    $tmp_moyenne_sequence = "moyenneSequence" . mb_substr($sequence->name, -1, 1);
//                    $tmp_moyenne_trim += $userData->$tmp_moyenne_sequence;
//
//                    if($userData->$tmp_moyenne_sequence > 0) $nbreMoyennes++;
//                }
//
//                $tmp_moyenne_trim = $tmp_moyenne_trim / $nbreMoyennes;
//
////                $infosBulletins->user[$key]->moyenneTrim = $tmp_moyenne_trim;
//                if($nbreMoyennes > 0) $moyenneStudents[] = $tmp_moyenne_trim;
            }

            arsort($moyenneStudents);

            $moyenneStudents = array_values($moyenneStudents);

//            return response()->json($moyenneStudents);

            if(!is_null($request->idUser)){
                $idUser = $request->idUser;

                $infosBulletins->user = collect($infosBulletins->user)->filter(function($user) use ($idUser) {
                    return $user->id == $idUser;
                })->values();
            }

            if(count((array)$infosBulletins->user) == 0){
                return $this->sendError("idStudent {$idUser} invalide");
            }

            // On trouve les moyennes en grades (je sais pas comment dire ça ... regarde juste le code et tu vas comprendre)
            $legend_of_grade = [
                'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud < 10;
                })),
                'nye_color' => "db0b32",
                'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 10 && $moyenneStud < 15;
                })),
                'ae_color' => "fdaa3e",
                'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 15 && $moyenneStud < 18;
                })),
                'me_color' => "0080ff",
                'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 18;
                })),
                'abe_color' => "008000",
            ];

            for ($case = 0; $case < count($infosBulletins->user); $case++){
                $user = $infosBulletins->user[$case];

                //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                if($this->isSolvable($insolvables, $user->id) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))) {

                    $nbreReussite = count(array_filter($moyenneStudents, function ($moyenneStud) {
                        return $moyenneStud >= 10;
                    })); // Nombre d'élèves ayant plus de 10/20 de moyenne

                    $dompdf = new Dompdf();

                    $totalNotes = 0;
                    foreach ($user['totalNoteMaxes'] as $k => $totalNoteMax) {
                        $totalNotes += $user->{"totalSequence".$k."User"};
                    }

//                    return [
//                        'moyennes' => $moyenneStudents,
//                        'rang' => array_search($user->moyenneTrim, $moyenneStudents) + 1,
//                        'moy' => $user->moyenneTrim
//                    ];
                    // On calcule la moyenne trimestrielle
                    // TODO: On ajoute le rang trimestriel de l'élève
//                    $user['moyenneTrim'] = $totalNotes*20 / safeArraySum($user['totalNoteMaxes']);
                    $user['rangTrim'] = array_search($user->moyenneTrim, $moyenneStudents) + 1;
//                    count(array_filter($moyenneStudents, function ($moyenneStud) use($user) {
//                            return $moyenneStud > $user->moyenneTrim;
//                        }));

                    $data = [
                        'effectifClasse' => $json_data->effectifClasse,
                        'moyenneStudents' => $moyenneStudents,
                        'user' => $user,
                        'section' => $section,
                        'trimestre' => $trimestre,
                        'assessmentTypes' => $trimestre->assessmentTypes,
                        'school' => $school,
                        'establishment' => $establishment,
                        'code_couleurs' => $code_couleurs,
                        'num_trimestre' => $num_trimestre, // 1, 2, 3, ....
                        'class_average' => safeArraySum($moyenneStudents, true),
                        'class_success_percentage' => round(($nbreReussite * 100) / $json_data->effectifClasse, 2),
                        'legend_of_grade' => $legend_of_grade,
                        'route' => $route,
                        'classe' => $classe,
                        'teacher_principal' => $classe->teacher,
                    ];

//                    return $data;

                    $filename = Str::slug($json_data->user[$case]->name) . '_Trimestre';

                    $folder = "bulletin.primaire.trimestre";

                    (view()->exists($folder . "." . $route))
                        ? $vue = $folder . "." . $route
                        : $vue = $folder . ".default";

                    // Récupérer la vue
                    $view = View::make($vue)->with($data);
                    //$view = View::make('receipt')->with($formattedData);

                    // Récupérer le contenu de la vue
                    $html = $view->render();

                    // Charger le contenu HTML dans Dompdf
                    $dompdf->loadHtml($html);

                    // (Optionnel) Définir la taille et l'orientation du papier
                    $dompdf->setPaper('A4', 'portrait');

                    // Exécuter le rendu du PDF
                    $dompdf->render();

                    file_put_contents(public_path("pdfs/$filename-bul-prim-trim.pdf"), $dompdf->output());

                    if (count($infosBulletins->user) > 1) {

                        $zip->addFile("pdfs/$filename-bul-prim-trim.pdf");

                        $liensBulletins[] = public_path("pdfs/$filename-bul-prim-trim.pdf");
                    } else {
                        return $this->sendResponse(asset("pdfs/$filename-bul-prim-trim.pdf"), "Bulletin primaire");
                    }
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin primaire");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * PV Primaire Séquence / Trimestre
     * Abiscom :
     *{ "idClasse": 6, "idTrimestre": 1, // "idAssessmentType": 1, // "idUser": 1516, "sortUsers": "merit", "route": "abiscom", "lang": "en"}
     *
     * Juniors :
     *
     *
     * @param PvPrimaireTrimestreRequest $request
     * @return JsonResponse
     */
    public function pvPrimaireTrimestreOuSequentielle(PvPrimaireTrimestreRequest $request)
    {
        try{

            ini_set('max_execution_time', 300);


            $erreurContraintes = $this->contraintes($request);
            $idSequences = [];
            if (is_string($erreurContraintes)) {
                return $this->sendError($erreurContraintes);
            }


            if(!is_null($request["idAssessmentType"])){
                $response = $this->classSeq($request['idClasse'], $request['idOptionLevel'], $request['idAssessmentType'])["sequentielle"];

                if(sizeof($response->IdStudEvaluated) <= 0){
                    return $this->sendError(__('bulletin.not_found_assessments'));
                }
                $idSequences = [$request['idAssessmentType']];
            }
            else if(!is_null($request["idTrimestre"])){
                $response = $this->classTrimestre($request['idClasse'], $request['idOptionLevel'], $request['idTrimestre']);

                if(sizeof($response->IdStudEvaluated) <= 0){
                    return $this->sendError(__('bulletin.not_found_assessments'));
                }
                $idSequences = AssessmentType::where("idTrimestre", $request["idTrimestre"])
                    ->pluck('id'); // Récupère uniquement les IDs des séquences
            }
            else{

                $response = $this->classTrimestre($request['idClasse'], $request['idOptionLevel']);

                if(sizeof($response->IdStudEvaluated) <= 0){
                    return $this->sendError("Aucun élève évalué pour ce trimestre");
                }
                $idSequences = AssessmentType::pluck('id'); // Récupère uniquement les IDs des séquences

//                return $response;

//                return json_decode(json_encode($response), true);
            }

            $response->idClasse = $request['idClasse'];

            // Filtrer les clés de l'objet $response pour ne garder que celles qui sont des entiers
            $students = $response->IdStudEvaluated;
            $evaluationsId = []; // Initialiser un tableau pour stocker les évaluations
            $codeMatieres = [];


            // Parcourir chaque élève identifié par les clés entières
            foreach ($students as $student) {
                // Filtrer les évaluations pour cet élève, c'est-à-dire récupérer les clés des matières qui sont des entiers
                $studentEvaluations = array_filter(array_keys(get_object_vars($response->$student)), 'is_int');

                // Ajouter les évaluations de l'élève au tableau des évaluations (tableau plat)
                $evaluationsId = array_unique(array_merge($evaluationsId, $studentEvaluations));
            }

            $codeMatieres = Assessment::select("matter.id", "matter.code", "matter.name", "assessments.notemax")
                    ->join("matter", "matter.id", "=", "assessments.idMatter")
                    ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
                    ->where("assessments.idClasse", $request["idClasse"])
                    ->where("matter.idOptionLevel", $request["idOptionLevel"]?? null)
                    ->whereIn("assessments_has_assessment_type.assessment_type_id", $idSequences)
                    ->get()
                    ->groupBy('id') // Regrouper par ID
                    ->map(function (Collection $group) {
                        // Fusionner les données du groupe
                        $first = $group->first(); // Premier élément pour les valeurs communes
                        $codeMatiere = new stdClass();
                        $codeMatiere->id = $first->id;
                        $codeMatiere->code = $first->code;
                        $codeMatiere->nom = $first->name;

                        // Filtrer les éléments ayant une notemax valide
                        $filteredItems = $group->filter(function ($item) {
                            return $item->notemax !== null && $item->notemax > 0;
                        });

                        // Calculer la moyenne seulement sur les éléments valides
                        $totalNotemax = $filteredItems->sum('notemax');
                        $countNotemax = $filteredItems->count(); // Nombre d'éléments valides

                        $codeMatiere->notemax = $countNotemax > 0 ? $totalNotemax / $countNotemax : 0; // Éviter la division par zéro

                        return $codeMatiere;
                    })
                    ->values()
                    ->sortBy('code')
                    ->toArray();





            // return response()->json($codeMatieres);

            //On récupère les informations de la classe
            $classe =Classes::select("classes.idSchool", "classes.name", "section.name as nomSection")
                ->join("section", "section.id", "=", "classes.idSection")
                ->where('classes.id', ($request['idClasse']))->first();


            //On recupere les informations de l'école
            $ecole = School::select("name", "logo")
                ->where("id", $classe->idSchool)->first();


            //Statistiques de l'évaluation
            if(isset($request["sortUsers"]) && $request["sortUsers"] == 'merit'){
                $statistiques = $this->getStatistiques($response, $students, $request["sortUsers"], $request["styleMaternelle"]);
            }
            else{
                $statistiques = $this->getStatistiques($response, $students, null, $request["styleMaternelle"]);
            }

            //Formatage de donne pour le remplissage du template
            $data = [
                "ecole" => $ecole,
                "classe" => $classe,
                "details_valuation" => $statistiques["evaluations"],
                "code_matieres" => $codeMatieres,
                "legend_of_grade" => $statistiques["legend_of_grade"],
                "moyenneGenerale" => $statistiques["moyenneGenerale"],
                "moyennes" => $statistiques["moyennes"],
                "code_couleurs" => $this->getCodeCouleur(),
                'academic_year' => AcademicYear::getCurrent()->label ?? '-'
            ];

            $evalName = isset($statistiques["evaluations"]->nom) ? $statistiques["evaluations"]->nom : '';
            $filename = "pv-" . Str::slug($classe->name) . ($evalName ? "-" . Str::slug($evalName) : "");

            if($request->styleMaternelle){
                return $this->genererDocuments($data, 'documents.pv.pv-maternelle-trimestriel', $filename);
            }else{
                return $this->genererDocuments($data, 'documents.pv.pv-primaire-trimestriel', $filename);
            }
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            $log_msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($log_msg);

            $msg = ($th->getMessage() === "Division by zero") ? "Division by zero" :  __('app.error_occured');

            return $this->sendError($msg, [], 404, $log_msg);
        }
    }

    /**
     * Générer bulletin(s) primaire séquence/trimestre/annuel
     *
     * NOUVELLE STRUCTURE
     * @param GenererBulletinPrimaireTrimestreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinPrimaireTrimestreNew(GenererBulletinPrimaireTrimestreRequest $request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             * BD: juniors
             *
             *  { "username":"fondateur", "password":"000000", "idClasse": 2, "idOptionLevel": 1, "idAssessmentType": 1, "idTrimestre":1, "route": "juniors", "lang": "fr" }
             *
             *  BD: u989816557_lesalouettes
             *  { "username":"fondateur", "password":"000000", "idClasse":18, "idTrimestre":7, "idUser":208, "lang":"en", "route":"juniors" }
             */

            $this->createDirectory('pdfs');
            ini_set('max_execution_time', 300);
            //TODO: Récupérer les données ici pour le primaire
            $requestData = $request->validated();

            $classe = Classes::find($requestData['idClasse']);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);

            if(!is_null($request['idAssessmentType'])){
                $assessmentTypes = AssessmentType::where('id', $request['idAssessmentType'])->get();
                $trimestre = Trimestre::find($assessmentTypes->first()->idTrimestre);
            }else if(!is_null($request['idTrimestre'])){
                $trimestre = Trimestre::find($request->idTrimestre);

                $assessmentTypes = AssessmentType::where('idTrimestre', $trimestre->id)->get();
            }else{
                throw new \Exception("Bulletin annuel non disponible. Sinon veuillez vérifier les informations soumises");
            }

            $num_trimestre = $trimestre->name[strlen($trimestre->name)-1];

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $idUser = $requestData['idUser'] ?? null; //NB: On va garder cette valeur parce qu'on ne veut pas l'envoyer au endpoint qui récupère les notes de tous les étudiants
//            unset($requestData['idUser']);


//Block de vérification des insolvables
            $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
            //return $insolvables;

            //Vérification directe si on veut pour un seul utilisateur
            if($idUser != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                if(!is_null($request['forSolvables']) && $request['forSolvables'] && !$this->isSolvable($insolvables, $idUser)){
                    return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                }
            }
            else if ($idUser != null && !$this->isSolvable($insolvables, $idUser)){
                return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
            }
//Fin de vérification des insolvables

// Vérification spécifique pour parents et élèves : paiement de la tranche 2
if (in_array($this->getRole()->id, [7,8]) && $idUser != null) {
    $requestDataX = $request->validated();
    $requestDataX['idSchool'] = $classe->idSchool;
    $requestDataX['nameTranche'] = 2;
    $insolvablesTranche2 = $this->pensionUserService->insolvablePensionUser($requestDataX)['data'];
    if (in_array($idUser, $insolvablesTranche2)) {
        return $this->sendError("Veuillez payer la tranche 2 pour télécharger le bulletin");
    }
}

//TODO: TOUJOURS désactiver le Cache avant de push
            Cache::forget("infosBulletinsPrimaireTrimestre" . $request->idClasse);
            $infosBulletins = cache()->remember("infosBulletinsPrimaireTrimestre".$request->idClasse, 36000, function() use ($requestData) {
                return $this->structureBulletinPrimaire($requestData)->getData();
            });

            if($infosBulletins->success != true || $infosBulletins->data->effectifClasse == 0){
                return $this->sendError($infosBulletins->message);
            }

            $json_data = $infosBulletins->data;

//            return response()->json($json_data);

            $zip_file = "Bul-prim-".Str::slug($trimestre->name)."-".Str::slug($classe->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $route = $request->route;
            $liensBulletins = array();

            $moyenneStudents = $infosBulletins->data->moyennesGenerales->{$trimestre->id}->moyennesStudents;

            $moyenneStudents = (array)$moyenneStudents;
            arsort($moyenneStudents);

            $moyenneStudents = array_values($moyenneStudents);

            if(!is_null($request->idUser)){
                $idUser = $request->idUser;

                $infosBulletins->data->user = collect($infosBulletins->data->user)->filter(function($user) use ($idUser) {
                    return $user->id == $idUser;
                })->values();
            }

            if(count((array)$infosBulletins->data->user) == 0){
                return $this->sendError("idStudent {$idUser} invalide");
            }

            // On trouve les moyennes en grades (je sais pas comment dire ça ... regarde juste le code et tu vas comprendre)
            $legend_of_grade = [
                'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud < 10;
                })),
                'nye_color' => "db0b32",
                'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 10 && $moyenneStud < 15;
                })),
                'ae_color' => "fdaa3e",
                'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 15 && $moyenneStud < 18;
                })),
                'me_color' => "0080ff",
                'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 18;
                })),
                'abe_color' => "008000",
            ];

            for ($case = 0; $case < count($infosBulletins->data->user); $case++){
                $user = $infosBulletins->data->user[$case];

                //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                if($this->isSolvable($insolvables, $user->id) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))){

                    $nbreReussite = count(array_filter($moyenneStudents, function($moyenneStud) {
                        return $moyenneStud >= 10;
                    })); // Nombre d'élèves ayant plus de 10/20 de moyenne

                    $dompdf = new Dompdf();

                    $data = [
                        'moyennesGenerales' => $json_data->moyennesGenerales->{$trimestre->id},
                        'user' => $user,
                        'effectifClasse' => $json_data->effectifClasse,
                        'classe' => $classe,
                        'teacher_principal' => $classe->teacher,
                        'section' => $section,
                        'trimestre' => $trimestre,
                        'assessmentTypes' => $assessmentTypes,
                        'school' => $school,
                        'establishment' => $establishment,
                        'code_couleurs' => $code_couleurs,
                        'num_trimestre' => $num_trimestre, // 1, 2, 3, ....
                        'moyenneStudents' => $moyenneStudents,
    //                    'first_moyenne' => $moyenneStudents[0],
    //                    'last_moyenne' => end($moyenneStudents),
    //                    'class_average' => $moyenne_generale,
    //                    'class_success_percentage' => round(($nbreReussite*100) / $json_data->effectifClasse, 2),
                        'legend_of_grade' => $legend_of_grade
                    ];

                    return $data;

                    $filename = Str::slug($json_data->user[$case]->name);

                    if(isset($requestData['idAssessmentType'])){
                        $folder = "bulletin.primaire.sequence";
                    }else if(isset($requestData['idTrimestre'])){
                        $folder = "bulletin.primaire.trimestre";
                    }else{
                        die('PAS DISPONIBLE');
                    }

                    (view()->exists($folder."." . $route))
                        ? $vue = $folder."." . $route
                        : $vue = $folder.".default-new";

                    // Récupérer la vue
                    $view = View::make($vue)->with($data);
                    //$view = View::make('receipt')->with($formattedData);

                    // Récupérer le contenu de la vue
                    $html = $view->render();

                    // Charger le contenu HTML dans Dompdf
                    $dompdf->loadHtml($html);

                    // (Optionnel) Définir la taille et l'orientation du papier
                    $dompdf->setPaper('A4', 'portrait');

                    // Exécuter le rendu du PDF
                    $dompdf->render();

                    file_put_contents(public_path("pdfs/$filename-bulletin-primaire.pdf"), $dompdf->output());

                    if(count($infosBulletins->data->user) > 1){

                        $zip->addFile("pdfs/$filename-bulletin-primaire.pdf");

                        $liensBulletins[] = public_path("pdfs/$filename-bulletin-primaire.pdf");
                    }else{
                        return $this->sendResponse(asset("pdfs/$filename-bulletin-primaire.pdf"), "Bulletin primaire");
                    }
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin primaire");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function structureBulletinPrimaire(array $request){
        try {

            if(isset($request['idAssessmentType'])){
                $idAssessmentType = $request['idAssessmentType'];
                $assessmentType = AssessmentType::find($idAssessmentType);

                $trimestre = Trimestre::find($assessmentType->idTrimestre);

                $idTrimestre = $assessmentType->idTrimestre;

                $sequences = AssessmentType::where('id' , $idAssessmentType)->get(); // OUI OUI OUI ... il y'aura un seul élément !
            }else if(!is_null($request['idTrimestre'])){
                $idTrimestre = $request['idTrimestre'];

                $trimestre = Trimestre::select('id','name')->find($request['idTrimestre']);
                $idTrimestre = $request['idTrimestre'];
                $sequences = AssessmentType::where('idTrimestre', $trimestre->id)->get();

                $idAssessmentType = null; // on ne veut pas une séquence particulière
            }else{
                throw new Exception("Bulletin annuel non disponible. Sinon veuillez vérifier les informations soumises");
            }

            $totalEvalsClasseParSequence = array();

            foreach ($sequences as  $tmpAssessmentType) {
                $totalEvalsClasseParSequence[] = Assessment::join('assessments_has_assessment_type as ahat', 'ahat.assessment_id','=','assessments.id')
                    ->where('ahat.assessment_type_id', $tmpAssessmentType->id)
                    ->where('assessments.idClasse', $request['idClasse'])
                    ->count();
            }

            $tabNote = array();

            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $classe = Classes::find($request['idClasse']);

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $users = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.nationality as nationality','users.city as city','users.photo as photo',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->whereIn('ratings.idAssessmentType', $sequences->pluck('id')->toArray())
                ->where('users.idClasse',$request['idClasse'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->join('matter','matter.id','=','ratings.idMatter')
                        ->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->where('users.deleted',0)
                ->distinct('users.id')
                ->orderBy("users.name", "asc")
                ->get()
                ->toArray();

            $tabNote['effectifClasse'] = count($users);
            $tabNote['user'] = $users;

            $matterGroups = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                ->where('matter_group_has_level.level_id', $level_classe['idLevel'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->where('matter_group.idOptionLevel', $idOptionLevel);
                })
                ->where('matter_group.idSchool',$request['idSchool'])
                ->where('matter_group.idSection',$request['idSection'])
                ->orderBy("id", "asc")
                ->get();

            if(count($users) == 0){
                throw new Exception("Aucun élève trouvé avec ces paramètres");
            }

            foreach ($users as $kU => $user) {
                $tmp_user_id = $user['id'];

                foreach($matterGroups as $keyMatterGroup => $matterGroup) {
                    $matters = Matter::select('matter.id', 'matter.name as name', 'matter.libelle as libelle', 'matter.code')
                        ->join('matter_group_has_matter as mghm', 'mghm.matter_id','=','matter.id')
                        ->join('assessments', 'assessments.idMatter', '=','matter.id')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query
                                ->join('matter_group as mg', 'mg.id','=','mghm.matter_group_id')
                                ->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
                        ->distinct('matter.id')
                        ->where('mghm.matter_group_id', $matterGroup->id)
                        ->where('assessments.idClasse', $classe->id)
                        ->where('matter.assessment', 1)
                        ->orderBy('matter.code')
                        ->get();

                    foreach ($matters as $keyMatter => $matter) {
                        $trimestres = Trimestre::select('id', 'name')
                            ->where('idSchool', $classe->idSchool)
                            ->where('idSection', $classe->idSection)
                            ->when(!is_null($idTrimestre), function($query) use ($idTrimestre){
                                $query->where('id', $idTrimestre);
                            })
                            ->get();

                        foreach ($trimestres as $keyTrimestre => $trimestre) {
                            $sequences = AssessmentType::select('id', 'name')
                                ->where('idTrimestre', $trimestre->id)
                                ->when(!is_null($idAssessmentType), function($query) use ($idAssessmentType){
                                    $query->where('id', $idAssessmentType);
                                })
                                ->get();

                            foreach ($sequences as $keySequence => $sequence) {
                                $evaluation = Assessment::select('assessments.id','notemax','orale','oral','pratique','ecrit','written','attitude','savoir_etre','pratical')
                                    ->join('assessments_has_assessment_type as ahat', 'ahat.assessment_id', '=', 'assessments.id')
                                    ->where('assessments.idMatter', $matter->id)
                                    ->where('ahat.assessment_type_id', $sequence->id)
                                    ->where('assessments.idClasse', $classe->id)
                                    ->without('assessmentTypes')
                                    ->first();

                                // récupérer TOUS les types d'évaluations des évaluations de cette matière, TOUTES séquences confondues
                                $typesEvaluationsIDs = AssessmentHasTypeEvaluation::select('type_evaluation_id')
                                    ->join('assessments', 'assessments.id','=','assessments_has_type_evaluation.assessment_id')
                                    ->join('matter','matter.id','=','assessments.idMatter')
                                    ->where('assessments.idMatter', $matter->id)
                                    ->where('assessments.idClasse', $request['idClasse'])
                                    ->distinct()
                                    ->pluck('type_evaluation_id');

                                $typesEvaluations = TypeEvaluation::select('id','name','libelle')->whereIn('id', $typesEvaluationsIDs)
                                    ->get();

//                                    TypeEvaluation::select('type_evaluation.id','type_evaluation.name','type_evaluation.libelle')
//                                    ->join('assessments_has_type_evaluation as ahte', 'ahte.type_evaluation_id', '=', 'type_evaluation.id')
//                                    ->join('assessments', 'assessments.id', '=', 'ahte.assessment_id')
//                                    ->join('assessments_has_assessment_type as ahat', 'ahat.assessment_id', '=', 'assessments.id')
//                                    ->whereIN('ahat.assessment_type_id', $sequences->pluck('id')->toArray())
//                                    ->where('assessments.idMatter', 28)
////                                    ->where('assessments.idMatter', $matter->id)
//                                    ->distinct()
//                                    ->get();

                                $notesOnAssessmentForAssessmentType = array();
                                // il faut aussi les détails de chaque type evaluation sur le trimestre (note;class_avg;success_percentage;...)
                                foreach ($typesEvaluations as $keyTypeEvaluation => $typesEvaluation){
                                    $notemax_type_evaluation = $evaluation[Str::slug($typesEvaluation->name, "_")];

                                    $note = Rating::select('value','observation')
//                                        ->where('idMatter', $matter->id)
                                        ->where('idAssessment', $evaluation['id'])
                                        ->where('idTypeEvaluation', $typesEvaluation->id)
                                        ->where('idAssessmentType', $sequence->id)
                                        ->where('idStudent', $tmp_user_id)
                                        ->first();
                                    $notesDesEtudiantsSurTypeEvaluation = Rating::select(DB::raw("SUM(value) as valeur"), 'idStudent')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idAssessment', @$evaluation['id'])
                                        ->where('ratings.idAssessmentType', $sequence->id)
                                        ->where('ratings.idClasse', $request['idClasse'])
                                        ->where('ratings.idTypeEvaluation', $typesEvaluation->id)
                                        ->groupBy('idStudent')
                                        ->pluck('valeur')->toArray();
//
//                                    // TODO: détails (rang, %s; moy.gen) sur le type d'eval de la matière
                                    $note['notemax'] = $notemax_type_evaluation;
                                    $note['rang'] = (!empty($note) && isset($note->value))
                                        ? count(array_filter($notesDesEtudiantsSurTypeEvaluation, function($value) use ($note) {
                                            return $value > $note->value;
                                        })) + 1
                                        : null;
                                    $note['class_avg'] = (!empty($notesDesEtudiantsSurTypeEvaluation))
                                        ? array_sum($notesDesEtudiantsSurTypeEvaluation) / count($notesDesEtudiantsSurTypeEvaluation)
                                        : null;
                                    $note['class_avg_on_20'] = (!empty($notesDesEtudiantsSurTypeEvaluation) && $notemax_type_evaluation>0)
                                        ? (array_sum($notesDesEtudiantsSurTypeEvaluation) / count($notesDesEtudiantsSurTypeEvaluation)) * 20 / $notemax_type_evaluation
                                        : null;
                                    $note['class_success_percentage'] = (!empty($notesDesEtudiantsSurTypeEvaluation))
                                        ? count(array_filter($notesDesEtudiantsSurTypeEvaluation, function($value) use ($notemax_type_evaluation){
                                            return $value >= $notemax_type_evaluation/2;
                                        }))*100 / count($notesDesEtudiantsSurTypeEvaluation) // on divise par le nombre d'étudiants qui on composé la matière et non juste par l'effectif de la classe
                                        : null;
//
                                    $typesEvaluations[$keyTypeEvaluation]->notemax = $evaluation[Str::slug($typesEvaluations[$keyTypeEvaluation]->name, "_")]; // on récupère la notemax du typeEvaluation sur Assessment
                                    $typesEvaluations[$keyTypeEvaluation]->rating = (!is_null($note)) ? $note : null;
                                    $notesOnAssessmentForAssessmentType[] = (!is_null($note)) ? $note : null;
                                }

                                $evaluation['types_evaluations'] = $typesEvaluations->toArray();
                                $sequences[$keySequence]->assessment = $evaluation;

                                $maNoteSurMatiere = Rating::select('value')
                                    ->where('idAssessment', @$evaluation['id'])
                                    ->where('idAssessmentType', $sequence->id)
                                    ->where('idStudent', $tmp_user_id)
                                    ->pluck('value')->toArray();
                                $notesDesEtudiants = Rating::select(DB::raw("SUM(value) as valeur"), 'idStudent')
                                    ->join('users', 'users.id','=','ratings.idStudent')
                                    ->where('users.deleted', '0')
                                    ->where('ratings.idAssessment', @$evaluation['id'])
                                    ->where('ratings.idAssessmentType', $sequence->id)
                                    ->where('ratings.idClasse', $request['idClasse'])
                                    ->groupBy('idStudent')
                                    ->pluck('valeur')->toArray();

                                $sequences[$keySequence]->total_note = safeArraySum($maNoteSurMatiere, true);
                                $sequences[$keySequence]->rang = (count($maNoteSurMatiere) > 0)
                                    ? count(array_filter($notesDesEtudiants, function($value) use ($maNoteSurMatiere){
                                        return $value > safeArraySum($maNoteSurMatiere);
                                    })) + 1
                                    : null;
                                $sequences[$keySequence]->class_avg = safeArraySum($notesDesEtudiants, true);
                                $sequences[$keySequence]->class_success_percentage = (!empty($notesDesEtudiants))
                                    ? count(array_filter($notesDesEtudiants, function($value) use ($evaluation){
                                        return $value >= $evaluation['notemax']/2;
                                    }))*100 / count($notesDesEtudiants) // on divise par le nombre d'étudiants qui on composé la matière et non juste par l'effectif de la classe
                                    : null;
                            }
                            $trimestres[$keyTrimestre]['assessment_types'] = $sequences->toArray();

                            $sequences_id = $trimestre->assessmentTypes()->pluck('id')->toArray();

                            // la notemax du trimestre c'est la sum des notemax des évaluations du trimestre divisé par le nombre d'évaluations
                            $assessmentsOfMatterForAssessmentType = Assessment::join('assessments_has_assessment_type as ahat', 'ahat.assessment_id', '=', 'assessments.id')
                                ->where('assessments.idMatter', $matter->id)
                                ->where('assessments.idClasse', $request['idClasse'])
                                ->whereIn('ahat.assessment_type_id', $sequences_id)
                                ->distinct('assessments.id')
                                ->pluck('assessments.notemax', 'assessments.id')
                                ->toArray();

                            // TODO: Ces valeurs sont à revoir
                            $maNoteSurMatiereSurTrimestre = Rating::select('value')
                                ->where('ratings.idMatter', $matter->id) // il y'a plusieurs évalautions sur la matière (en fonction de la séquence donc...)
                                ->whereIn('idAssessmentType', $sequences_id)
                                ->where('idStudent', $tmp_user_id)
                                ->pluck('value')->toArray();

                            // TODO: Pour avoir la note moyenne de chaque étudiant, on va boucler sur chacun, récupérer ses notes, sommer et diviser par le nombre de notes (donc le nombre de typesEvals) sur lesquels il a composé
//                            $notesDesEtudiantsSurMatiereSurTrimestre = array();
//                            foreach ($users as $user) {
//                                $tmp_note_student_sur_matiere = Rating::select('value')
//                                    ->join('users', 'users.id','=','ratings.idStudent')
//                                    ->where('users.deleted', '0')
//                                    ->where('ratings.idMatter', $matter->id) // il y'a plusieurs évalautions sur la matière (en fonction de la séquence donc...)
//                                    ->whereIn('ratings.idAssessmentType', $sequences_id)
//                                    ->where('ratings.idClasse', $request['idClasse'])
//                                    ->where('ratings.idStudent', $user['id'])
//                                    ->pluck('value')
//                                    ->toArray();
//
//                                if(!empty($tmp_note_student_sur_matiere)) $notesDesEtudiantsSurMatiereSurTrimestre[] = safeArraySum($tmp_note_student_sur_matiere);
//                            }
//
//                            dd($notesDesEtudiantsSurMatiereSurTrimestre);
                            $notesDesEtudiantsSurMatiereSurTrimestre = Rating::select(DB::raw("SUM(value) as valeur"), 'idStudent')
                                ->join('users', 'users.id','=','ratings.idStudent')
                                ->where('users.deleted', '0')
                                ->where('ratings.idMatter', $matter->id) // il y'a plusieurs évalautions sur la matière (en fonction de la séquence donc...)
                                ->whereIn('ratings.idAssessmentType', $sequences_id)
                                ->where('ratings.idClasse', $request['idClasse'])
                                ->groupBy('idStudent')
                                ->pluck('valeur')->toArray();
                            // On cacule le nombre de fois que cette matière est composée sur le trimestre
                            $nbreEvalsDeMatiereSurTrimestre = Rating::select('idAssessmentType')
                                ->join('users', 'users.id','=','ratings.idStudent')
                                ->where('users.deleted', '0')
                                ->where('ratings.idMatter', $matter->id) // il y'a plusieurs évalautions sur la matière (en fonction de la séquence donc...)
                                ->whereIn('ratings.idAssessmentType', $sequences_id)
                                ->where('ratings.idClasse', $request['idClasse'])
                                ->distinct()
                                ->pluck('idAssessmentType')
                                ->count();

                            $trimestres[$keyTrimestre]->nbreEvalsDeMatiereSurTrimestre = $nbreEvalsDeMatiereSurTrimestre;
                            $trimestres[$keyTrimestre]->total_note = safeArraySum($maNoteSurMatiereSurTrimestre, true);
                            $trimestres[$keyTrimestre]->rang = (count($maNoteSurMatiereSurTrimestre) > 0)
                                ? count(array_filter($notesDesEtudiantsSurMatiereSurTrimestre, function($value) use ($maNoteSurMatiereSurTrimestre){
                                    return $value > safeArraySum($maNoteSurMatiereSurTrimestre);
                                })) + 1
                                : null;
                            $trimestres[$keyTrimestre]->class_avg = ($nbreEvalsDeMatiereSurTrimestre>0)
                                ? safeArraySum($notesDesEtudiantsSurMatiereSurTrimestre, true) / $nbreEvalsDeMatiereSurTrimestre
                                : null;
//                            $trimestres[$keyTrimestre]->notemaxe = safeArraySum($assessmentsOfMatterForAssessmentType, true);
//                            $trimestres[$keyTrimestre]->notemaxes = $assessmentsOfMatterForAssessmentType;
//                            $trimestres[$keyTrimestre]->notesDesEtudiantsSurMatiereSurTrimestre = $notesDesEtudiantsSurMatiereSurTrimestre;
//                            $trimestres[$keyTrimestre]->nbreElevesSurMatiere = count($notesDesEtudiantsSurMatiereSurTrimestre);
                            $trimestres[$keyTrimestre]->class_success_percentage = (!empty($notesDesEtudiantsSurMatiereSurTrimestre))
                                ? count(array_filter($notesDesEtudiantsSurMatiereSurTrimestre, function($value) use ($assessmentsOfMatterForAssessmentType){
                                    return ($value >= safeArraySum($assessmentsOfMatterForAssessmentType, true)/2) ; // si le rapport note/total est >=0.5 alors il a plus de la moyenne donc il a passé
                                }))*100 / count($notesDesEtudiantsSurMatiereSurTrimestre) // on divise par le nombre d'étudiants qui on composé la matière et non juste par l'effectif de la classe
                                : null;
//                            $trimestres[$keyTrimestre]->notes = $notesDesEtudiantsSurMatiereSurTrimestre;
//                            $trimestres[$keyTrimestre]->blabla = safeArraySum($assessmentsOfMatterForAssessmentType, true);

                            /**
                             * On ajoute aussi les détails des types evaluations sur le trimestre pour cette matière précise
                             */
                            $detailsTypesEvaluationSurTrimestre = array();
                            foreach ($typesEvaluations as $keyTypeEvaluation => $typesEvaluation){
//                                $notemax_type_evaluation = Assessment::where('idMatter', $matter->id)
//                                    ->where('idClasse', $request['idClasse'])
//                                    ->first()
//                                    ->{Str::slug($typesEvaluation->name, "_")};

                                $te_name = Str::slug($typesEvaluation->name, "_");
                                // on récupère dans un tab les notemax de ce type d'évaluation sur le trimestre
                                $assess = Rating::select('idAssessment', "assessments.$te_name")
                                    ->distinct()
                                    ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
                                    ->whereIn('idAssessmentType', $sequences_id)
                                    ->where('idTypeEvaluation', $typesEvaluation->id)
                                    ->where('assessments.idClasse', $request['idClasse'])
                                    ->where('assessments.idMatter', $matter->id)
                                    ->pluck("assessments.$te_name")
                                    ->toArray();
                                $notemax_type_evaluation = safeArraySum($assess, true);

                                $tmp_note = array();

                                // On compte le nombre de séquences sur lesquelles ce typeEvaluation a été composé (donc qu'il apaprait dans la table ratings)
                                $nbreSequencesCompPourEvaluationSurTrimestre = Rating::select('idAssessmentType')
                                    ->distinct('idAssessmentType')
                                    ->where('ratings.idMatter', $matter->id)
                                    ->where('idClasse',  $request['idClasse'])
                                    ->where('idTypeEvaluation', $typesEvaluation->id)
//                                    ->where('idStudent', $tmp_user_id)
                                    ->count();
                                $noteSurTypeEvaluationPourTrimestre = Rating::select('value')
                                    ->where('ratings.idMatter', $matter->id)
                                    ->where('idTypeEvaluation', $typesEvaluation->id)
                                    ->whereIn('idAssessmentType', $sequences_id)
                                    ->where('ratings.idClasse', $request['idClasse'])
                                    ->where('idStudent', $tmp_user_id)
                                    ->pluck('value')->toArray();
                                $notesDesEtudiantsSurTypeEvaluationPourTrimestre = Rating::select(DB::raw("SUM(value) as valeur"), 'idStudent')
                                    ->join('users', 'users.id','=','ratings.idStudent')
                                    ->where('users.deleted', '0')
                                    ->where('ratings.idMatter', $matter->id)
                                    ->whereIn('ratings.idAssessmentType', $sequences_id)
                                    ->where('ratings.idClasse', $request['idClasse'])
                                    ->where('ratings.idTypeEvaluation', $typesEvaluation->id)
                                    ->groupBy('ratings.idStudent')
                                    ->pluck('valeur')->toArray();
//
                                // TODO: détails (rang, %s; moy.gen) sur le type d'eval de la matière
                                $tmp_note['id'] = $typesEvaluation->id;
                                $tmp_note['name'] = $typesEvaluation->name;
                                $tmp_note['nbreEvals'] = $nbreSequencesCompPourEvaluationSurTrimestre;
                                $tmp_note['note'] = safeArraySum($noteSurTypeEvaluationPourTrimestre, true);
                                $tmp_note['rang'] = (!empty($noteSurTypeEvaluationPourTrimestre) && $nbreSequencesCompPourEvaluationSurTrimestre>0)
                                    ? count(array_filter($notesDesEtudiantsSurTypeEvaluationPourTrimestre, function($value) use ($noteSurTypeEvaluationPourTrimestre, $nbreSequencesCompPourEvaluationSurTrimestre) {
                                        return ($value / $nbreSequencesCompPourEvaluationSurTrimestre) > safeArraySum($noteSurTypeEvaluationPourTrimestre, true);
                                    })) + 1
                                    : null;
                                $tmp_note['class_avg'] = ($nbreSequencesCompPourEvaluationSurTrimestre > 0)
                                    ? safeArraySum($notesDesEtudiantsSurTypeEvaluationPourTrimestre, true) / $nbreSequencesCompPourEvaluationSurTrimestre
                                    : null;
                                $tmp_note['class_success_percentage'] = (!empty($noteSurTypeEvaluationPourTrimestre) && $notemax_type_evaluation>0)
                                    ? count(array_filter($notesDesEtudiantsSurTypeEvaluationPourTrimestre, function($value) use ($notemax_type_evaluation, $assess){
                                        return $value >= ($notemax_type_evaluation/2); // $notemax ici est déjà la moyenne sur le trimestre
                                    }))*100 / count($notesDesEtudiantsSurTypeEvaluationPourTrimestre) // on divise par le nombre d'étudiants qui on composé le typeEvaluation et non juste par l'effectif de la classe
                                    : null;
                                $tmp_note['notemax'] = $notemax_type_evaluation;
//                                $tmp_note['akieh'] = $notesDesEtudiantsSurTypeEvaluationPourTrimestre;
//                                $tmp_note['akieeeuuuuuh'] = $assess;

                                $detailsTypesEvaluationSurTrimestre[] = $tmp_note;
                            }
//                            dd($detailsTypesEvaluationSurTrimestre);
                            $trimestres[$keyTrimestre]->types_evaluations = $detailsTypesEvaluationSurTrimestre;
                            /**
                             * On ajoute aussi les détails des types evaluations sur le trimestre pour cette matière précise
                             */
                        }

                        $matters[$keyMatter]['trimestres'] = $trimestres->toArray();
                    }
                    $matterGroup['matters'] = $matters->toArray();
                }
                $tabNote['user'][$kU]['matter_groups'] = $matterGroups->toArray();

                // Maintenant on travaille

                $moyennes = array(); // on va calculer les moyennes

                $trimestres = Trimestre::select('id','name')
                    ->when(!is_null($idTrimestre), function($query) use($idTrimestre){
                        $query->where('id', $idTrimestre);
                    })
                    ->get();

                foreach ($trimestres as $keyTrimestre => $trimestre) {
                    //Pour facilement parcourir plus tard ici, on va mettre les id comme les clés des éléménts
                    $moyennes[$trimestre->id] = [
                        'id' => $trimestre->id,
                        'name' => $trimestre->name,
                        'sequences' => array()
                    ];

                    $moyenneTrim = 0; $nbreSequencesComp = 0; // le nombre de séquences composées

                    foreach ($trimestre->assessmentTypes as $keyAssessmentType => $assessmentType) {
                        $total_notemax_assessment = 0;
                        // on récupère toutes les évaluations où le type ci a composé
                        $evals_compose = Rating::select('idAssessment', 'idTypeEvaluation' ,'te.name as te_name', 'a.*')
                            ->join('type_evaluation as te', 'te.id','=','idTypeEvaluation')
                            ->join('assessments as a', 'a.id','=','ratings.idAssessment')
                            ->join('matter','matter.id','=','ratings.idMatter')
                            ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                                $query->where('matter.idOptionLevel', $idOptionLevel);
                            })
                            ->where([
                                'idStudent' => $tmp_user_id,
                                'idAssessmentType' => $assessmentType['id']
                            ])
                            ->get();

                        // on somme les notes des types_evaluations (pas des notemax)
                        foreach ($evals_compose as $item) {
                            $tmp_te_name = $item['te_name'];
                            $total_notemax_assessment += $item[Str::slug($tmp_te_name, '_')];
                        }

                        $rating = Rating::select(DB::raw("SUM(ratings.value) as totalValue"))
                            ->join('assessments','assessments.id','=','ratings.idAssessment')
                            ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                            ->where('assessment_type.id', $assessmentType['id'])
                            ->where('ratings.idStudent', $tmp_user_id)
                            ->first();
                        $rating->totalNoteMax = $total_notemax_assessment;

                        $tmp_moyenne_sequence = ($rating->totalNoteMax > 0) ? ($rating->totalValue * 20) / $rating->totalNoteMax : null;
                        $moyenneTrim += $tmp_moyenne_sequence;
                        if($tmp_moyenne_sequence>0) $nbreSequencesComp++;

                        $moyennes[$trimestre->id]['sequences'][$assessmentType->id] = [
                            'total_note' => $rating->totalValue,
                            'total_notemax' => $rating->totalNoteMax,
                            'moyenne' => ($tmp_moyenne_sequence) > 0 ? $tmp_moyenne_sequence : null,
                            'rang' => null,
                            'isUsedForMoyenneTrimestre' => true, // puis on va modifier les moyennes séq qui ne seront pas utilisées
                            //TODO: On compte le nombre d'évaluations que chaque enfant doit effectuer...
                            // PS: si après il a composé -70% de toutes les évaluations,
                            // (1) on ne va pas l'inclure dans le calcul de la moyenne générale de la classe
                            // (2) on ne l'inclut pas dans les moyennes et donc il n'aura pas de rang comme les autres
                            'totalNbreEvaluations' => Assessment::select('assessments.*')
                                ->join('ratings', 'ratings.idAssessment', 'assessments.id')
                                ->where('ratings.idAssessmentType', $assessmentType['id'])
                                ->where('ratings.idStudent', $tmp_user_id)
                                ->distinct('assessments.id')
                                ->count(),
                        ];

                        if(isset($totalEvalsClasseParSequence[(int)substr($assessmentType['name'], -1)-1])){
                            $totalEvalsClassePourSequence = (int)$totalEvalsClasseParSequence[(int)substr($assessmentType['name'], -1)-1];
                            $moyennes[$trimestre->id]['sequences'][$assessmentType->id]['isUsedForMoyenneTrimestre'] = ($moyennes[$trimestre->id]['sequences'][$assessmentType->id]['totalNbreEvaluations'] / $totalEvalsClassePourSequence >= 0.7);
                        }

                    }
                    $moyennes[$trimestre->id]['moyenne'] = ($nbreSequencesComp>0) ? $moyenneTrim / $nbreSequencesComp : null;
                    $moyennes[$trimestre->id]['rang'] = null;
                    $moyennes[$trimestre->id]['totalNbreEvaluations'] = Assessment::select('assessments.*')
                        ->join('ratings', 'ratings.idAssessment', 'assessments.id')
                        ->whereIn('ratings.idAssessmentType', $trimestre->assessmentTypes()->pluck('id')->toArray())
                        ->where('ratings.idStudent', $tmp_user_id)
                        ->distinct('assessments.id')
                        ->count();
                }

                $tabNote['user'][$kU]['moyennes_par_trimestre'] = $moyennes;
            }

            /******************************************************Debut calcul rang ********************************************/

            $rangsParSequence = []; // Tableau associatif pour stocker les rangs pour chaque séquence
            $rangsParTrimestre = []; // Tableau associatif pour stocker les rangs pour chaque séquence
            $moyennesGenerales = []; // moyennes générales de la classe par trimestre et par séquence


            foreach ($trimestres as $keyTrimestre => $trimestre){
                $nbreTotalEvaluationsTrimestreDeLaClasse = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                    ->join('matter','matter.id','=','assessments.idMatter')
                    ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                    ->where('assessments.idSchool',$request['idSchool'])
                    ->where('assessments.idSection',$request['idSection'])
                    ->where('assessments.idClasse',$request['idClasse'])
                    ->whereIn('assessments_has_assessment_type.assessment_type_id', $trimestre->assessmentTypes()->pluck('id')->toArray())
                    ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                        $query->where('matter.idOptionLevel', $idOptionLevel);
                    })
                    ->count();
                $moyennesParTrimestre = $moyennesParTrimestrePourMoyenneGenerale = [];
                $moyennesGenerales[$trimestre->id] = [
                    'id' => $trimestre->id,
                    'name' => $trimestre->name,
                ];

                foreach ($tabNote['user'] as $userId => $user) {
                    foreach ($user['moyennes_par_trimestre'] as $trim) {
                        // TODO: On va jouter le total_trimestre ... et plus tard placer ça dans la fonction plus haut... on le fait en tab pour facilement diviser par le nombre d'éléments
                        $total_note_trimestre = array();
                        $total_notemax_trimestre = array();

                        foreach ($trim['sequences'] as $idSeq => $seq) {
                            $tmp_note = $seq['total_note'];
                            $tmp_notemax = $seq['total_notemax'];

                            if(!is_null($tmp_note)){
                                // TODO: avant d'ajouter le total_note et max, on vérifie qu'il a composé AU MOINS 70% des évals de cette séquence

                                $nbreEvalsComp = count(array_unique(Rating::select('idAssessment')
                                    ->where('idAssessmentType', $idSeq)
                                    ->where('idStudent', $user['id'])
                                    ->pluck('idAssessment')
                                    ->toArray()));

                                $totalEvalsClassePourSequence = (int)$totalEvalsClasseParSequence[(int)substr($tmpAssessmentType->name, -1)-1];

                                if($nbreEvalsComp / $totalEvalsClassePourSequence >= 0.7){
                                    $total_note_trimestre[] = $tmp_note;
                                    $total_notemax_trimestre[] = $tmp_notemax;
                                }
                            }
                        }

                        $user['moyennes_par_trimestre'][$trim['id']]['total_note_trimestre'] = safeArraySum($total_note_trimestre, true);
                        $user['moyennes_par_trimestre'][$trim['id']]['total_notemax_trimestre'] = safeArraySum($total_notemax_trimestre, true);
                        $user['moyennes_par_trimestre'][$trim['id']]['moyenne'] = (safeArraySum($total_notemax_trimestre, true)>0)
                            ? safeArraySum($total_note_trimestre, true)*20 / safeArraySum($total_notemax_trimestre, true)
                            : null;
                    }

                    $tabNote['user'][$userId] = $user; // on réinjecte l'objet user ici là

                    $totalNbreEvaluationsComposesDuTrimestrePourEleve = $user['moyennes_par_trimestre'][$trimestre->id]['totalNbreEvaluations'];

                    $moyennesParTrimestrePourMoyenneGenerale[$user['id']] = $user['moyennes_par_trimestre'][$trimestre->id]['moyenne'];
                    if(($totalNbreEvaluationsComposesDuTrimestrePourEleve*100 / $nbreTotalEvaluationsTrimestreDeLaClasse) >= 70){
                        $moyennesParTrimestre[$user['id']] = $user['moyennes_par_trimestre'][$trimestre->id]['moyenne'];
                    }

                }
                $moyennesGenerales[$trimestre->id]['mg'] = (!empty($moyennesParTrimestre))
                    ? array_sum($moyennesParTrimestre) / count($moyennesParTrimestre)
                    : null;

                $moyennesGenerales[$trimestre->id]['sequences'] = array();

                $moyennesGenerales[$trimestre->id]['moyennesStudents'] = $moyennesParTrimestrePourMoyenneGenerale;
                $moyennesGenerales[$trimestre->id]['class_success_percentage'] = count(array_filter($moyennesParTrimestrePourMoyenneGenerale, function($moyenneStudent){
                    return $moyenneStudent >= 10.0;
                }))*100 / count($moyennesParTrimestrePourMoyenneGenerale) ;

                // TODO: On va encore réduire les données inutiles, et donc le temps de chargement. Si on spécifié un idAssessmentType, on va boucler uniquement sur cet élément

                $tmp_seq_form_trim = $trimestre->assessmentTypes()
                    ->when(!is_null($idAssessmentType), function($query) use ($idAssessmentType){
                        $query->where('id', $idAssessmentType);
                    })->get();
                foreach ($tmp_seq_form_trim as $keyAssessmentType => $assessmentType) {
                    $nbreTotalEvaluationsSequenceDeLaClasse = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->where('assessments_has_assessment_type.assessment_type_id', $assessmentType->id)
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->count();
                    $moyennesSequences = [];

                    foreach ($tabNote['user'] as $userId => $user) {
                        $totalNbreEvaluationsComposesDuTrimestrePourEleve = $user['moyennes_par_trimestre'][$trimestre->id]['sequences'][$assessmentType->id]['totalNbreEvaluations'];

                        if(($nbreTotalEvaluationsSequenceDeLaClasse>0) && ($totalNbreEvaluationsComposesDuTrimestrePourEleve*100 / $nbreTotalEvaluationsSequenceDeLaClasse) >= 70){
                            $moyennesSequences[$user['id']] = $user['moyennes_par_trimestre'][$trimestre->id]['sequences'][$assessmentType->id]['moyenne'];
                        }

                        // Pour avoir le rang de l'élève sur le trimestre, on compare sa moyenne aux moyennes des élèves de la classe.
                        // NB: l'élève a un rang si il a une moyenne non null
                        $tabNote['user'][$userId]['moyennes_par_trimestre'][$trimestre->id]['rang'] = (!is_null($user['moyennes_par_trimestre'][$trimestre->id]['moyenne']))
                            ? count(array_filter($moyennesGenerales[$trimestre->id]['moyennesStudents'], function($moyenneStudent) use ($user, $trimestre){
                                return $moyenneStudent > $user['moyennes_par_trimestre'][$trimestre->id]['moyenne'];
                            })) + 1
                            : null;
                    }

                    arsort($moyennesSequences);

                    $moyennesSequences = array_values($moyennesSequences);

                    $moyennesGenerales[$trimestre->id]['sequences'][] = [
                        'id' => $assessmentType->id,
                        'name' => $assessmentType->name,
                        'mg' => (count($moyennesSequences) > 0) ? array_sum($moyennesSequences) / count($moyennesSequences) : null,
                        'best_avg' => $moyennesSequences[0],
                        'worst_avg' => end($moyennesSequences),
                        'success_percentage' => count(array_filter($moyennesSequences, function($value){
                                return $value >= 10.0;
                            }))*100 / count($moyennesSequences),
                        'moyennes' => $moyennesSequences
                    ];
                }
            }

            /**
             * Calcul du rang sur les séquences de chaque utilisateur
             *
             * Pour chaque séquence de chaque trimestre, on parcourt les users et on stocke les moyennes de chacun, puis on reparcourt chaque user pour ajouter son rang
             */

            foreach ($trimestres as $keyTrimestre => $trimestre){
                foreach ($trimestre->assessmentTypes as $assessmentType) {
                    $moyennesSequences = [];

                    $nbreKala = 0;
                    // on garde les moyennes
                    foreach ($tabNote['user'] as $userId => $user) {
                        $tmp_moy = $user['moyennes_par_trimestre'][$trimestre->id]['sequences'][$assessmentType->id]['moyenne'];
                        $moyennesSequences[] = ($tmp_moy > 0) ? $tmp_moy : null;
                    }

                    // On détermine maintenant le rang
                    foreach ($tabNote['user'] as $keyUser => $user) {
                        $ma_moy = $user['moyennes_par_trimestre'][$trimestre->id]['sequences'][$assessmentType->id]['moyenne'];

                        // Pour avoir le rang de l'élève sur la séquence de chaque trimestre, on compare sa moyenne aux moyennes des élèves de la séquence.
                        $tabNote['user'][$keyUser]['moyennes_par_trimestre'][$trimestre->id]['sequences'][$assessmentType->id]['rang'] = (!empty($moyennesSequences) && !is_null($ma_moy))
                            ? count(array_filter($moyennesSequences, function($moy) use ($ma_moy){
                                return $moy > $ma_moy;
                            }))+1
                            : null;
                    }
                }
            }
            /******************************************************Fin calcul rang ********************************************/

            $tabNote["moyennesGenerales"] = $moyennesGenerales;

            return $this->sendResponse($tabNote, 'Bulletins');
        }
        catch (\Throwable $th) {
            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError("Une erreur s'est produite, veuillez contacter un administrateur");
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }


    public function genererBulletinPrimaire(GenererBulletinPrimaireRequest $request){
        try{
            set_time_limit(300);

            $classe = null;
            $sequences = null;
            $evaluation = null;
            $styleBulletin = $request["styleMaternelle"]?? null;

            //On détermine le type de bulletin demandé
            if(!is_null($request["idTrimestre"])){
                //Pour un bulletin trimestriel
                $evaluation = Trimestre::find($request["idTrimestre"]);
                $sequences = AssessmentType::select("id", "name")
                ->where("idTrimestre", $request["idTrimestre"])->get()->toArray();
            }
            else if(!is_null($request["idAssessmentType"])){
                //Pour un bulletin sequentielle
                $evaluation = AssessmentType::find($request["idAssessmentType"]);
                $sequences[] = AssessmentType::find($request["idAssessmentType"]);
            }
            else{
                //Pour un bulletin annuel
                // $idSequences[] = AssessmentType::where("idTrimestre", $request["idTrimestre"])->pluck("id");
            }

            if(is_null($sequences)){
                //Aucune sequence retrouvee
                return $this->sendError("Sequence(s) introuvables");
            }
            else{
                $classe = Classes::select("classes.*", "section.name as nomSection")
                ->join("section", "section.id", "=", "classes.idSection")
                ->where("classes.id", $request["idClasse"])->first();
            }


            $notes = $this->getNoteEvaluation($request["idClasse"], array_column($sequences, "id"), $request["idOptionLevel"]);

            // if(count($notes) == 0){
            //     return $this->sendError("Aucune notes n'a été trouvée");
            // }



            //On regroupe les notes de l'evaluation de chaque etudiant par groupe de matiere par matiere(evaluation) et par type d'evaluation
            $donneesEvaluation = $this->regroupeNoteParEleveParGroupeParMatiere($notes, array_column($sequences, "id"));
            if(count($donneesEvaluation) <= 0){
                $donneesEvaluation = $this->genererBulletinsNulls($request["idClasse"], $request["idOptionLevel"], array_column($sequences, "id"));
            }

            if(count($donneesEvaluation) <= 0){
                return $this->sendError("Verifiez que des evaluations existent sur les séquences concernées");
            }

            $effectif = count($donneesEvaluation);

            //On verifi que l'eleve a effectue 70% de l'evaluation
            $donneesEvaluation = $this->analyserEvaluationEleves($donneesEvaluation, array_column($sequences, "id"), $request["idClasse"], $request["idOptionLevel"]);

            //Somme des notes obtenues et notes max pour chaque element(typeEval, Mat, GroupMat, Eval)
            $evaluationsValides = $this->sommeDesNotes($donneesEvaluation["evaluationsValides"], array_column($sequences, "id"));
            $evaluationsInvalides = $this->sommeDesNotes($donneesEvaluation["evaluationsInvalides"], array_column($sequences, "id"));
            $donneesEvaluation = $evaluationsValides + $evaluationsInvalides;

            //On calcule les statistiques de la classe, des matieres et type d'evaluation
            $donnees= $this->getDonneesClasseMatieresTypeEvaluation($evaluationsValides, $request["idClasse"], array_column($sequences, "id"), $request["idOptionLevel"], $request["route"], []);

            //Considerer uniquement les eleves qui ont effectuer uniquement 70% des evaluations d'une sequence
            //Commentez ou supprimez si vous souhaitez compter tous les eleves dans la classe
            $effectif = count($evaluationsValides);


            $ecole = $this->getInfosEcole($request["idClasse"]);
            $infosClasse = [
                "nomEnseignant" => User::join("classes", "classes.idTeacher", "users.id")
                    ->where("classes.deleted", 0)
                    ->where("classes.id", $request["idClasse"])
                    ->value("users.name"),
                "effectifClasse" => $effectif
            ];

            $template = $styleBulletin
            ? "documents.bulletin-primaire.bulletin-maternelle"
            : "documents.bulletin-primaire.bulletin-primaire";

            //Fichiers zip pour stocker les bulletins de la classe
            $zip_file = "Bulletins-primaire-".Str::slug($classe["name"]).'-'.Str::slug($evaluation->name).".zip";

            $liensBulletins = [];
            $zip = new \ZipArchive();
            $this->createDirectory('pdfs');
            $zip->open("pdfs/$zip_file", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            //On crée le code couleur
            $legend_of_grade = [
                'nye' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                    return $moyenneStud < 10;
                })),
                'nye_color' => "db0b32",
                'ae' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                    return $moyenneStud >= 10 && $moyenneStud < 15;
                })),
                'ae_color' => "fdaa3e",
                'me' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                    return $moyenneStud >= 15 && $moyenneStud < 18;
                })),
                'me_color' => "0080ff",
                'abe' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                    return $moyenneStud >= 18;
                })),
                'abe_color' => "008000",
            ];


            // return $donneesEvaluation;
            // return $donneesEvaluation["60"];
            // return $donnees["donneesMatiere"];
            // return $donnees["donneesClasse"];

            if(($request["idUser"]) !== null){

                if(isset($donneesEvaluation[$request["idUser"]])){
                    $eleve = User::find($request["idUser"]);

                    $data = [
                        'ecole' => $ecole,
                        'classe' => $classe,
                        'infosEleve' => $eleve,
                        'sequences' => $sequences,
                        "route" => $request["route"],
                        'infosClasse' => $infosClasse,
                        'infosEvaluation' => $evaluation,
                        'donneesClasse' => $donnees["donneesClasse"],
                        'donneesMatieres' => $donnees["donneesMatiere"],
                        'evaluation' => $donneesEvaluation[$request["idUser"]],
                        "codeCouleur" => explode(";", Establishment::first()->code_couleur),
                        "legend_of_grade" => $legend_of_grade,
                    ];

                    $nomFichier = Str::slug($eleve["name"].' '.$evaluation->name);
                    $liensBulletins[] = $this->genererDocument($nomFichier, $template, $data, $zip);
                    return $this->sendResponse(asset("pdfs/". $nomFichier .".pdf"), "Bulletin primaire");
                }
                else{
                    return $this->sendError("L'élève que vous avez choisi n'a pas effectué cette évaluation");
                }
            }
            else{
                foreach($donneesEvaluation as $idEleve => $donneeEvaluation){
                    $eleve = User::find($idEleve);

                    $data = [
                        'ecole' => $ecole,
                        'classe' => $classe,
                        'infosEleve' => $eleve,
                        'sequences' => $sequences,
                        "route" => $request["route"],
                        'infosClasse' => $infosClasse,
                        'infosEvaluation' => $evaluation,
                        'donneesClasse' => $donnees["donneesClasse"],
                        'donneesMatieres' => $donnees["donneesMatiere"],
                        'evaluation' => $donneeEvaluation,
                        "codeCouleur" => explode(";", Establishment::first()->code_couleur),
                        "legend_of_grade" => $legend_of_grade,
                    ];

                    $liensBulletins[] = $this->genererDocument(Str::slug($eleve["name"]), $template, $data, $zip);
                    // return $this->sendResponse(asset("pdfs/". Str::slug($eleve["name"]) .".pdf"), "Bulletin primaire");
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletins secondaires");
        }
        catch(Exception $e){
            return $this->sendError("Un probleme est survenue lors du calcul des notes");
        }
    }

    public function afficherNotesPrimaire(AfficherNotesPrimaireRequest $request)
    {
        try{
            $idClasse = User::find($request["idUser"])["idClasse"] ?? null;

            $idsOptionLevel = [$request["idOptionLevel"] ?? null];

            //Decommentez si vous souhaitez que le endpoint calcule l'option de niveau (si non envoyé dans le payload)
            // $idsOptionLevel = Classes::join("level_option_level", "level_option_level.level_id", "=", "classes.idLevel")
            // ->where("classes.id", $idClasse)
            // ->distinct()
            // ->pluck("level_option_level.option_level_id")
            // ->toArray();

            // $idsOptionLevel = count($idsOptionLevel) > 0
            // ? $idsOptionLevel
            // : [null];


            if (!$idClasse) {
                return $this->sendError("Classe ou niveau d'option introuvable.");
            }

            $idTrimestres = Assessment::select("assessment_type.idTrimestre")
                ->where("idClasse", $idClasse)
                ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
                ->join("assessment_type", "assessment_type.id", "=", "assessments_has_assessment_type.assessment_type_id")
                ->where("assessment_type.deleted", 0)
                ->orderBy("assessment_type.idTrimestre")
                ->distinct()
                ->pluck("idTrimestre")
                ->toArray();

            $evaluations = [];
            $moyenneAnnuelle = null;
            $nbrTrimestreValid = 0;

            foreach($idsOptionLevel as $idOptionLevel){


                foreach ($idTrimestres as $idTrimestre) {
                    $trimestre = [
                        "idOptionLevel" => $idOptionLevel?? null,
                        "idTrimestre" => $idTrimestre?? null,
                        "nomEvaluation" => Trimestre::find($idTrimestre)["name"] ?? null,
                        "moyenneTrimestre" => null,
                        "valide70" => null
                    ];


                    $sequences = AssessmentType::select("id", "name")
                        ->where("idTrimestre", $idTrimestre)
                        ->get()
                        ->toArray();



                    $notes = $this->getNoteEvaluation($idClasse, array_column($sequences, "id"), $idOptionLevel, $request["idUser"]);


                    $donneesEvaluation = $this->regroupeNoteParEleveParGroupeParMatiere($notes, array_column($sequences, "id"));

                    if (count($donneesEvaluation) <= 0) {
                        $donneesEvaluation = $this->genererBulletinsNulls($idClasse, $idOptionLevel, array_column($sequences, "id"));
                    }

                    $donneesEvaluation = $this->analyserEvaluationEleves($donneesEvaluation, array_column($sequences, "id"), $idClasse, $idOptionLevel);

                    $evaluationsValides = $this->sommeDesNotes($donneesEvaluation["evaluationsValides"] ?? [], array_column($sequences, "id"));

                    $totalMoyenne = 0;
                    $nombreSequencesValides = 0;

                    foreach (array_column($sequences, "id") as $idSequence) {
                        $sequenceData = $evaluationsValides[$request["idUser"]] ?? [];
                        $sequenceKey = "sequence$idSequence";
                        $noteMaxKey = "noteMaxSeq$idSequence";
                        $isValidKey = "isEvalueSeq$idSequence";

                        $moyenneSequence = ($sequenceData["sequences"][$sequenceKey] ?? null) !== null && ($sequenceData["noteMaxSeq"][$noteMaxKey] ?? null) !== null
                            ? round((($sequenceData["sequences"][$sequenceKey] / $sequenceData["noteMaxSeq"][$noteMaxKey]) * 20), 2)
                            : null;

                        $valide70 = $sequenceData["isEvalueSeq"][$isValidKey] ?? false;

                        $sequence = [
                            "idOptionLevel" => $idOptionLevel?? null,
                            "idSequence" => $idSequence?? null,
                            "nomEvaluation" => AssessmentType::find($idSequence)["name"] ?? null,
                            "moyenneEvaluation" =>  $moyenneSequence,
                            "valide70" => $valide70
                        ];

                        $evaluations[] = $sequence;

                        if ($moyenneSequence !== null && $valide70) {
                            $totalMoyenne += $moyenneSequence;
                            $nombreSequencesValides++;
                        }
                    }

                    $trimestre["moyenneEvaluation"] = $nombreSequencesValides > 0 ? round(($totalMoyenne / $nombreSequencesValides), 2) : null;
                    $trimestre["valide70"] = $nombreSequencesValides > 0;

                    if ($trimestre["valide70"]){
                        $moyenneAnnuelle += $trimestre["moyenneEvaluation"];
                        $nbrTrimestreValid ++;
                    }

                    $evaluations[] =  $trimestre;
                }
            }

            return [
                "valides70" => array_column($evaluations, "valide70"),
                "nomsEvaluations" => array_column($evaluations, "nomEvaluation"),
                "moyennesEvaluations" => array_column($evaluations, "moyenneEvaluation"),
                "moyenneAnnuelle" => $nbrTrimestreValid > 0 ? $moyenneAnnuelle / $nbrTrimestreValid : null
            ];

        }
        catch(Exception $e){
            return $this->sendError("Probleme survenu lors du calcul des notes");
        }
    }



    ///Une copie de la methode afficherNotesPrimaire pour eviter de casser le code existant (car j'ai modifier le type de la request
    public function afficherNotesPrimaire2($request)
    {
        try {
            // Récupérer l'idClasse de manière statique
            $idClasse = User::find($request["idUser"])["idClasse"] ?? null;

            $idsOptionLevel = [$request["idOptionLevel"] ?? null];

            $idTrimestre = $request["idTrimestre"] ?? null;

            if (!$idClasse) {
                // Remplacer $this par self pour accéder à la méthode statique
                return self::sendError("Classe ou niveau d'option introuvable.");
            }

            $idTrimestres = Assessment::select("assessment_type.idTrimestre")
                ->where("idClasse", $idClasse)
                ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
                ->join("assessment_type", "assessment_type.id", "=", "assessments_has_assessment_type.assessment_type_id")
                ->where("assessment_type.deleted", 0)
                ->orderBy("assessment_type.idTrimestre")
                ->distinct()
                ->pluck("idTrimestre")
                ->toArray();

            $idTrimestres = $idTrimestre === null ? $idTrimestres : [$idTrimestre];

            $evaluations = [];
            $moyenneAnnuelle = null;
            $nbrTrimestreValid = 0;

            foreach ($idsOptionLevel as $idOptionLevel) {

                foreach ($idTrimestres as $idTrimestre) {
                    $trimestre = [
                        "idOptionLevel" => $idOptionLevel ?? null,
                        "idTrimestre" => $idTrimestre ?? null,
                        "nomEvaluation" => Trimestre::find($idTrimestre)["name"] ?? null,
                        "moyenneTrimestre" => null,
                        "valide70" => null
                    ];

                    $sequences = AssessmentType::select("id", "name")
                        ->where("idTrimestre", $idTrimestre)
                        ->get()
                        ->toArray();

                    // Appel statique à la méthode getNoteEvaluation
                    $notes = self::getNoteEvaluation($idClasse, array_column($sequences, "id"), $idOptionLevel, $request["idUser"]);

                    $donneesEvaluation = self::regroupeNoteParEleveParGroupeParMatiere($notes, array_column($sequences, "id"));

                    if (count($donneesEvaluation) <= 0) {
                        $donneesEvaluation = self::genererBulletinsNulls($idClasse, $idOptionLevel, array_column($sequences, "id"));
                    }

                    $donneesEvaluation = self::analyserEvaluationEleves($donneesEvaluation, array_column($sequences, "id"), $idClasse, $idOptionLevel);

                    $evaluationsValides = self::sommeDesNotes($donneesEvaluation["evaluationsValides"] ?? [], array_column($sequences, "id"));

                    $totalMoyenne = 0;
                    $nombreSequencesValides = 0;

                    foreach (array_column($sequences, "id") as $idSequence) {
                        $sequenceData = $evaluationsValides[$request["idUser"]] ?? [];
                        $sequenceKey = "sequence$idSequence";
                        $noteMaxKey = "noteMaxSeq$idSequence";
                        $isValidKey = "isEvalueSeq$idSequence";

                        $moyenneSequence = ($sequenceData["sequences"][$sequenceKey] ?? null) !== null && ($sequenceData["noteMaxSeq"][$noteMaxKey] ?? null) !== null
                            ? round((($sequenceData["sequences"][$sequenceKey] / $sequenceData["noteMaxSeq"][$noteMaxKey]) * 20), 2)
                            : null;

                        $valide70 = $sequenceData["isEvalueSeq"][$isValidKey] ?? false;

                        $sequence = [
                            "idOptionLevel" => $idOptionLevel ?? null,
                            "idSequence" => $idSequence ?? null,
                            "nomEvaluation" => AssessmentType::find($idSequence)["name"] ?? null,
                            "moyenneEvaluation" => $moyenneSequence,
                            "valide70" => $valide70
                        ];

                        $evaluations[] = $sequence;

                        if ($moyenneSequence !== null && $valide70) {
                            $totalMoyenne += $moyenneSequence;
                            $nombreSequencesValides++;
                        }
                    }

                    $trimestre["moyenneEvaluation"] = $nombreSequencesValides > 0 ? round(($totalMoyenne / $nombreSequencesValides), 2) : null;
                    $trimestre["valide70"] = $nombreSequencesValides > 0;

                    if ($trimestre["valide70"]) {
                        $moyenneAnnuelle += $trimestre["moyenneEvaluation"];
                        $nbrTrimestreValid++;
                    }

                    $evaluations[] = $trimestre;
                }
            }

            return [
                "valides70" => array_column($evaluations, "valide70"),
                "nomsEvaluations" => array_column($evaluations, "nomEvaluation"),
                "moyennesEvaluations" => array_column($evaluations, "moyenneEvaluation"),
                "moyenneAnnuelle" => $nbrTrimestreValid > 0 ? $moyenneAnnuelle / $nbrTrimestreValid : null
            ];

        } catch (Exception $e) {
            // Remplacer $this par self pour accéder à la méthode statique
            return self::sendError("Problème survenu lors du calcul des notes");
        }
    }


    public function genererBulletinPrimaireSmart(GenererBulletinPrimaireRequest $request){
        try{
            set_time_limit(300);
            $optimalScale = null;
            $sequences = null;
            $styleBulletin = $request["styleMaternelle"] ?? null;

            //On détermine le type de bulletin demandé
            if(!is_null($request["idTrimestre"])){
                //Pour un bulletin trimestriel
                $evaluation = Trimestre::find($request["idTrimestre"]);
                $sequences = AssessmentType::select("id", "name")
                    ->where("idTrimestre", $request["idTrimestre"])->get()->toArray();
            }
            else if(!is_null($request["idAssessmentType"])){
                //Pour un bulletin sequentielle
                $evaluation = AssessmentType::find($request["idAssessmentType"]);
                $sequences[] = AssessmentType::find($request["idAssessmentType"]);
            }
            else{
                //Pour un bulletin annuel
                 $sequences = AssessmentType::select('id', 'name')
                     ->where('idSection', function ($query) use ($request) {
                         $query->select('idSection')
                             ->from('classes')
                             ->where('id', $request['idClasse']);
                     })->get()->toArray();


                $evaluation = new ArrayObject([
                    'name' => __("bulletin_primaire.annual")
                ], ArrayObject::ARRAY_AS_PROPS);
            }

            $trimestres = Trimestre::select('id', 'name', 'numbering')
                ->whereIn("id", AssessmentType::whereIn("id", array_column($sequences, "id"))
                    ->distinct()
                    ->pluck("idTrimestre"))
                ->where('takenIntoAccount', 0)
                ->distinct()
                ->get()->toArray();


            if(is_null($sequences)){
                //Aucune sequence retrouvee
                return $this->sendError(__('bulletin.not_found_sequences'));
            }
            else{
                $classe = Classes::select("classes.*", "section.name as nomSection")
                    ->join("section", "section.id", "=", "classes.idSection")
                    ->where("classes.id", $request["idClasse"])->first();
            }

            $idUser = $request["idUser"] ?? null;

            // Vérifications uniquement pour parents et élèves
            if (in_array($this->getRole()->id, [7,8])) {
                if ($idUser == null) {
                    return $this->sendError("Le champ idUser est obligatoire pour les parents et élèves");
                }

                // Récupération de la liste des insolvables
                $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);

                // Vérification si l'élève est solvable pour la tranche requise
                if (!$this->isSolvable($insolvables, $idUser)) {
                    return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
                }

                // Vérification spécifique pour la tranche 2
                $requestDataX = $request->validated();
                $requestDataX['idSchool'] = $classe->idSchool;
                $requestDataX['nameTranche'] = 2;
                $insolvablesTranche2 = $this->pensionUserService->insolvablePensionUser($requestDataX)['data'];
                if (in_array($idUser, $insolvablesTranche2)) {
                    return $this->sendError("Veuillez payer la tranche 2 pour télécharger le bulletin");
                }

                // Vérification des notes_completed
                $incompleteSequences = AssessmentType::whereIn('id', array_column($sequences, 'id'))
                    ->where('notes_completed', false)
                    ->pluck('name')
                    ->toArray();
                if (!empty($incompleteSequences)) {
                    return $this->sendError("Les notes ne sont pas encore complètes pour les séquences suivantes : " . implode(', ', $incompleteSequences));
                }
            }
            // Pour les teachers (rôle 5), récupérer les insolvables pour filtrage lors de la génération en masse
            $insolvablesTeachers = null;
            if ($this->getRole()->id == 5) {
                $insolvablesTeachers = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
            }

            if(is_null($request->idOptionLevel)){
                $idOptionLevels = DB::table('assessments')
                    ->join('matter', 'assessments.idMatter', '=', 'matter.id')
                    ->where('assessments.idClasse', $classe->id)
                    ->whereNotNull('matter.idOptionLevel')
                    ->distinct()
                    ->pluck('matter.idOptionLevel')
                    ->toArray();

                if(empty($idOptionLevels)){
                    $idOptionLevels[] = null;
                }
            }
            else{
                $idOptionLevels[] = $request->idOptionLevel;
            }


            // Early language detection to ensure correct translation of the evaluation name (e.g. "Annuel") and ZIP naming
            $initialLang = null;
            if (!empty($idOptionLevels)) {
                $firstOptionLevel = OptionLevel::find($idOptionLevels[0]);
                if ($firstOptionLevel) {
                    $initialLang = $firstOptionLevel->lang;
                }
            }
            if (!$initialLang) {
                $section = Section::find($classe->idSection);
                if ($section) {
                    $initialLang = $section->lang;
                }
            }
            if (!$initialLang && !is_null($request->lang)) {
                $initialLang = $request->lang;
            }
            if (!$initialLang) {
                $initialLang = 'fr';
            }
            App::setLocale(strtolower($initialLang));

            if (is_null($request["idTrimestre"]) && is_null($request["idAssessmentType"])) {
                $evaluation->name = __("bulletin_primaire.annual");
            }

            //Fichiers zip pour stocker les bulletins de la classe
            $style = $styleBulletin
                ? 'maternelle'
                : 'primaire';

            $baseZipName = "Bulletins-$style-".Str::slug($classe["name"]).'-'.Str::slug($evaluation->name);
            $counter = 1;
            while (file_exists("pdfs/{$baseZipName}-{$counter}.zip")) {
                $counter++;
            }
            $zip_file = "{$baseZipName}-{$counter}.zip";

            $liensBulletins = [];
            $liensRepertoires = [];
            $zip = new \ZipArchive();

            $this->createDirectory("pdfs");
            $zip->open("pdfs/$zip_file", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $nbrEvaluationValid = 0;

            foreach ($idOptionLevels as $idOptionLevel) {
                $langue = null;
                $optionLevel = OptionLevel::find($idOptionLevel);

                if ($optionLevel) {
                    $langue = $optionLevel->lang;
                }
                else{
                     $section = Section::find($classe->idSection);
                    if ($section) {
                        $langue = $section->lang;
                    }
                }

                if(!$langue && !is_null($request->lang)){
                    $langue = $request->lang; //si on a pas de langue dans les sections et option de niveau
                }
                else if(!$langue){
                    $langue = 'fr'; //langue par defaut
                }

                $liensRepertoires [] = "pdfs/$langue";
                $this->createDirectory("pdfs/$langue");

                App::setLocale(strtolower($langue));
                if (is_null($request["idTrimestre"]) && is_null($request["idAssessmentType"])) {
                    $evaluation->name = __("bulletin_primaire.annual");
                }

                $trimestres = $this->formatNomTrimestre($trimestres);

                $notes = $this->getNoteEvaluation($request["idClasse"], array_column($sequences, "id"), $idOptionLevel);

                // if(count($notes) == 0){
                //     return $this->sendError("Aucune notes n'a été trouvée");
                // }

                //On regroupe les notes de l'evaluation de chaque etudiant par groupe de matiere par matiere(evaluation) et par type d'evaluation
                $donneesEvaluation = $this->regroupeNoteParEleveParGroupeParMatiere($notes, array_column($sequences ?? [], "id"), array_column($trimestres ?? [], 'id'));
                if(count($donneesEvaluation) <= 0){
                    $donneesEvaluation = $this->genererBulletinsNulls($request["idClasse"], $idOptionLevel, array_column($sequences, "id"));
                }

//                if(count($donneesEvaluation) <= 0){
//                    return $this->sendError(__('bulletin.not_found_assessments'));
//                }

                if(count($donneesEvaluation) <= 0 && $idOptionLevel === end($idOptionLevels) && $nbrEvaluationValid === 0){
                    return $this->sendError(__('bulletin.not_found_assessments'));
                }
                else if(count($donneesEvaluation) <= 0 && $idOptionLevel !== end($idOptionLevels)){
                    continue;
                }

                $effectif = count($donneesEvaluation);

                //On verifi que l'eleve a effectue 70% de l'evaluation
                $donneesEvaluation = $this->analyserEvaluationEleves($donneesEvaluation, array_column($sequences, "id"), $request["idClasse"], $idOptionLevel);

                //Somme des notes obtenues et notes max pour chaque element(typeEval, Mat, GroupMat, Eval)
                $evaluationsValides = $this->sommeDesNotes($donneesEvaluation["evaluationsValides"], array_column($sequences ?? [], "id"), array_column($trimestres ?? [], 'id'));
                $evaluationsInvalides = $this->sommeDesNotes($donneesEvaluation["evaluationsInvalides"], array_column($sequences, "id"), array_column($trimestres ?? [], 'id'));
                $donneesEvaluation = $evaluationsValides + $evaluationsInvalides;

                //On calcule les statistiques de la classe, des matieres et type d'evaluation
                $donnees= $this->getDonneesClasseMatieresTypeEvaluation($evaluationsValides, $request["idClasse"], array_column($sequences, "id"), $idOptionLevel, $request["route"], array_column($trimestres ?? [], 'id'));



                //Considerer uniquement les eleves qui ont effectuer uniquement 70% des evaluations d'une sequence
                //Commentez ou supprimez si vous souhaitez compter tous les eleves dans la classe
                $effectif = count($evaluationsValides);

                $ecole = $this->getInfosEcole($request["idClasse"]);
                $ecole['principal'] =  $ecole->principal;
                //return $ecole;
                $enseignant = $classe->teacher;

                // Convertir en array et ajouter l'effectif
                $infosClasse = [
                    'nomEnseignant'       => $enseignant->name ?? null,
                    'signatureEnseignant' => $enseignant->signature ?? null,
                    'effectifClasse'     => $effectif
                ];

                $template = $styleBulletin
                    ? "documents.bulletin-primaire.bulletin-maternelle"
                    : "documents.bulletin-primaire.bulletin-primaire";


                //On crée le code couleur
                $legend_of_grade = [
                    'nye' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                        return $moyenneStud < 10;
                    })),
                    'nye_color' => "db0b32",
                    'ae' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                        return $moyenneStud >= 10 && $moyenneStud < 15;
                    })),
                    'ae_color' => "fdaa3e",
                    'me' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                        return $moyenneStud >= 15 && $moyenneStud < 18;
                    })),
                    'me_color' => "0080ff",
                    'abe' => count(array_filter($donnees["donneesClasse"]["moyennesObtenues"], function($moyenneStud) {
                        return $moyenneStud >= 18;
                    })),
                    'abe_color' => "008000",
                ];

                $academicYear = $request->idAcademicYear ? AcademicYear::find($request['idAcademicYear']) : AcademicYear::getCurrent();


//                 return $trimestres;
//                 return $evaluation;
                // return $donneesEvaluation;
//                 return $donnees["donneesMatiere"];
//                 return $donnees["donneesClasse"];

                if(($request["idUser"]) !== null){

                    if(isset($donneesEvaluation[$request["idUser"]])){
                        $eleve = User::find($request["idUser"]);

//                        return $donneesEvaluation[$request["idUser"]];
                        $data = [
                            'ecole' => $ecole,
                            'classe' => $classe,
                            'infosEleve' => $eleve,
                            'trimestres' => $trimestres,
                            'sequences' => $sequences,
                            "route" => $request["route"],
                            'infosClasse' => $infosClasse,
                            'infosEvaluation' => $evaluation,
                            'donneesClasse' => $donnees["donneesClasse"],
                            'donneesMatieres' => $donnees["donneesMatiere"],
                            'evaluation' => $donneesEvaluation[$request["idUser"]],
                            "codeCouleur" => explode(";", Establishment::first()->code_couleur),
                            "legend_of_grade" => $legend_of_grade,
                            'annee_scolaire' => $academicYear->label,
                            "decisionAnnuelle" => $eleve->getDecisionForOptionLevel($idOptionLevel),
                            'academic_year' => AcademicYear::getCurrent()->label ?? '-'
                        ];
                        $nomFichier = "$langue" . Str::slug($eleve->name) . '.' . Str::slug($evaluation->name);

                        $individualCounter = 1;
                        $baseNomFichier = $nomFichier;
                        while (file_exists(public_path("pdfs/{$nomFichier}.pdf"))) {
                            $nomFichier = $baseNomFichier . "-" . $individualCounter;
                            $individualCounter++;
                        }

                        if (!$optimalScale){
                            $optimalScale = $this->calculateOptimalScaleSecondaire($template, $data);
                        }

                        $path = $this->genererDocumentPrimaireAutoScale($nomFichier, $template, $data, $zip, $optimalScale);
                        $liensBulletins[] = $path;
                        $liensRepertoires[] = "pdfs/$langue";
                    }elseif ($nbrEvaluationValid > 0 || end($idOptionLevels) !== $idOptionLevel){
                        continue;
                    }
                    else{
                        return $this->sendError(__('bulletin.not_found_student'));
                    }
                }
                else{
                    $studentCounter = 1;
                    foreach($donneesEvaluation as $idEleve => $donneeEvaluation){
                        // Pour les teachers, filtrer les élèves insolvables (leur bulletin n'apparaît pas)
                        if ($this->getRole()->id == 5 && $insolvablesTeachers && !$this->isSolvable($insolvablesTeachers, $idEleve)) {
                            continue;
                        }

                        $eleve = User::find($idEleve);

                        $data = [
                            'ecole' => $ecole,
                            'classe' => $classe,
                            'infosEleve' => $eleve,
                            'trimestres' => $trimestres,
                            'sequences' => $sequences,
                            "route" => str_contains($request["route"], "juniors") ? "juniors" : $request["route"],
                            'infosClasse' => $infosClasse,
                            'infosEvaluation' => $evaluation,
                            'donneesClasse' => $donnees["donneesClasse"],
                            'donneesMatieres' => $donnees["donneesMatiere"],
                            'evaluation' => $donneeEvaluation,
                            "codeCouleur" => explode(";", Establishment::first()->code_couleur),
                            "legend_of_grade" => $legend_of_grade,
                            'annee_scolaire' => $academicYear->label,
                            "decisionAnnuelle" => $eleve->getDecisionForOptionLevel($idOptionLevel),
                            'academic_year' => AcademicYear::getCurrent()->label ?? '-'
                        ];

                        if (!$optimalScale){
                            $optimalScale = $this->calculateOptimalScaleSecondaire($template, $data);
                        }

                        if (count($idOptionLevels) > 1){
                            $nomFichier = "$langue/" . $studentCounter . '-' . Str::slug($eleve->name) . '.' . Str::slug($evaluation->name);
                            $liensBulletins[] = $this->genererDocumentPrimaireAutoScale($nomFichier, $template, $data, $zip, $optimalScale);
                        }
                        else{
                            $nomFichier = $studentCounter . '-' . Str::slug($eleve->name) . '.' . Str::slug($evaluation->name);
                            $liensBulletins[] = $this->genererDocumentPrimaireAutoScale($nomFichier, $template, $data, $zip, $optimalScale);
                        }
                        $studentCounter++;
                    }
                }
                $nbrEvaluationValid ++;
            }

            $zip->close();


            if(($request["idUser"] ?? null) !== null){
                if (file_exists("pdfs/$zip_file")) {
                    unlink("pdfs/$zip_file");
                }

                return $this->sendResponse(asset($this->fusionnerEtRetournerBulletins($liensRepertoires, $liensBulletins, $eleve["name"])), "Bulletin $style");
            }
            else{
                register_shutdown_function(function () use ($liensBulletins) {
                    $this->deletePDFTempFiles($liensBulletins);
                });

                foreach ($liensRepertoires as $liensRepertoire) {
                    $this->deleteDirectory($liensRepertoire);
                }

                return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletins $style");
            }
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            $log_msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($log_msg);

            $msg = ($th->getMessage() === "Division by zero") ? "Division by zero" :  __('app.error_occured');

            return $this->sendError($msg, [], 404, $log_msg);
        }
    }



    public function genererBulletinPrimaireSmart2(GenererBulletinPrimaireRequest $request)
    {
        try {
            set_time_limit(300);

            $sequences = null;
            $trimestres = null;
            $styleBulletin = $request["styleMaternelle"] ?? null;

            //On détermine le type de bulletin demandé
            if (!is_null($request["idTrimestre"])) {
                //Pour un bulletin trimestriel
                $evaluation = Trimestre::find($request["idTrimestre"]);
                $sequences = AssessmentType::where("idTrimestre", $request["idTrimestre"])->get()->toArray();
            } else if (!is_null($request["idAssessmentType"])) {
                //Pour un bulletin sequentielle
                $evaluation = AssessmentType::find($request["idAssessmentType"]);
                $sequences[] = AssessmentType::find($request["idAssessmentType"]);
            } else {
                //Pour un bulletin annuel
                $sequences = AssessmentType::where('idSection', function ($query) use ($request) {
                    $query->select('idSection')
                        ->from('classes')
                        ->where('id', $request['idClasse']);
                })->get()->toArray();


                $evaluation = new ArrayObject([
                    'name' => __("bulletin_primaire.annual")
                ], ArrayObject::ARRAY_AS_PROPS);

                $trimestres = Trimestre::select('id', 'name')
                    ->where("takenIntoAccount", 0)
                    ->whereIn("id", AssessmentType::whereIn("id", array_column($sequences, "id"))
                        ->distinct()
                        ->pluck("idTrimestre"))
                    ->distinct()
                    ->get()->toArray();
            }

            if (is_null($sequences)) {
                //Aucune sequence retrouvee
                return $this->sendError("Sequence(s) introuvables");
            } else {
                $classe = Classes::select("classes.*", "section.name as nomSection")
                    ->join("section", "section.id", "=", "classes.idSection")
                    ->where("classes.id", $request["idClasse"])->first();
            }

            $idOptionLevels = DB::table('assessments')
                ->join('matter', 'assessments.idMatter', '=', 'matter.id')
                ->where('assessments.idClasse', $classe->id)
                ->whereNotNull('matter.idOptionLevel')
                ->distinct()
                ->pluck('matter.idOptionLevel')
                ->toArray();

            if (empty($idOptionLevels)) {
                $idOptionLevels[] = null;
            }

            // Early language detection to ensure correct translation of the evaluation name (e.g. "Annuel") and ZIP naming
            $initialLang = null;
            if (!empty($idOptionLevels)) {
                $firstOptionLevel = OptionLevel::find($idOptionLevels[0]);
                if ($firstOptionLevel) {
                    $initialLang = $firstOptionLevel->lang;
                }
            }
            if (!$initialLang) {
                $section = Section::find($classe->idSection);
                if ($section) {
                    $initialLang = $section->lang;
                }
            }
            if (!$initialLang) {
                $initialLang = 'fr';
            }
            App::setLocale(strtolower($initialLang));

            if (is_null($request["idTrimestre"]) && is_null($request["idAssessmentType"])) {
                $evaluation->name = __("bulletin_primaire.annual");
            }

            //Fichiers zip pour stocker les bulletins de la classe
            $style = $styleBulletin
                ? 'maternelle'
                : 'primaire';

            $zip_file = "Bulletins-$style-" . Str::slug($classe["name"]) . '-' . Str::slug($evaluation->name) . ".zip";

            $liensBulletins = [];
            $liensRepertoires = [];
            $zip = new \ZipArchive();

            $this->createDirectory("pdfs");
            $zip->open("pdfs/$zip_file", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            foreach ($idOptionLevels as $idOptionLevel) {

                //Configuration des préférences
                {
                    $langue = null;
                    $optionLevel = OptionLevel::find($idOptionLevel);

                    if ($optionLevel) {
                        $langue = $optionLevel->lang;
                    } else {
                        $section = Section::find($classe->idSection);
                        if ($section) {
                            $langue = $section->lang;
                        }
                    }

                    if (!$langue) {
                        $langue = 'fr';
                    }

                    $liensRepertoires [] = "pdfs/$langue";
                    $this->createDirectory("pdfs/$langue");

                    App::setLocale(strtolower($langue));
                    if (is_null($request["idTrimestre"]) && is_null($request["idAssessmentType"])) {
                        $evaluation->name = __("bulletin_primaire.annual");
                    }

                    $trimestres = $this->formatNomTrimestre($trimestres);
                }


                //Analyse et construction contruction de bulletins

                $donneeEvaluationEleves = $this->listeDesEleves($request->idClasse, $sequences);

                foreach ($donneeEvaluationEleves as &$donneeEvaluationEleve) {
                    $idEleve = $donneeEvaluationEleve['id'];

                    foreach (array_column($sequences, 'id') as $idSequence) {
                        $donneeEvaluations = $this->listerLesEvaluations($request->idClasse, $idOptionLevel, $idSequence);

                        foreach ($donneeEvaluations as $idEvaluation => &$donneeEvaluation) {
                            $donneeTypesEvaluation = $this->listerLesTypesEvaluation($idEvaluation);

                            $donneeEvaluationEleve["sequence$idSequence"][$donneeEvaluation['matter_id']] = $donneeEvaluation;
                            foreach ($donneeTypesEvaluation as $idTypeEvaluation => $typeEvaluation) {

                                $note = $this->noteTYpeEvaluation($idEleve, $idSequence, $idEvaluation, $idTypeEvaluation);

                                $formatNotes = new stdClass();

                                $formatNotes->idEvaluation = $idEvaluation;
                                $formatNotes->idMatiere = $donneeEvaluation['matter_id'];
                                $formatNotes->nomMatiere = $donneeEvaluation['matter_name'];
                                $formatNotes->idTypeEvaluation = $idTypeEvaluation;
                                $formatNotes->nomTypeEvaluation = $note['evaluation_type_name'];
                                $formatNotes->libelleTypeEvaluation = $note['evaluation_type_libelle'];
                                $formatNotes->noteMaxTypeEvaluation = $note['evaluation_type_note_max'];
                                $formatNotes->noteTypeEvaluation = $note['evaluation_type_note'];

                                $donneeEvaluationEleve["sequence$idSequence"][$donneeEvaluation['matter_id']][$idTypeEvaluation] = (array)$formatNotes;
                            }
                        }
                    }
                }


                //On determine les notes totale pour les matières, types d'évaluation et élèves
                $donneeEvaluationEleves = $this->calculSommeNoteEtNoteMax($donneeEvaluationEleves, array_column($sequences, null, 'id'), $request->idClasse, $idOptionLevel);

                //Calculs statistiques
                $statistiqueEvaluations = $this->calculsStatistique($donneeEvaluationEleves);

                $statistiqueEvaluations = $this->matiereParGroupe($statistiqueEvaluations, $request->idClasse);

                //Donnees suplémentaires
                {
                    //On récupère les informations sur la classe
                    $infosClasse = [
                        "nomEnseignant" => User::join("classes", "classes.idTeacher", "users.id")
                            ->where("classes.deleted", 0)
                            ->where("classes.id", $request["idClasse"])
                            ->value("users.name"),
                        "effectifClasse" => count($statistiqueEvaluations['class_averages'])
                    ];

                    //On a choisi le fichier à utiliser
                    $template = $styleBulletin
                        ? "documents.bulletins.maternelle"
                        : "documents.bulletins.primaire";


                    //On crée le code couleur
                    $legend_of_grade = [
                        'nye' => count(array_filter($statistiqueEvaluations['class_averages'], function ($moyenneStud) {
                            return $moyenneStud < 10;
                        })),
                        'nye_color' => "db0b32",
                        'ae' => count(array_filter($statistiqueEvaluations['class_averages'], function ($moyenneStud) {
                            return $moyenneStud >= 10 && $moyenneStud < 15;
                        })),
                        'ae_color' => "fdaa3e",
                        'me' => count(array_filter($statistiqueEvaluations['class_averages'], function ($moyenneStud) {
                            return $moyenneStud >= 15 && $moyenneStud < 18;
                        })),
                        'me_color' => "0080ff",
                        'abe' => count(array_filter($statistiqueEvaluations['class_averages'], function ($moyenneStud) {
                            return $moyenneStud >= 18;
                        })),
                        'abe_color' => "008000",
                    ];

                    //On reformate les donnees pour faciliter les recherches
                    // Reformatage une seule fois
                    $formatDonneeEvaluationEleves = [];

                    unset($donneeEvaluationEleve);
                    foreach ($donneeEvaluationEleves as $donneeEvaluationEleve) {
                        $formatDonneeEvaluationEleves[$donneeEvaluationEleve['id']] = $donneeEvaluationEleve;
                    }
                }

                if (($request["idUser"]) !== null) {

                    if (isset($formatDonneeEvaluationEleves[$request->idUser])) {
                        $eleve = User::find($request["idUser"]);

//                        return $formatDonneeEvaluationEleves[$request->idUser];
//                        return $statistiqueEvaluations;

                        $data = [
                            "route" => $request["route"],
                            'ecole' => $this->getInfosEcole($request->idClasse),
                            'classe' => $classe,
                            'infosClasse' => $infosClasse,
                            'sequences' => $trimestres ?? $sequences,
                            'type' => $trimestres === null ? 'sequence' : 'trimestre',
                            'infosEvaluation' => $evaluation,
                            'eleve' => $formatDonneeEvaluationEleves[$request->idUser],
                            'statistiques' => $statistiqueEvaluations,
                            "legend_of_grade" => $legend_of_grade,
                            "codeCouleur" => explode(";", Establishment::first()->code_couleur),
                        ];

                        $nomFichier = "$langue" . Str::slug($eleve["name"] . ' ' . $evaluation->name);
                        $liensBulletins[] = $this->genererDocument($nomFichier, $template, $data, $zip);
                    } else {
                        return $this->sendError("L'élève que vous avez choisi n'a pas effectué cette évaluation");
                    }
                }
                else {
                    foreach($formatDonneeEvaluationEleves as $idEleve => $formatDonneeEvaluationEleve){
                        $eleve = User::find($idEleve);

                        $data = [
//                            'ecole' => $ecole,
//                            'classe' => $classe,
//                            'infosEleve' => $eleve,
//                            'trimestres' => $trimestres,
//                            'sequences' => $trimestres ?? $sequences,
//                            "route" => $request["route"],
//                            'infosClasse' => $infosClasse,
//                            'infosEvaluation' => $evaluation,
//                            'donneesClasse' => $donnees["donneesClasse"],
//                            'donneesMatieres' => $donnees["donneesMatiere"],
//                            'evaluation' => $donneeEvaluation,
//                            "codeCouleur" => explode(";", Establishment::first()->code_couleur),
//                            "legend_of_grade" => $legend_of_grade,
                        ];

                        if (count($idOptionLevels) > 1){
                            $liensBulletins[] = $this->genererDocument("$langue/" . Str::slug($eleve["name"]), $template, $data, $zip);
                        }
                        else{
                            $liensBulletins[] = $this->genererDocument(Str::slug($eleve["name"]), $template, $data, $zip);
                        }
                    }
                }
            }

            $zip->close();

            if(($request["idUser"] ?? null) !== null){
                if (file_exists("pdfs/$zip_file")) {
                    unlink("pdfs/$zip_file");
                }

                return $this->sendResponse(asset($this->fusionnerEtRetournerBulletins($liensRepertoires, $liensBulletins, $eleve["name"])), "Bulletin $style");
            }
            else{
                register_shutdown_function(function () use ($liensBulletins) {
                    $this->deletePDFTempFiles($liensBulletins);
                });

                foreach ($liensRepertoires as $liensRepertoire) {
                    $this->deleteDirectory($liensRepertoire);
                }

                return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletins $style");
            }
        } catch (Exception $e) {
            return $this->sendError("Un probleme est survenue lors du calcul des notes");
        }
    }

    public function statistiquesAnnuelles(StatistiquesAnnuellesRequest $request)
    {
        set_time_limit(600);

        $classesQuery = Classes::query();

        if ($request->filled('idSchool')) {
            $classesQuery->where('idSchool', $request->idSchool);
        }

        if ($request->filled('idClasse')) {
            $classesQuery->where('id', $request->idClasse);
        } elseif ($request->filled('idLevel')) {
            $classesQuery->where('idLevel', $request->idLevel);
        }

        $classes = $classesQuery->get();

        $statistiquesGlobales = [
            'sequences' => [],
            'trimestres' => [],
        ];

        $sequencesBySection = [];
        $sequencesByTrimestre = [];
        $sequenceIdsBySection = [];
        $trimestreIdsBySection = [];
        $sequenceKeyBySection = [];
        $trimestreKeyById = [];
        $optionLevelsByClass = [];
        $schoolLevelById = [];
        $seqFractionsBySection = [];

        $secondaireHelper = new class {
            use \App\Traits\BulletinSecondaireTrait;
        };

        foreach ($classes as $classe) {
            $sectionId = $classe->idSection;

            if (!isset($sequencesBySection[$sectionId])) {
                $sequencesBySection[$sectionId] = AssessmentType::where('idSection', $sectionId)
                    ->select('id', 'name', 'idTrimestre', 'pourcentage')
                    ->get();
            }

            $sequences = $sequencesBySection[$sectionId];
            if ($sequences->isEmpty()) {
                continue;
            }

            if (!isset($sequencesByTrimestre[$sectionId])) {
                $byTrim = [];
                foreach ($sequences as $sequence) {
                    $byTrim[$sequence->idTrimestre][] = $sequence->id;
                }
                $sequencesByTrimestre[$sectionId] = $byTrim;
            }

            if (!isset($sequenceIdsBySection[$sectionId])) {
                $sequenceIdsBySection[$sectionId] = $sequences->pluck('id')->toArray();
            }
            $sequenceIdsAll = $sequenceIdsBySection[$sectionId];

            if (!isset($trimestreIdsBySection[$sectionId])) {
                $trimestreIdsBySection[$sectionId] = array_keys($sequencesByTrimestre[$sectionId]);
            }
            $trimestreIdsAll = $trimestreIdsBySection[$sectionId];

            if (!isset($sequenceKeyBySection[$sectionId])) {
                $sequenceKeyBySection[$sectionId] = [];
                foreach ($sequences as $sequence) {
                    $sequenceKeyBySection[$sectionId][$sequence->id] = (is_string($sequence->name) && $sequence->name !== '')
                        ? substr($sequence->name, -1)
                        : (string)$sequence->id;
                }
            }

            foreach ($sequences as $sequence) {
                $sequenceKey = $sequenceKeyBySection[$sectionId][$sequence->id];
                if (!isset($statistiquesGlobales['sequences'][$sequenceKey])) {
                    $statistiquesGlobales['sequences'][$sequenceKey] = [];
                }

                $trimestreId = $sequence->idTrimestre;
                if (!isset($trimestreKeyById[$trimestreId])) {
                    $trimestre = Trimestre::select('name')->find($trimestreId);
                    $trimestreKeyById[$trimestreId] = $trimestre && $trimestre->name
                        ? substr($trimestre->name, -1)
                        : (string)$trimestreId;
                }
                $cleTrimestre = $trimestreKeyById[$trimestreId];
                if (!isset($statistiquesGlobales['trimestres'][$cleTrimestre])) {
                    $statistiquesGlobales['trimestres'][$cleTrimestre] = [];
                }
            }

            if (!isset($schoolLevelById[$classe->idSchool])) {
                $schoolLevelById[$classe->idSchool] = School::where('id', $classe->idSchool)
                    ->value('scholar_level');
            }

            $scholarLevel = strtolower($schoolLevelById[$classe->idSchool] ?? '');
            $isSecondary = in_array($scholarLevel, ['secondary', 'secondaire'], true);

            if ($isSecondary) {
                if (!isset($seqFractionsBySection[$sectionId])) {
                    $seqFractionsBySection[$sectionId] = $this->buildSequenceFractions($sequenceIdsAll);
                }

                $evaluationElevesAll = $secondaireHelper->getEvaluationEleve($sequenceIdsAll, $classe->id);
                $resultatsAll = $secondaireHelper->calculeNotesTotales(
                    $evaluationElevesAll,
                    $classe->id,
                    $sequenceIdsAll,
                    'annuel',
                    [],
                    $sequences->toArray()
                );

                $eleves = $resultatsAll['eleves'];
                $secondaryAverages = $this->computeSecondaireAverages(
                    $eleves,
                    $sequenceIdsAll,
                    $sequencesByTrimestre[$sectionId],
                    $seqFractionsBySection[$sectionId]
                );

                foreach ($sequences as $sequence) {
                    $sequenceKey = $sequenceKeyBySection[$sectionId][$sequence->id];
                    $avg = $secondaryAverages['sequences'][$sequence->id] ?? null;
                    if ($avg !== null) {
                        $statistiquesGlobales['sequences'][$sequenceKey][] = $avg;
                    }
                }

                foreach ($sequencesByTrimestre[$sectionId] as $trimestreId => $seqIds) {
                    $cleTrimestre = $trimestreKeyById[$trimestreId];
                    $avg = $secondaryAverages['trimestres'][$trimestreId] ?? null;
                    if ($avg !== null) {
                        $statistiquesGlobales['trimestres'][$cleTrimestre][] = $avg;
                    }
                }
            } else {
                if (!isset($optionLevelsByClass[$classe->id])) {
                    $optionLevels = DB::table('assessments')
                        ->join('matter', 'assessments.idMatter', '=', 'matter.id')
                        ->where('assessments.idClasse', $classe->id)
                        ->whereNotNull('matter.idOptionLevel')
                        ->distinct()
                        ->pluck('matter.idOptionLevel')
                        ->toArray();

                    $optionLevelsByClass[$classe->id] = !empty($optionLevels) ? $optionLevels : [null];
                }

                foreach ($optionLevelsByClass[$classe->id] as $idOptionLevel) {
                    $evaluationsValides = $this->buildPrimaireEvaluationsValides(
                        $classe->id,
                        $sequenceIdsAll,
                        $trimestreIdsAll,
                        $idOptionLevel
                    );

                    if (empty($evaluationsValides)) {
                        continue;
                    }

                    $primaryAverages = $this->computePrimaireAverages(
                        $evaluationsValides,
                        $sequenceIdsAll,
                        $trimestreIdsAll
                    );

                    foreach ($sequences as $sequence) {
                        $sequenceKey = $sequenceKeyBySection[$sectionId][$sequence->id];
                        $avg = $primaryAverages['sequences'][$sequence->id] ?? null;

                        if ($avg !== null) {
                            $statistiquesGlobales['sequences'][$sequenceKey][] = $avg;
                        }
                    }

                    foreach ($sequencesByTrimestre[$sectionId] as $trimestreId => $unusedSeqIds) {
                        $cleTrimestre = $trimestreKeyById[$trimestreId];
                        $avg = $primaryAverages['trimestres'][$trimestreId] ?? null;

                        if ($avg !== null) {
                            $statistiquesGlobales['trimestres'][$cleTrimestre][] = $avg;
                        }
                    }
                }
            }
        }

        foreach ($statistiquesGlobales as &$trimestresOuSequences) {
            foreach ($trimestresOuSequences as $key => &$trimestreOuSequence) {
                $moyennes = array_values(array_filter($trimestreOuSequence, function ($moyenne) {
                    return $moyenne !== null;
                }));

                $trimestreOuSequence = count($moyennes) > 0
                    ? array_sum($moyennes) / count($moyennes)
                    : null;
            }
        }

        return $statistiquesGlobales;
    }

    private function buildPrimaireEvaluationsValides($idClasse, array $sequenceIds, array $trimestreIds, $idOptionLevel)
    {
        $notes = $this->getNoteEvaluation($idClasse, $sequenceIds, $idOptionLevel);
        $donneesEvaluation = $this->regroupeNoteParEleveParGroupeParMatiere($notes, $sequenceIds, $trimestreIds);

        if (count($donneesEvaluation) <= 0) {
            return [];
        }

        $donneesEvaluation = $this->analyserEvaluationEleves($donneesEvaluation, $sequenceIds, $idClasse, $idOptionLevel);

        return $this->sommeDesNotes($donneesEvaluation["evaluationsValides"] ?? [], $sequenceIds, $trimestreIds);
    }

    private function computePrimaireAverages(array $evaluationsValides, array $sequenceIds, array $trimestreIds)
    {
        if (empty($evaluationsValides)) {
            return [
                'sequences' => [],
                'trimestres' => [],
            ];
        }

        $seqSums = array_fill_keys($sequenceIds, 0.0);
        $seqCounts = array_fill_keys($sequenceIds, 0);
        $trimSums = array_fill_keys($trimestreIds, 0.0);
        $trimCounts = array_fill_keys($trimestreIds, 0);

        foreach ($evaluationsValides as $eleve) {
            foreach ($sequenceIds as $sequenceId) {
                $moyKey = "moySeq$sequenceId";
                $evalKey = "isEvalueSeq$sequenceId";

                if (($eleve["isEvalueSeq"][$evalKey] ?? false) && isset($eleve["moyennesSeq"][$moyKey]) && $eleve["moyennesSeq"][$moyKey] !== null) {
                    $seqSums[$sequenceId] += $eleve["moyennesSeq"][$moyKey];
                    $seqCounts[$sequenceId]++;
                }
            }

            foreach ($trimestreIds as $trimestreId) {
                $moyKey = "moyTrim$trimestreId";
                $evalKey = "isEvalueTrim$trimestreId";

                if (($eleve["isEvalueTrim"][$evalKey] ?? false) && isset($eleve["moyennesTrim"][$moyKey]) && $eleve["moyennesTrim"][$moyKey] !== null) {
                    $trimSums[$trimestreId] += $eleve["moyennesTrim"][$moyKey];
                    $trimCounts[$trimestreId]++;
                }
            }
        }

        $sequenceAverages = [];
        foreach ($sequenceIds as $sequenceId) {
            $sequenceAverages[$sequenceId] = $seqCounts[$sequenceId] > 0
                ? $seqSums[$sequenceId] / $seqCounts[$sequenceId]
                : null;
        }

        $trimestreAverages = [];
        foreach ($trimestreIds as $trimestreId) {
            $trimestreAverages[$trimestreId] = $trimCounts[$trimestreId] > 0
                ? $trimSums[$trimestreId] / $trimCounts[$trimestreId]
                : null;
        }

        return [
            'sequences' => $sequenceAverages,
            'trimestres' => $trimestreAverages,
        ];
    }

    private function computeSecondaireAverages(array $eleves, array $sequenceIds, array $sequencesByTrimestre, array $seqFractions)
    {
        $seqSums = array_fill_keys($sequenceIds, 0.0);
        $seqCounts = array_fill_keys($sequenceIds, 0);

        $trimSums = [];
        $trimCounts = [];
        $defaultWeightByTrim = [];
        foreach ($sequencesByTrimestre as $trimestreId => $seqIds) {
            $trimSums[$trimestreId] = 0.0;
            $trimCounts[$trimestreId] = 0;
            $defaultWeightByTrim[$trimestreId] = count($seqIds) > 0 ? 1 / count($seqIds) : 0;
        }

        foreach ($eleves as $eleve) {
            foreach ($sequenceIds as $sequenceId) {
                $moyKey = "moyenneSeq$sequenceId";
                $evalKey = "isEvalueSeq$sequenceId";

                if (($eleve[$evalKey] ?? false) && isset($eleve[$moyKey]) && $eleve[$moyKey] !== null) {
                    $seqSums[$sequenceId] += $eleve[$moyKey];
                    $seqCounts[$sequenceId]++;
                }
            }

            foreach ($sequencesByTrimestre as $trimestreId => $seqIds) {
                $sum = 0;
                $totalWeight = 0;
                $hasEval = false;
                $defaultWeight = $defaultWeightByTrim[$trimestreId];

                foreach ($seqIds as $seqId) {
                    $moyKey = "moyenneSeq$seqId";
                    $evalKey = "isEvalueSeq$seqId";

                    if (($eleve[$evalKey] ?? false) && isset($eleve[$moyKey]) && $eleve[$moyKey] !== null) {
                        $weight = $seqFractions[$seqId] ?? $defaultWeight;
                        $sum += $eleve[$moyKey] * $weight;
                        $totalWeight += $weight;
                        $hasEval = true;
                    }
                }

                if ($hasEval && $totalWeight > 0) {
                    $trimSums[$trimestreId] += $sum / $totalWeight;
                    $trimCounts[$trimestreId]++;
                }
            }
        }

        $sequenceAverages = [];
        foreach ($sequenceIds as $sequenceId) {
            $sequenceAverages[$sequenceId] = $seqCounts[$sequenceId] > 0
                ? $seqSums[$sequenceId] / $seqCounts[$sequenceId]
                : null;
        }

        $trimestreAverages = [];
        foreach ($trimSums as $trimestreId => $sum) {
            $trimestreAverages[$trimestreId] = $trimCounts[$trimestreId] > 0
                ? $sum / $trimCounts[$trimestreId]
                : null;
        }

        return [
            'sequences' => $sequenceAverages,
            'trimestres' => $trimestreAverages,
        ];
    }

    private function buildSequenceFractions(array $sequenceIds): array
    {
        if (empty($sequenceIds)) {
            return [];
        }

        $seqPourcentages = AssessmentType::whereIn('id', $sequenceIds)
            ->pluck('pourcentage', 'id')
            ->toArray();

        $maxPct = $seqPourcentages ? max($seqPourcentages) : 0;
        $seqFractions = [];
        foreach ($sequenceIds as $sequenceId) {
            if (!array_key_exists($sequenceId, $seqPourcentages)) {
                $seqFractions[$sequenceId] = null;
                continue;
            }

            $pct = $seqPourcentages[$sequenceId];
            if ($pct === null) {
                $seqFractions[$sequenceId] = null;
                continue;
            }

            $seqFractions[$sequenceId] = ($maxPct > 1) ? $pct / 100 : $pct;
        }

        return $seqFractions;
    }
}
