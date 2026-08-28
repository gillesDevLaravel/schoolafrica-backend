<?php

namespace App\Http\Controllers\Bulletins;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RatingController;
use App\Http\Requests\Admin\BulletinSecondaireSequenceRequest;
use App\Http\Requests\Admin\BulletinSecondaireTrimestreRequest;
use App\Http\Requests\Admin\BulletinSecondaireRequest;
use App\Http\Requests\Admin\PVSecondaireRequest;
use App\Http\Requests\AfficherNotesPrimaireRequest;
use App\Http\Requests\BulletinSecondaireGeneralRequest;
use App\Models\Absence;
use App\Models\AcademicYear;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Establishment;
use App\Models\Key;
use App\Models\MatterGroup;
use App\Models\Rating;
use App\Models\Sanction;
use App\Models\School;
use App\Models\Section;
use App\Models\Semestre;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use App\Services\PensionUserService;
use App\Traits\BulletinSecondaireTrait;
use App\Traits\DeletePDFTmpFilesTrait;
use App\Traits\ManageDirectoryTrait;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Exception;
use Google\Service\WorkloadManager\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PhpParser\JsonDecoder;
use stdClass;

use function PHPSTORM_META\elementType;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

/**
 * @group Bulletins Secondaire
 */
class BulletinSecondaireController extends BaseController
{
    use DeletePDFTmpFilesTrait, ManageDirectoryTrait, BulletinSecondaireTrait;
    protected $pensionUserService;
    private $listRoleSimple = [7, 8];

    public function __construct(PensionUserService $pensionUserService)
    {
        $this->pensionUserService = $pensionUserService;
    }

    /**
     * Générer bulletin séquence du secondaire
     *
     * @param BulletinSecondaireSequenceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinSecondaireSequence(BulletinSecondaireSequenceRequest $request)
    {
        /**
         * VALID PAYLOAD
         * BD: dev
         *
         * { "username":"fondateur", "password":"000000", "idClasse":56, "idAssessmentType":18, "idUser":1089 }
         */
        $this->createDirectory('pdfs');

        ini_set('max_execution_time', 300);

        try {
            $classe = Classes::find($request->idClasse);
            $school = School::find($classe->idSchool);
            $idUser = $request->idUser ?? null;

            $requestData = $request->validated();
            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $requestData['idUser'] = null; // On ne veut pas envoyer ça au code du dev précédent (cf $idUser plus haut)

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

            Cache::forget("bulletinSecondaireGeneralSequentiel{$classe->id}");
            $infosBulletins = cache()->remember("bulletinSecondaireGeneralSequentiel{$classe->id}", 1200, function() use ($requestData){
                return $this->bulletinSequence($requestData)->getData();
            });
            $infosBulletins->periode = AssessmentType::find($request->idAssessmentType);

            if($infosBulletins->success != true || $infosBulletins->data->effectifClasse == 0){
                return $this->sendError($infosBulletins->message, []);
            }

            $liensBulletins = [];

            $json_data = $infosBulletins->data;

//            return $infosBulletins->data->user;

            /**
             * Calcul des infos générales (moyenne générale, moyenne MIN, moyenne MAX, ...)
             */
            $moyennes = array();
            $rangs = array();
            $nbreMoyennes = 0;

            $notesPerMatterGroup = array(); // on range les notes par matterGroup afin d'avoir les min;max par évaluation
            foreach ($infosBulletins->data->user as $user) {
                $moyennes[] = $user->trimestre[0]->assessmentType[0]->moyenne;

                if($user->trimestre[0]->assessmentType[0]->moyenne >= 10){
                    $nbreMoyennes++;
                }

                //On cacule le min;max de chaque groupe de matières
                foreach ($user->trimestre[0]->assessmentType[0]->matterGroup as $matterGroup) {
                    if(!isset($notesPerMatterGroup[$matterGroup->id])){
                        $notesPerMatterGroup[$matterGroup->id] = array();
                    }

                    array_push($notesPerMatterGroup[$matterGroup->id], @$matterGroup->totalNoteByMatterGroup);
                }
            }

            foreach ($notesPerMatterGroup as $matterGroupId => $notesOnMatterGroup) {
                sort($notesOnMatterGroup);

                $notesPerAssessment[$matterGroupId] = $notesOnMatterGroup;

                $notesPerMatterGroup[$matterGroupId]['min'] = $notesOnMatterGroup[0] ?? 0;
                $notesPerMatterGroup[$matterGroupId]['max'] = end($notesOnMatterGroup) ?? 0;
            }

            asort($moyennes);
            $moyennes = array_values($moyennes);

            if(!is_null($request->idUser)){
                $idUser = $request->idUser;

                $infosBulletins->data->user = collect($infosBulletins->data->user)->filter(function($user) use ($idUser){
                    return $user->id == $idUser;
                })->values();
            }

            if(count((array)$infosBulletins->data->user) == 0){
                return $this->sendError("idStudent {$idUser} invalide");
            }

            $zip_file = "Bulletins-secondaire-".Str::slug($classe->name)."-sequence-".Str::slug($infosBulletins->periode->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/$zip_file", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            for ($case = 0; $case < count($infosBulletins->data->user); $case++){
                $userInfos = $infosBulletins->data->user[$case];

                //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                if($this->isSolvable($insolvables, $userInfos->id) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))){

                    $data = [
                        'effectifClasse' => $infosBulletins->data->effectifClasse,
                        'user' => $userInfos,
                        'notesPerMatterGroup' => $notesPerMatterGroup, // les notes (surtour min&max) de chaque groupe de matières
                        'school' => $school,
                        'periode' => $infosBulletins->periode,
                        'absences_non_j' => Absence::where([
                            'idStudent' => $userInfos->id,
                            'is_justified' => 0,
                        ])
                            ->where('created_at', '<', Carbon::now())
                            ->count(),
                        'absences_j' => Absence::where([
                            'idStudent' => $userInfos->id,
                            'is_justified' => 1,
                        ])
                            ->where('created_at', '<', Carbon::now())
                            ->count(),
                        'consignes_heures' => 0,
                        'avertiss_conduite' => 0,
                        'blame_conduite' => 0,
                        'exclusions_jour' => 0,
                        'exclusions_definitive' => 0,
                        'retards' => 0,
                        'first_moyenne' => end($moyennes),
                        'last_moyenne' => $moyennes[0],
                        'moyenne_generale_classe' => round(array_sum(array_map('floatval', $moyennes)) / $json_data->effectifClasse, 2),
                        'nbre_moyennes' => $nbreMoyennes,
                        'teacher_principal' => User::find($classe->idTeacher)
                    ];

                    //                return $data;

                    $filename = Str::slug($userInfos->name);

                    $dompdf = new Dompdf();

                    // Récupérer la vue
                    $view = View::make('bulletin.secondaire.general-sequence')->with($data);

                    // Récupérer le contenu de la vue
                    $html = $view->render();

                    // Charger le contenu HTML dans Dompdf
                    $dompdf->loadHtml($html);

                    // (Optionnel) Définir la taille et l'orientation du papier
                    $dompdf->setPaper('A4', 'portrait');

                    // Exécuter le rendu du PDF
                    $dompdf->render();

                    file_put_contents(public_path("pdfs/bulletin-secondaire-general-sequence-$filename.pdf"), $dompdf->output());

                    if(count($infosBulletins->data->user) > 1){
                        $zip->addFile("pdfs/bulletin-secondaire-general-sequence-$filename.pdf");

                        $liensBulletins[] = public_path("pdfs/bulletin-secondaire-general-sequence-$filename.pdf"); //storage_path("app/tmp/bulletin-trimestre-$filename.pdf");
                    }else{
                        return $this->sendResponse(asset("pdfs/bulletin-secondaire-general-sequence-$filename.pdf"), "Bulletin secondaire séquence");
                    }
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletins secondaires séquence");
        }
        catch (\Exception $e){
            Log::info("Error: " . $e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
            return $this->sendError($e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
//            return $this->sendError($exception->getMessage());
        }
    }


    public function bulletinSequence(array $request)
    {
        try{
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $effectifClasse = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('roles.id',8)
                ->where('users.idSchool',$request['idSchool'])
                ->where('users.idSection',$request['idSection'])
                ->where('users.idClasse',$request['idClasse'])
                ->where('users.deleted',0)
                ->count();

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $tabNote['effectifClasse'] = $effectifClasse;

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday','users.photo as photo',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','parent.name as father','parent.mother as mother','parent.phone as phone',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('users as parent','parent.id','=','users.idParent')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->where('ratings.idAssessmentType', $request['idAssessmentType'])
                ->where('users.idClasse',$request['idClasse'])
                ->where('users.deleted',0)
                ->orderBy("users.name", "asc")
                ->distinct('users.id')
                ->get();
            $tabNote['user'] = $entete;

            $total_moy_eleve = null;
            $moyClasse = null;
            //$total_matiere = null;
            for ($i=0; $i < $entete->count(); $i++) {
                $count_assessments = 0;

                $trimestre = Trimestre::select('trimestre.id as id','trimestre.name as name')
                    ->join('assessment_type','assessment_type.idTrimestre','=','trimestre.id')
                    ->where('trimestre.idSchool',$request['idSchool'])
                    ->where('trimestre.idSection',$request['idSection'])
                    ->where('assessment_type.id',$request['idAssessmentType'])
                    ->get();

                $tabNote['user'][$i]['trimestre'] = $trimestre;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                $totalCoef1 = null ;
                $totalCoef2 = null ;
                $totalCoef3 = null ;
                $totalCoef4 = null ;
                $totalCoef5 = null ;
                $totalCoef6 = null ;
                $totaltermAv = null ;
                $totalNoteCoef = null;

                $moyseq1 = null;
                $moyseq2 = null;
                $moyseq3 = null;
                $moyseq4 = null;
                $moyseq5 = null;
                $moyseq6 = null;

                $assessmentType = AssessmentType::select('id','name')
                    ->where('idSchool',$request['idSchool'])
                    ->where('idSection',$request['idSection'])
                    ->where('idTrimestre',$trimestre[0]['id'])
                    ->where('id',$request['idAssessmentType'])
                    ->get();

                if (!$assessmentType->isEmpty()) {
                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'] = $assessmentType;

                    $totalSequence1 = null;
                    $totalSequence2 = null;
                    $totalSequence3 = null;
                    $totalSequence4 = null;
                    $totalSequence5 = null;
                    $totalSequence6 = null;
                    $total = null;
                    $totalSeq = null;
                    $totalCoefSeq = null;
                    $coefficient = null;

                    //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                    //$total_matiere = $total_matiere + 1;
                    $rating_exits = null;
                    $matterGroup = null;

                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id', $level_classe['idLevel'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->get();

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'] = $matterGroup;

                    $coefficientSum = Assessment::join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                        ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                        ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
//                        ->join('ratings','ratings.idAssessment','=','assessments.id')
//                        ->join('matter','matter.id','=','assessments.idMatter')
//                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
//                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('assessment_type.id', $assessmentType[0]['id'])
//                        ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                        ->where('assessments.idClasse', $request['idClasse'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
//                        ->whereNotNull('ratings.value')
                        ->pluck('coefficients.value')->toArray();

                    $coefficientSum = array_sum($coefficientSum);
//                        ->get();

                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                        case "1":
                            $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "2":
                            $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "3":
                            $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "4":
                            $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "5":
                            $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "6":
                            $totalCoef6 = $coefficientSum[0]['coefficient_sum'];
                            break;
                    }

                    for ($x=0; $x < $matterGroup->count(); $x++) {
                        $totalNoteCoefMatterGroup1 = null;
                        $MatterGroupId = null;
                        $totalCoefMatterGroupAssessment = null;
                        $totalNoteCoefMatterGroup2 = null;
                        $totalCoefMatterGroup1 = null;
                        $totalCoefMatterGroup2 = null;
                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->where('matter_group.id',$matterGroup[$x]['id'])
                            ->where('assessment_type.id',$assessmentType[0]['id'])
                            ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                                $query->where('matter_group.idOptionLevel', $idOptionLevel);
                            })
                            ->get();

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'] = $assessment;
                        $total = null;

                        for ($n=0; $n < $assessment->count(); $n++) {
                            $teachername = User::select('users.name as teacherName')
                                ->join('assessments','assessments.idTeacher','=','users.id')
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->first();
//
//
                            $ratings = Rating::select(
                                'ratings.value as value',
                                'ratings.observation as observation',
                                'ratings.notemax as notemax',
                                'assessment_type.name as assessmentName',
                                'matter.name as nameMatter',
                                'coefficients.value as coefficient',
                                DB::raw('(ratings.value * coefficients.value) as noteCoef')
                            )
                                ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
                                ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                ->join('matter', 'matter.id', '=', 'ratings.idMatter')
                                ->join('coefficients','assessments.idCoeficient','=','coefficients.id')
                                ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->where('assessment_type.id',$assessmentType[0]['id'])
                                ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                ->first();

                            if(!is_null($ratings)) $count_assessments++; //On compte l'évaluation si l'élève a une note dessus

//                            if(is_null($ratings['coefficient'])){
//                                dd($assessment[$n]['idMatter'], $assessment[$n]['id'], $assessmentType[0]['id'], $tabNote['user'][$i]['id']);
//                            }

                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                            if(!empty($teachername)){
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername['teacherName'];
                            }

                            if(!empty($ratings['coefficient'])){
                                $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                            }

                            if(!empty($ratings['value'])){
                                $total = $total + $ratings['value'];
                                $rating_exits = $rating_exits + 1;
                                $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];


                                if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                                        case "1":
                                            $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                            break;
                                        case "2":
                                            $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                            break;
                                        case "3":
                                            $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                            break;
                                        case "4":
                                            $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                            break;
                                        case "5":
                                            $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                            break;
                                        case "6":
                                            $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                    $MatterGroupId = $matterGroup[$x]['id'] ;
                                    switch ($matterGroup[$x]['id']) {
                                        case $MatterGroupId:
                                            $totalNoteCoefMatterGroup1 = $totalNoteCoefMatterGroup1 + $ratings['noteCoef'];
                                            $totalCoefMatterGroup1 = $totalCoefMatterGroup1 + $ratings['coefficient'];
                                            break;
                                        /*
                                        case 2:
                                            $totalNoteCoefMatterGroup2 = $totalNoteCoefMatterGroup2 + $ratings['noteCoef'];
                                            $totalCoefMatterGroup2 = $totalCoefMatterGroup2 + $ratings['coefficient'];
                                            break;
                                            */

                                        default:
                                            # code...
                                            break;
                                    }
                                }

                            }

                            $totaltermAv = $totaltermAv + $total;


                        }

                        $MatterGroupId = $matterGroup[$x]['id'];

                        switch ($matterGroup[$x]['id']) {
                            case $MatterGroupId:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                $cleanNumber = ($totalCoefMatterGroup1>0)
                                    ? @str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2))
                                    : null;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['MoyenneMatterGroup'] = (!is_null($cleanNumber))
                                    ? floatval($cleanNumber)
                                    : null;
                                $totalSeq = $totalSeq + $total;
                                $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                break;
                        }
                    }//MatterGroup boucle fin*******************************************************************

                    if(!empty($rating_exits) && $rating_exits != 0){
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                        //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                    }else{
                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['total_trimestre'] = null;
                    }


                    //} *************************************************************** ici ***********************************************
                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequence'] = $totalSeq;

                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                        case '1':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence1;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq1 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq1;
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = 0;
                                $moyseq1 = 0;
                                $moyClasse = 0;
                            }
                            break;
                        case '2':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence2;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq2 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq2;
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = 0;
                                $moyseq2 = 0;
                                $moyClasse = 0;
                            }
                            break;
                        case '3':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence3;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq3 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq3;
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = 0;
                                $moyseq3 = 0;
                                $moyClasse = 0;
                            }
                            break;
                        case '4':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence4;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq4 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq4;
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = 0;
                                $moyseq4 = 0;
                                $moyClasse = 0;
                            }
                            break;
                        case '5':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence5;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq5 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq5;
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = 0;
                                $moyseq5 = 0;
                                $moyClasse = 0;
                            }
                            break;
                        case '6':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence6;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq6 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq6;
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = 0;
                                $moyseq6 = 0;
                                $moyClasse = 0;
                            }
                            break;
                    }

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['nbreTotalAssessments'] = $count_assessments;
                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                        case '1':
                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            break;
                        case '2':
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            break;
                        case '3':
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            break;
                        case '4':
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            break;
                        case '5':
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            break;
                        case '6':
                            $totalSequence6User = $totalSequence6User + $totalSequence6;
                            break;
                    }


                    $santion = Sanction::where('idUser',$entete[$i]['id'])->count();

                    $absence = Absence::where('idStudent',$entete[$i]['id'])->count();

                    //bonne moyenne 1
                    switch (substr($trimestre[0]['name'], -1)) {
                        case '1':
                            if($totalCoef1 != 0 && $totalCoef2 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef1 + $totalCoef2)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                                if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence1User / $totalCoef1)+($totalSequence2User / $totalCoef2))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq1 + $moyseq2)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case '2':
                            if($totalCoef3 != 0 && $totalCoef4 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef3 + $totalCoef4)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence3User + $totalSequence4User)/2;
                                if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence3User / $totalCoef3)+($totalSequence4User / $totalCoef4))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq3 + $moyseq4)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case '3':
                            if($totalCoef5 != 0 && $totalCoef6 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef5 + $totalCoef6)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence5User + $totalSequence6User)/2;
                                if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence5User / $totalCoef5)+($totalSequence6User / $totalCoef6))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq5 + $moyseq6)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;
                    }

                    $tabNote['user'][$i]['trimestre'][0]['totalAbs'] = $absence;
                    $tabNote['user'][$i]['trimestre'][0]['totalPunishment'] = $santion;
                }
            }

            if($effectifClasse != 0){
                $tabNote['moyenneClasse'] = floatval(str_replace(',', '.', number_format($moyClasse / $effectifClasse,2)));
            }else{
                $tabNote['moyenneClasse'] = null;
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
//                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
//                    $query->where('matter.idOptionLevel', $idOptionLevel);
//                })
                ->count();

            //calculer le rang par sequence

            // Vous pouvez utiliser collect pour créer une collection Laravel
            $collection = collect($tabNote['user']);

            // Ensuite, vous pouvez trier la collection en fonction de la moyenne pour un assessmentType spécifique
            $assessmentIndex = 0; // Indice de l'assessmentType que vous voulez trier
            $trimestreIndex = 0; // Indice du trimestre que vous voulez trier

            $sortedCollection = $collection->sortByDesc(function ($user) {
                return $user['trimestre'][0]['assessmentType'][0]['moyenne'];
            });

            // Vous pouvez également obtenir le rang en utilisant la méthode search
            $rankedCollection = $sortedCollection->values()->map(function ($user, $index) {
                $user['trimestre'][0]['assessmentType'][0]['rang'] = $index + 1;
                return $user;
            });

            // Maintenant, $rankedCollection contient le tableau avec les rangs assignés
            // Vous pouvez accéder aux informations comme suit :
            foreach ($rankedCollection as $user) {
                $moyenne = $user['trimestre'][0]['assessmentType'][0]['moyenne'];
                $rang = $user['trimestre'][0]['assessmentType'][0]['rang'];

                // Utilisation de $moyenne et $rang
                // Par exemple, echo "Moyenne: $moyenne, Rang: $rang";
            }

            /******************************************************fin calcul rang ********************************************/

            $tabNote['nbreTotalEvaluations'] = $nbreTotalEvaluations;
            $tabNote['allAssessments'] = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter','coefficients.value as coef')
                ->join('matter','matter.id','=','assessments.idMatter')
                ->join('coefficients', 'coefficients.id','=','assessments.idCoeficient')
                ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                ->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                ->where('assessments.idSchool',$request['idSchool'])
                ->where('assessments.idSection',$request['idSection'])
                ->where('assessments.idClasse',$request['idClasse'])
                ->where('assessment_type.id', $request['idAssessmentType'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->where('matter_group.idOptionLevel', $idOptionLevel);
                })
                ->get();
            return $this->sendResponse($tabNote, 'Bulletins');
        } catch (\Throwable $e){
            Log::info("Error: " . $e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
            return $this->sendError($e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
//            Log::info($exception->getMessage());
//            return $this->sendError($exception->getMessage());
        }
    }

    /**
     * Générer PV du secondaire
     *
     * @param PVSecondaireRequest $request
     * @return \Illuminate\Http\Response
     */
    public function pvSecondaire(PVSecondaireRequest $request)
    {
        /**
         * VALID PAYLOAD
         * BD: BOlive
         *
         * { "username":"olive", "password":"000000", "idClasse":6, "idAssessmentType":1 }
         */
        $this->createDirectory('pdfs');

        ini_set('max_execution_time', 300);

        try {
            $classe = Classes::find($request->idClasse);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $assessmentType = AssessmentType::findOrFail($request->idAssessmentType);
            $idUser = $request->idUser ?? null;
            $sortUsers = $requestData['sortUsers'] ?? "alphabetical";

            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $requestData = $request->validated();
            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $requestData['idUser'] = null; // On ne veut pas envoyer ça au code du dev précédent (cf $idUser plus haut)
            $num_sequence = substr($assessmentType->name, -1, 1);

            Cache::forget("bulletinSecondaireGeneralSequentiel{$classe->id}");
            $infosBulletins = cache()->remember("bulletinSecondaireGeneralSequentiel{$classe->id}", 1200, function () use ($requestData) {
                return $this->bulletinSequence($requestData)->getData();
            });
            $infosBulletins->periode = AssessmentType::find($request->idAssessmentType);

            if ($infosBulletins->success != true || $infosBulletins->data->effectifClasse == 0) {
                return $this->sendError($infosBulletins->message, []);
            }

            if(count($infosBulletins->data->user) == 0){
                return $this->sendError("Pas d'élèves avec de notes pour ces données");
            }

            $json_data = $infosBulletins->data;

//            return response()->json([
//                'd' => $infosBulletins,
//            ]);

            $assessments = array();

            $to_max = 0;

            foreach ($infosBulletins->data->allAssessments as $assessment) {
                $assessments[] = [
                    'id' => $assessment->id,
                    'nameMatter' => $assessment->nameMatter,
                    'codeMatter' => $assessment->codeMatter,
                    'libelleMatter' => $assessment->libelleMatter,
                    'notemax' => $assessment->notemax,
                    'coefficient' => @$assessment->coef,
                ];

                $to_max += $assessment->notemax;
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

            $tabMoyennes = array(); // ici on garde les moyennes des élèves qui ont composé au moins 70% des évaluations
            foreach ($infosBulletins->data->user as $userData) {
                $tmp_moyenne = $userData->trimestre[0]->assessmentType[0]->moyenne;
                $moyenneStudents[] = $tmp_moyenne;

                if(($infosBulletins->data->nbreTotalEvaluations>0) && ($userData->trimestre[0]->assessmentType[0]->nbreTotalAssessments*100 / $infosBulletins->data->nbreTotalEvaluations) >= 70){
                    $tabMoyennes[] = $tmp_moyenne;
                }

                if(in_array($userData->gender, ['Male', 'male', 'Homme', 'homme', 'M'])){
                    if($tmp_moyenne >= 10){
                        $nbre_boys_passed++;
                        $nbre_passed++;
                    }else{
                        $nbre_boys_failed++;
                        $nbre_failed++;
                    }
                }else{
                    if($tmp_moyenne >= 10){
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
            })); // Nombre d'élèves ayant plus de 10/20 de moyenne;

            $moyenne_generale = (count($tabMoyennes)>0)
                ? round(array_sum($tabMoyennes)/count($tabMoyennes), 2)
                : null;

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

            // On classe les élèves par ordre de mérite si demandé
            if($sortUsers == "merit"){
                usort($infosBulletins->data->user, function ($a, $b) {
                    return $b->moyenneSequence1 <=> $a->moyenneSequence1;
                });
            }

//            return $infosBulletins->data->user;

            $data = [
                'effectifClasse' => $json_data->effectifClasse,
                'students' => $infosBulletins->data->user,
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
//                'num_total_note_assessment' => "total_note_assessment" . mb_substr($assessmentType->name,-1),
//                'numTotalSequenceUser' => "totalSequence". mb_substr($assessmentType->name,-1) ."User",
//                'numMoyenneSequence' => "moyenneSequence" . mb_substr($assessmentType->name,-1),
//                'num_rang_moyenneSequence' => "rang_moyenneSequence" . mb_substr($assessmentType->name,-1)
            ];

//            return $data;

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.pv.secondaire-users-list-with-monthly-assessments')->with($data);
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

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de {$classe->name} avec évaluations");
        }
        catch (\Exception $exception){
//            return $this->sendError($exception->getMessage());
            Log::critical($exception->getMessage() . " in file " . $exception->getFile() . " on line " . $exception->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }






//By Ibrah (add)
    // Test B-Olive :
    // {"idClasse": 2, "idTrimestre": 1, "idAssessmentType": 1, "idUser": 15, "forSolvables": false, "route": "moderne", "idOptionLevel": null, "lang": "en"}
    //
    // Test ABISCOM :
    // {"idClasse": 20, "idTrimestre": 7, "idAssessmentType": 17, "idUser": 1082, "forSolvables": false, "route": "abiscom", "idOptionLevel": null, "lang": "en"}
    public function genererBulletinSecondaire(BulletinSecondaireRequest $request){
        try{
            set_time_limit(300);

            $sequences = [];

            if(!is_null($request["idAssessmentType"])){
                //On verifi si l'utilisateur veut un bulletin sequentiel
                $sequences = AssessmentType::select('id', 'name')
                    ->where("id", $request["idAssessmentType"])  // Choisir les colonnes id et name
                    ->get()
                    ->toArray();
                $evaluation = AssessmentType::where("id", $request["idAssessmentType"])->first();
            }
            else if(!is_null($request["idTrimestre"])){
                //On récupère les séquences si l'utilisateur veut un bulletin trimestriel
                $sequences = $this->getSequences(null, $request["idTrimestre"]);
                $evaluation = Trimestre::where("id", $request["idTrimestre"])->first();
            }
            else{
                $sequences = $this->getSequences($request->idClasse, null);
                $evaluation['name'] = __("bulletin_primaire.annual");

                $trimestres = Trimestre::whereHas('assessmentTypes', function($query) use ($sequences) {
                    $query->whereIn('id', array_column($sequences, "id"));
                })
                    ->select('id', 'name')  // ne garder que id et name
                    ->get()
                    ->toArray();             // convertir en tableau
            }

            if(count($sequences) <= 0){
                return $this->sendError("Aucune séquence trouvée pour l'évaluation spécifiée");
            }

            if(count($this->getMatiereEvalueesParGroupe($request["idClasse"])) == 0){
                return $this->sendError("Aucun groupe de matiere trouvé pour cette classe");
            }



            $evaluationEleves = $this->getEvaluationEleve(array_column($sequences, "id"), $request["idClasse"]);


            $resultats = $this->calculeNotesTotales($evaluationEleves, $request["idClasse"], array_column($sequences, "id"));
            $evaluationEleves = $resultats["eleves"];
            $groupeMatieres = $resultats["groupeMatieres"];
            $matieres = $resultats["matieres"];
            $moyennes = $resultats["moyennes"];
            $moyennesNonEval = $resultats["moyennesNonEval"];


            $matieres = $this->pourcentageDeReussiteParMatiere($matieres, $evaluationEleves);

            $classe = Classes::where("id", $request["idClasse"])->first();

            $enseignant = User::select("users.name as nom")
                ->join("classes", "classes.idTeacher", "users.id")
                ->where("classes.deleted", 0)
                ->where("classes.id", $request["idClasse"])->first();

            $ecole = School::where("id", $classe->idSchool)->first();

            $etab = Establishment::first();

            if(count($evaluationEleves) == 0 || count(array_merge($moyennes, $moyennesNonEval))== 0 || array_sum(array_merge($moyennes, $moyennesNonEval)) == 0){
                return $this->sendError("Aucun élève évalué dans cette classe");
            }
            else{
                //On calcule la moyenne de la classe
                if(count($moyennes) > 0){
                    $moyenneClasse = array_sum($moyennes) / count($moyennes);
                }
                else{
                    $moyenneClasse = null;
                }
            }


            $zip_file = "Bulletins-secondaire-".Str::slug($classe->name).Str::slug($evaluation['name']).".zip";

            $liensBulletins = [];
            $zip = new \ZipArchive();
            $this->createDirectory('pdfs');
            $zip->open("pdfs/$zip_file", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);


            //Block de vérification des insolvables
            if(!in_array($this->getRole()->id, $this->listRoleSimple)){
                $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
                //return $insolvables;

                //Vérification directe si on veut pour un seul utilisateur
                if($request["idUser"] != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                    if(!is_null($request['forSolvables']) && $request['forSolvables']){
                        return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                    }
                }
                else if ($request["idUser"] != null && !$this->isSolvable($insolvables, $request["idUser"])){
                    return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
                }
            }
            //Fin de vérification des insolvables


            //Ranger les notes dans l'ordre decroissant
            rsort($moyennes);
            rsort($moyennesNonEval);


            //Si on veut pour un seul élève
            if(isset($request["idUser"])){

                if(isset($evaluationEleves[$request["idUser"]])){
                    $evaluationEleve = $evaluationEleves[$request["idUser"]];
                    $absences = $this->getAbsencesForStudent($evaluationEleve["id"], array_column($sequences, "id"));
                    $data = [
                        'couleurs' => (is_null($etab["code_couleur"]) || $etab["code_couleur"] == "") ? [] : explode(";", $etab["code_couleur"]),
                        'ecole' => $ecole,
                        'eleve' => $evaluationEleve,
                        'effectif' => count($moyennes),
                        'moyennes' => ($moyennes),
                        'moyNonEval' => ($moyennesNonEval),
                        'enseignantPrincipal' => $enseignant,
                        'groupeMatieres'=> $groupeMatieres,
                        'matieres'=> $matieres,
                        'evaluation'=> $evaluation,
                        'sequences'=> $sequences,
                        'moyenneClasse'=> $moyenneClasse,
                        "isSimple"=>true,
                        "route"=>$request["route"]?? null,
                        "trimestres"=>$trimestres ?? null,
                        'absences' => $absences,
                    ];

                    $liensBulletins[] = $this->genererDocument(Str::slug($evaluationEleve["nom"]), 'documents.create-documents.secondaire-trimestre', $data, $zip);
                    return $this->sendResponse(asset("pdfs/". Str::slug($evaluationEleve["nom"]) .".pdf"), "Bulletin secondaire");
                }
                else{
                    return $this->sendError("L'élève que vous avez choisi n'a pas effectué cette évaluation");
                }
            }
            //Sinon on récupère pour tous les élèves de la classe
            else{
                foreach($evaluationEleves as $evaluationEleve){

                    $evaluationEleve["rang"] = array_search($evaluationEleve["moyenne"], $moyennes) + 1;
                    $absences = $this->getAbsencesForStudent($evaluationEleve["id"], array_column($sequences, "id"));
                    $data = [
                        'couleurs' => explode(";",$etab["code_couleur"]),
                        'ecole' => $ecole,
                        'eleve' => $evaluationEleve,
                        'effectif' => count($moyennes),
                        'moyennes' => ($moyennes),
                        'moyNonEval' => ($moyennesNonEval),
                        'enseignantPrincipal' => $enseignant,
                        'groupeMatieres'=> $groupeMatieres,
                        'matieres'=> $matieres,
                        'evaluation'=> $evaluation,
                        'sequences'=> $sequences,
                        'moyenneClasse'=> $moyenneClasse,
                        "isSimple"=>true,
                        "route"=>$request["route"]?? null,
                        "trimestres"=>$trimestres ?? null,
                        'absences' => $absences,
                    ];

                    if(in_array($this->getRole()->id, $this->listRoleSimple)){
                        //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                        if($this->isSolvable($insolvables, $evaluationEleve["id"]) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))) {
                            //return $evaluationEleves;
                            $liensBulletins[] = $this->genererDocument(Str::slug($evaluationEleve["nom"]), 'documents.create-documents.secondaire-trimestre', $data, $zip);
                        }
                    }
                    else{
                        $liensBulletins[] = $this->genererDocument(Str::slug($evaluationEleve["nom"]), 'documents.create-documents.secondaire-trimestre', $data, $zip);
                    }
                }
            }



            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletins secondaires");
        }
        catch(Exception $th){
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }



    public function genererPvSecondaire(BulletinSecondaireRequest $request)
    {
        try {
            set_time_limit(300);

            $classe = Classes::findOrFail($request->idClasse);

            // Gestion de la langue
            $section = Section::find($classe->idSection);
            $langue  = $section->lang ?? $request->lang ?? 'fr';
            App::setLocale(strtolower($langue));

            // ------------------------------------------------------------------
            // 1. Détection du type de bulletin + récupération des séquences
            // ------------------------------------------------------------------
            $typeBulletin = 'annuel';
            $sequences    = [];
            $trimestres   = [];
            $semestres    = []; // Semestres pour l'annuel des écoles fonctionnant par semestre
            $semestreObj  = null;
            $evaluation   = (object)['name' => __('bulletin_primaire.annual')];

            if ($request->filled('idAssessmentType')) {
                // Bulletin séquentiel
                $sequences = AssessmentType::select('id', 'name', 'pourcentage')
                    ->where('id', $request->idAssessmentType)
                    ->get()
                    ->toArray();

                $evaluation   = AssessmentType::find($request->idAssessmentType);
                $typeBulletin = 'sequence';

            } elseif ($request->filled('idTrimestre')) {
                // Bulletin trimestriel
                $sequences = $this->getSequences($request->idClasse, $request->idTrimestre);

                $trimestre    = Trimestre::find($request->idTrimestre);
                $evaluation   = $trimestre;
                $trimestres   = [$trimestre->toArray()];
                $typeBulletin = 'trimestre';

            } elseif ($request->filled('idSemestre')) {
                // Bulletin semestriel
                $semestreObj = Semestre::find($request->idSemestre);
                if (!$semestreObj) {
                    return $this->sendError('Semestre introuvable.');
                }

                $trimestres = Trimestre::where('idSemestre', $request->idSemestre)
                    ->select('id', 'name', 'numbering', 'pourcentage')
                    ->get()
                    ->toArray();

                $sequences = AssessmentType::whereIn('idTrimestre', collect($trimestres)->pluck('id')->toArray())
                    ->select('id', 'name', 'pourcentage', 'idTrimestre')
                    ->get()
                    ->toArray();

                $evaluation   = (object)[
                    'name' => $semestreObj->name ?? 'Semestre ' . $semestreObj->numbering,
                ];
                $typeBulletin = 'semestre';

            } else {
                // Bulletin annuel
                $sequences = $this->getSequences($request->idClasse, null);

                $trimestres = Trimestre::select('id', 'name', 'numbering', 'idSemestre')
                    ->whereIn('id', AssessmentType::whereIn('id', collect($sequences)->pluck('id')->toArray())
                        ->distinct()
                        ->pluck('idTrimestre'))
                    ->where('takenIntoAccount', 0)
                    ->distinct()
                    ->orderBy('numbering')
                    ->get()
                    ->toArray();

                // Détection des écoles fonctionnant par semestre : on regroupe l'annuel
                // par semestre (mêmes règles de calcul que le bulletin annuel).
                $idSemestresClasse = collect($trimestres)
                    ->pluck('idSemestre')
                    ->filter()
                    ->unique()
                    ->values();

                if ($idSemestresClasse->isNotEmpty()) {
                    $semestres = Semestre::whereIn('id', $idSemestresClasse)
                        ->orderBy('id')
                        ->get()
                        ->map(function ($sem) use ($trimestres) {
                            return [
                                'id'           => $sem->id,
                                'name'         => $sem->name,
                                'trimestreIds' => collect($trimestres)
                                    ->where('idSemestre', $sem->id)
                                    ->pluck('id')
                                    ->toArray(),
                            ];
                        })
                        ->toArray();
                }

                $typeBulletin = 'annuel';
            }

            if (empty($sequences)) {
                return $this->sendError(__('bulletin.not_found_assessments'));
            }

            // ------------------------------------------------------------------
            // 2. Récupération et calcul des notes
            // ------------------------------------------------------------------
            $sequenceIds = collect($sequences)->pluck('id')->toArray();
            $evaluationEleves = $this->getEvaluationEleve($sequenceIds, $request->idClasse);

            $resultats = $this->calculeNotesTotales(
                $evaluationEleves,
                $request->idClasse,
                $sequenceIds,
                $typeBulletin,
                $trimestres,
                $sequences,
                $semestres
            );

            $evaluationEleves = $resultats['eleves'];
            $groupeMatieres   = $resultats['groupeMatieres'];
            $matieres         = $resultats['matieres'];
            $moyennes         = $resultats['moyennes'];
            $moyennesNonEval  = $resultats['moyennesNonEval'];

            $matieres = $this->pourcentageDeReussiteParMatiere($matieres, collect($evaluationEleves));

            // ------------------------------------------------------------------
            // 3. Infos complémentaires
            // ------------------------------------------------------------------
            $enseignant = User::select("users.name as nom")
                ->join("classes", "classes.idTeacher", "=", "users.id")
                ->where("classes.id", $request->idClasse)
                ->first();

            $ecole = School::where("id", $classe->idSchool)->first();
            $etab  = Establishment::first();

            $moyenneClasse = count($moyennes) > 0 ? array_sum($moyennes) / count($moyennes) : null;

            // ------------------------------------------------------------------
            // 4. Préparation données pour PV
            // ------------------------------------------------------------------
            rsort($moyennes);
            rsort($moyennesNonEval);

            // === TRI DES ÉLÈVES ===
            $elevesCollection = collect($evaluationEleves);

            // Si on veut le classement par mérite
            if ($request->input('sortUsers') === 'merit') {
                $elevesCollection = $elevesCollection->sortByDesc(function ($eleve) {
                    return $eleve['moyenne'] ?? -1; // -1 pour mettre les non-évalués en bas
                });
            } else {
                // Tri alphabétique (comportement actuel / par défaut)
                $elevesCollection = $elevesCollection->sortBy('nom');
            }
            $evaluationEleves = $elevesCollection->values()->toArray();

            $data = [
                'ecole' => $ecole,
                'classe' => $classe,
                'effectif_classe' => $this->getEffectifClasse($request->idClasse),
                'matieres' => $matieres,
                'evaluation' => $evaluationEleves,
                'detail_evaluation' => $evaluation,
                'groupeMatieres' => $groupeMatieres,
                'legend_of_grade' => $this->getAppreciation($moyennes),
                'moyennes' => $moyennes,
                'moyenneGenerale' => $moyenneClasse,
                'isSimple' => true,
                'code_couleurs' => $this->getCodeCouleur(),
                'route' => $request->route,
                'typeBulletin' => $typeBulletin,
                'trimestres' => $trimestres,
                'sequences' => $sequences,
                'academic_year' => AcademicYear::getCurrent()->label ?? '-',
            ];

            $evalName = isset($evaluation->name) ? $evaluation->name : (isset($evaluation->nom) ? $evaluation->nom : '');
            $filename = "pv-" . Str::slug($classe->name) . ($evalName ? "-" . Str::slug($evalName) : "");

            return $this->genererDocuments($data, 'documents.pv.pv-secondaire', $filename);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in " . $th->getFile() . " line " . $th->getLine());
            $msg = ($th->getMessage() === "Division by zero") ? "Division by zero" : __('app.error_occured');
            return $this->sendError($msg, [], 404);
        }
    }


    public function genererBulletinSecondaireSmart(BulletinSecondaireRequest $request)
    {
        try {
            set_time_limit(300);

            $classe = Classes::findOrFail($request->idClasse);

            $idUser = $request->idUser ?? null;

            // Gestion de la langue
            $optimalScale = null;
            $section = Section::find($classe->idSection);
            $langue  = $section->lang ?? $request->lang ?? 'fr';
            App::setLocale(strtolower($langue));

            // ------------------------------------------------------------------
            // 1. Détection du type de bulletin + récupération des séquences
            // ------------------------------------------------------------------
            $typeBulletin = 'annuel';
            $sequences    = [];
            $trimestres   = [];
            $semestres    = []; // Semestres pour l'annuel des écoles fonctionnant par semestre
            $semestreObj  = null;
            $evaluation   = (object)['name' => __('bulletin_primaire.annual')];

            if ($request->filled('idAssessmentType')) {
                // Bulletin séquentiel
                $sequences = AssessmentType::select('id', 'name', 'pourcentage')
                    ->where('id', $request->idAssessmentType)
                    ->get()
                    ->toArray();

                $evaluation   = AssessmentType::find($request->idAssessmentType);
                $typeBulletin = 'sequence';

            } elseif ($request->filled('idTrimestre')) {
                // Bulletin trimestriel
                $sequences = $this->getSequences($request->idClasse, $request->idTrimestre);

                $trimestre    = Trimestre::find($request->idTrimestre);
                $evaluation   = $trimestre;
                $trimestres   = [$trimestre->toArray()];
                $typeBulletin = 'trimestre';

            } elseif ($request->filled('idSemestre')) {
                // Bulletin semestriel (NOUVEAU)
                $semestreObj = Semestre::find($request->idSemestre);
                if (!$semestreObj) {
                    return $this->sendError('Semestre introuvable.');
                }

                // Tous les trimestres du semestre (sans pourcentage car la colonne n'existe pas)
                $trimestres = Trimestre::where('idSemestre', $request->idSemestre)
                    ->select('id', 'name', 'numbering')
                    ->get()
                    ->toArray();

                // Toutes les séquences de ces trimestres → CORRIGÉ ICI
                $sequences = AssessmentType::whereIn('idTrimestre', collect($trimestres)->pluck('id')->toArray())
                    ->select('id', 'name', 'pourcentage', 'idTrimestre')
                    ->get()
                    ->toArray();

                $evaluation   = (object)[
                    'name' => $semestreObj->name ?? 'Semestre ' . $semestreObj->numbering,
                ];
                $typeBulletin = 'semestre';

            } else {
                // Bulletin annuel
                $sequences = $this->getSequences($request->idClasse, null);

                // Récupération des trimestres pour l'annuel → CORRIGÉ ICI
                $trimestres = Trimestre::select('id', 'name', 'numbering', 'idSemestre')
                    ->whereIn('id', AssessmentType::whereIn('id', collect($sequences)->pluck('id')->toArray())
                        ->distinct()
                        ->pluck('idTrimestre'))
                    ->where('takenIntoAccount', 0)
                    ->distinct()
                    ->orderBy('numbering')
                    ->get()
                    ->toArray();

                // Détection des écoles fonctionnant par semestre : on regroupe l'annuel
                // par semestre dès lors que les trimestres sont rattachés à un semestre.
                $idSemestresClasse = collect($trimestres)
                    ->pluck('idSemestre')
                    ->filter()      // retire les null
                    ->unique()
                    ->values();

                if ($idSemestresClasse->isNotEmpty()) {
                    $semestres = Semestre::whereIn('id', $idSemestresClasse)
                        ->orderBy('id')
                        ->get()
                        ->map(function ($sem) use ($trimestres) {
                            return [
                                'id'           => $sem->id,
                                'name'         => $sem->name,
                                // Trimestres (pris en compte) appartenant à ce semestre
                                'trimestreIds' => collect($trimestres)
                                    ->where('idSemestre', $sem->id)
                                    ->pluck('id')
                                    ->toArray(),
                            ];
                        })
                        ->toArray();
                }

                $typeBulletin = 'annuel';
            }

            if (empty($sequences)) {
                return $this->sendError(__('bulletin.not_found_sequences'));
            }

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
                $incompleteSequences = AssessmentType::whereIn('id', collect($sequences)->pluck('id')->toArray())
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

            // ------------------------------------------------------------------
            // 2. Récupération et calcul des notes
            // ------------------------------------------------------------------
            // CORRIGÉ ICI : pluck sur collection
            $sequenceIds = collect($sequences)->pluck('id')->toArray();

            $evaluationEleves = $this->getEvaluationEleve($sequenceIds, $request->idClasse);

            $resultats = $this->calculeNotesTotales(
                $evaluationEleves,
                $request->idClasse,
                $sequenceIds,
                $typeBulletin,
                $trimestres ?? [],
                $sequences,
                $semestres ?? []
            );

            $evaluationEleves = $resultats['eleves'];
            $groupeMatieres   = $resultats['groupeMatieres'];
            $matieres         = $resultats['matieres'];
            $moyennes         = $resultats['moyennes'];
            $moyennesNonEval  = $resultats['moyennesNonEval'];

            $matieres = $this->pourcentageDeReussiteParMatiere($matieres, collect($evaluationEleves));

//            return $matieres;

            // ------------------------------------------------------------------
            // 3. Infos complémentaires
            // ------------------------------------------------------------------
            $enseignant = User::select("users.name as nom")
                ->join("classes", "classes.idTeacher", "=", "users.id")
                ->where("classes.id", $request->idClasse)
                ->first();

            $ecole = School::where("id", $classe->idSchool)->first();
            $etab  = Establishment::first();

            $moyenneClasse = count($moyennes) > 0 ? array_sum($moyennes) / count($moyennes) : null;

            // ------------------------------------------------------------------
            // 4. Préparation ZIP + génération PDF
            // ------------------------------------------------------------------
            $baseZipName = "Bulletins-secondaire-" . Str::slug($classe->name) . "-" . Str::slug($evaluation->name);
            $counter = 1;
            while (file_exists(public_path("pdfs/{$baseZipName}-{$counter}.zip"))) {
                $counter++;
            }
            $zip_file = "{$baseZipName}-{$counter}.zip";
            $zip = new \ZipArchive();
            $this->createDirectory('pdfs');
            $zip->open(public_path("pdfs/$zip_file"), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            rsort($moyennes);
            rsort($moyennesNonEval);

            $liensBulletins = [];

            // Bloc insolvables (tu peux le remettre tel quel plus tard)
            // ...

            if ($request->filled('idUser')) {
                // Un seul élève
                if (!isset($evaluationEleves[$request->idUser])) {
                    return $this->sendError(__('bulletin.not_found_student'));
                }

                $eleve = $evaluationEleves[$request->idUser];
                $decisionAnnuelle = User::find($request->idUser)->getDecisionForOptionLevel($request->idOptionLevel ?? null);

                // Récupérer les absences pour l'élève
                $absences = $this->getAbsencesForStudent($request->idUser, $sequenceIds);

//                return $eleve;

                $data = $this->buildBulletinData([
                    'eleve'            => $eleve,
                    'moyennes'         => $moyennes,
                    'moyNonEval'       => $moyennesNonEval,
                    'evaluation'       => $evaluation,
                    'trimestres'       => $trimestres,
                    'sequences'        => $sequences,
                    'typeBulletin'     => $typeBulletin,
                    'semestre'         => $semestreObj,
                    'semestres'        => $semestres,
                    'decisionAnnuelle' => $decisionAnnuelle,
                    'absences'         => $absences,
                ], $etab, $ecole, $enseignant, $groupeMatieres, $matieres, $moyenneClasse);

                if (!$optimalScale){
                    $optimalScale = $this->calculateOptimalScaleSecondaire('documents.create-documents.secondaire-trimestre', $data);
                }
                $nomFichier = Str::slug($eleve['nom']) . '.' . Str::slug($evaluation->name);
                $individualCounter = 1;
                $baseNomFichier = $nomFichier;
                while (file_exists(public_path("pdfs/{$nomFichier}.pdf"))) {
                    $nomFichier = $baseNomFichier . "-" . $individualCounter;
                    $individualCounter++;
                }
                $this->genererDocumentSecondaireAutoScale($nomFichier, 'documents.create-documents.secondaire-trimestre', $data, $zip, $optimalScale);
                $zip->close();

                return $this->sendResponse(asset("pdfs/" . $nomFichier . ".pdf"), "Bulletin secondaire");

            } else {
                // Tous les élèves
                $studentCounter = 1;
                foreach ($evaluationEleves as $idEleve => $eleve) {
                    // Pour les teachers, filtrer les élèves insolvables (leur bulletin n'apparaît pas)
                    if ($this->getRole()->id == 5 && $insolvablesTeachers && !$this->isSolvable($insolvablesTeachers, $idEleve)) {
                        continue;
                    }

                    $eleve['rang'] = array_search($eleve['moyenne'] ?? -1, $moyennes) + 1;
                    $decisionAnnuelle = User::find($idEleve)->getDecisionForOptionLevel($request->idOptionLevel ?? null);

                    // Récupérer les absences pour l'élève
                    $absences = $this->getAbsencesForStudent($idEleve, $sequenceIds);

                    $data = $this->buildBulletinData([
                        'eleve'            => $eleve,
                        'moyennes'         => $moyennes,
                        'moyNonEval'       => $moyennesNonEval,
                        'evaluation'       => $evaluation,
                        'trimestres'       => $trimestres,
                        'sequences'        => $sequences,
                        'typeBulletin'     => $typeBulletin,
                        'semestre'         => $semestreObj,
                        'semestres'        => $semestres,
                        'decisionAnnuelle' => $decisionAnnuelle,
                        'absences'         => $absences,
                    ], $etab, $ecole, $enseignant, $groupeMatieres, $matieres, $moyenneClasse);

                    if (!$optimalScale){
                        $optimalScale = $this->calculateOptimalScaleSecondaire('documents.create-documents.secondaire-trimestre', $data);
                    }

                    $nomFichier = $studentCounter . '-' . Str::slug($eleve['nom']) . '.' . Str::slug($evaluation->name);
                    $studentCounter++;
                    $liensBulletins[] = $this->genererDocumentSecondaireAutoScale($nomFichier, 'documents.create-documents.secondaire-trimestre', $data, $zip, $optimalScale);
                }

                $zip->close();

                register_shutdown_function(function () use ($liensBulletins) {
                    $this->deletePDFTempFiles($liensBulletins);
                });

                return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletins secondaires");
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in " . $th->getFile() . " line " . $th->getLine());
            $msg = $th->getMessage() === "Division by zero" ? "Division by zero" : __('app.error_occured');
            return $this->sendError($msg, [], 404);
        }
    }

// Méthode helper pour factoriser la construction du tableau $data
    private function buildBulletinData($specific, $etab, $ecole, $enseignant, $groupeMatieres, $matieres, $moyenneClasse)
    {
        return [
            'couleurs'          => empty($etab->code_couleur) ? [] : explode(";", $etab->code_couleur),
            'ecole'             => $ecole,
            'eleve'             => $specific['eleve'],
            'effectif'          => count($specific['moyennes']),
            'moyennes'          => $specific['moyennes'],
            'moyNonEval'        => $specific['moyNonEval'],
            'enseignantPrincipal' => $enseignant,
            'groupeMatieres'    => $groupeMatieres,
            'matieres'          => $matieres,
            'evaluation'        => $specific['evaluation'],
            'trimestres'        => $specific['trimestres'],
            'sequences'         => $specific['sequences'],
            'moyenneClasse'     => $moyenneClasse,
            'typeBulletin'      => $specific['typeBulletin'],
            'semestre'          => $specific['semestre'] ?? null,
            'semestres'         => $specific['semestres'] ?? [],
            'isSimple'          => true,
            'route'             => request()->input('route'),
            'decisionAnnuelle'  => $specific['decisionAnnuelle'],
            'academic_year'     => AcademicYear::getCurrent()->label ?? '-',
            'absences'          => $specific['absences'] ?? ['justified' => 0, 'unjustified' => 0, 'total' => 0],
        ];
    }

    public function afficherNotesSecondaire(AfficherNotesPrimaireRequest $request)
    {
        try{
            $idClasse = User::find($request["idUser"])["idClasse"] ?? null;

            $idsOptionLevel = [$request["idOptionLevel"] ?? null];

            //Decommentez si vous souhaitez que le endpoint calcule l'option de niveau (si non envoyé dans le payload)
             $idsOptionLevel = Classes::join("level_option_level", "level_option_level.level_id", "=", "classes.idLevel")
             ->where("classes.id", $idClasse)
             ->distinct()
             ->pluck("level_option_level.option_level_id")
             ->toArray();

             $idsOptionLevel = count($idsOptionLevel) > 0
             ? $idsOptionLevel
             : [null];

            if (!$idClasse) {
                throw new Exception("Classe ou niveau d'option introuvable.");
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

//            return $idTrimestres;

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

                    $evaluationEleves = $this->getEvaluationEleve(array_column($sequences, "id"), $idClasse, false, $request['idUser']);

                    $resultats = $this->calculeNotesTotales($evaluationEleves, $idClasse, array_column($sequences, "id"));

                    $evaluationEleve = $resultats["eleves"][$request['idUser']] ?? null;

                    if($evaluationEleves){
                        $totalMoyenne = 0;
                        $nombreSequencesValides = 0;

                        foreach (array_column($sequences, "id") as $idSequence) {
                            $sequenceData = $resultats['eleves'][$request["idUser"]] ?? [];
                            $sequenceKey = "noteCoefSeq$idSequence";
                            $noteMaxKey = "coefSeq$idSequence";
                            $isValidKey = "isEvalueSeq$idSequence";
//                            return $evaluationEleve;

                            $moyenneSequence = ($evaluationEleve[$sequenceKey] ?? null) !== null && ($evaluationEleve[$noteMaxKey] ?? null) != null
                                ? round((($evaluationEleve[$sequenceKey] / $evaluationEleve[$noteMaxKey]) * 20), 2)
                                : null;

                            $valide70 = $sequenceData[$isValidKey] ?? false;

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

        } catch (\Throwable $th) {
            $log_msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($log_msg);
            return $this->sendError($th->getMessage(), [], 404, $log_msg);
//            return $this->sendError(__('app.error_occured'), [], 404, $log_msg);
        }
    }

    public function afficherNotesSecondaire2($request)
    {
        try{
            $idClasse = User::find($request["idUser"])["idClasse"] ?? null;

            $idsOptionLevel = [$request["idOptionLevel"] ?? null];

            //Decommentez si vous souhaitez que le endpoint calcule l'option de niveau (si non envoyé dans le payload)
            $idsOptionLevel = Classes::join("level_option_level", "level_option_level.level_id", "=", "classes.idLevel")
                ->where("classes.id", $idClasse)
                ->distinct()
                ->pluck("level_option_level.option_level_id")
                ->toArray();

            $idsOptionLevel = count($idsOptionLevel) > 0
                ? $idsOptionLevel
                : [null];


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

//            return $idTrimestres;

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

                    $evaluationEleves = $this->getEvaluationEleve(array_column($sequences, "id"), $idClasse, false, $request['idUser']);

                    $resultats = $this->calculeNotesTotales($evaluationEleves, $idClasse, array_column($sequences, "id"));

                    $evaluationEleve = $resultats["eleves"][$request['idUser']] ?? null;

                    if($evaluationEleves){
                        $totalMoyenne = 0;
                        $nombreSequencesValides = 0;

                        foreach (array_column($sequences, "id") as $idSequence) {
                            $sequenceData = $resultats['eleves'][$request["idUser"]] ?? [];
                            $sequenceKey = "noteCoefSeq$idSequence";
                            $noteMaxKey = "coefSeq$idSequence";
                            $isValidKey = "isEvalueSeq$idSequence";

                            $moyenneSequence = ($evaluationEleve[$sequenceKey] ?? null) !== null && ($evaluationEleve[$noteMaxKey] ?? null) != null
                                ? round((($evaluationEleve[$sequenceKey] / $evaluationEleve[$noteMaxKey]) * 20), 2)
                                : null;

                            $valide70 = $sequenceData[$isValidKey] ?? false;

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

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

}
