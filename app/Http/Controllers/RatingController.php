<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\GenererBulletinSecondaireFrancophoneRequest;
use App\Http\Requests\Admin\RatingsDeleteInBulkRequest;
use App\Http\Requests\Admin\StudentMoyennePerAssessmentRequest;
use App\Jobs\RatingNotificationJob;
use App\Models\Key;
use App\Models\Notification;
use App\Models\School;
use App\Services\CalculeMoyenneParSequenceService;
use App\Traits\CalculeMoyenneParSequenceTrait;
use App\Traits\CreateDirectoryTrait;
use App\Traits\DeletePDFTmpFilesTrait;
use App\Traits\ManageDirectoryTrait;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Http\Requests\Staffs\RatingRequest;
use App\Http\Requests\Staffs\RatingGetAllRequest;
use App\Http\Resources\Staffs\RatingResource;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Absence;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Matter;
use App\Models\MatterGroup;
use App\Models\Sanction;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * @group Rating
 */
class RatingController extends BaseController
{
    use DeletePDFTmpFilesTrait, ManageDirectoryTrait;

    /**
     * Afficher la liste des notes
     *
     * @param RatingGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(RatingGetAllRequest $request)
    {
        /**
         * BD: dev
         * {"idSchool": 2,"idClasse": 10}
         */
        try {
            $rating  = $request->validated();

            $idClasse = $request['idClasse'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idMatter = $request['idMatter'] ?? null;
            $idStudent = $request['idStudent'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idAssessmentType = $request['idAssessmentType'] ?? null;
            $idTypeEvaluation = $request['idTypeEvaluation'] ?? null;
            $idAssessment = $request['idAssessment'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $ratings = Rating::select('ratings.id as id','ratings.value as value','ratings.observation as observation','ratings.idSchool as idSchool','ratings.idSection as idSection',
                'ratings.idClasse as idClasse','ratings.idTeacher as idTeacher','ratings.idMatter as idMatter','ratings.idCoeficient as idCoeficient','ratings.idStudent as idStudent','ratings.idAssessment as idAssessment',
                'ratings.idAssessmentType as idAssessmentType','ratings.idTypeEvaluation as idTypeEvaluation','ratings.notemax as notemax',
                'assessments.oral as oral','assessments.orale as orale','assessments.ecrit as ecrit','assessments.written as written','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','assessments.pratique as pratique')
                ->join('assessments','ratings.idAssessment','=','assessments.id')
                ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                ->where('assessments.deleted', 0)
                ->where('assessment_type.deleted', 0)
                ->where('ratings.idSchool', $request['idSchool']);

            if(!empty($idSection)){
                $ratings = $ratings->where('ratings.idSection', $request['idSection']);
            }if(!empty($idMatter)){
                $ratings = $ratings->where('ratings.idMatter',$request['idMatter']);
            }if(!empty($idClasse)){
                $ratings = $ratings->where('ratings.idClasse',$request['idClasse']);
            }if(!empty($idStudent)){
                $ratings = $ratings->where('ratings.idStudent',$request['idStudent']);
            }if(!empty($idTeacher)){
                $ratings = $ratings->where('assessments.idTeacher',$request['idTeacher']);
            }if(!empty($idAssessmentType)){
                $ratings = $ratings->where('ratings.idAssessmentType',$request['idAssessmentType']);
            }if(!empty($idAssessment)){
                $ratings = $ratings->where('ratings.idAssessment',$request['idAssessment']);
            }if(!empty($idTypeEvaluation)){
                $ratings = $ratings->where('ratings.idTypeEvaluation',$request['idTypeEvaluation']);
            }
            if(!empty($idOptionLevel)){
                $ratings = $ratings
                    ->join('matter','matter.id','=','ratings.idMatter')
                    ->where('matter.idOptionLevel',$idOptionLevel);
            }

            $filter_value = $request->filter_value;
            if(!is_null($filter_value)){
                $ratings->where(function($query) use ($filter_value) {
                    $query->whereHas('user', function($q) use ($filter_value) {
                        $q->where('name', 'like', "%$filter_value%");
                    })
                        ->orwhereHas('teacher', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('matter', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('typeEvaluation', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('assessmentType', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return RatingResource::collection(
                $ratings->orderBy("ratings.id", "desc")->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter une note
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function store(Request $request)
    {
     try {
        return DB::transaction(function () use ($request) {

            $responses = [];

            if (!isset($request['ratings']) || !is_array($request['ratings'])) {
                return $this->sendError(__('bulletin.invalid_payload'));
            }

            foreach ($request['ratings'] as $ratingData) {

                if (!isset($ratingData['idAssessment']) ||
                    !isset($ratingData['idStudent']) ||
                    !isset($ratingData['idMatter']) ||
                    !isset($ratingData['idClasse'])) {
                    return $this->sendError(__('bulletin.missing_fields'));
                }

                $assessment = Assessment::find($ratingData['idAssessment']);
                if (!$assessment) {
                    return $this->sendError(__('bulletin.assessment_not_found'));
                }

                $noteMax = $assessment->notemax;

                if (is_null($ratingData['value'])) {
                    continue;
                }

                if ($ratingData['value'] > $noteMax) {
                    return $this->sendError(
                        __("bulletin.exceed_note_max", ['noteMax' => $noteMax])
                    );
                }

                $student = User::find($ratingData['idStudent']);
                if (!$student) {
                    return $this->sendError(__('bulletin.student_not_found'));
                }

                $idTypeEvaluation = $ratingData['idTypeEvaluation'] ?? null;

                // ✅ Construction dynamique de la requête selon primaire/secondaire
                $query = Rating::where('idStudent',        $ratingData['idStudent'])
                               ->where('idMatter',         $ratingData['idMatter'])
                               ->where('idAssessmentType', $ratingData['idAssessmentType'])
                               ->where('idAssessment',     $ratingData['idAssessment']);

                // ✅ Secondaire : idTypeEvaluation est NULL → on ne filtre pas dessus
                // ✅ Primaire   : idTypeEvaluation a une valeur → on filtre dessus
                if (!is_null($idTypeEvaluation)) {
                    $query->where('idTypeEvaluation', $idTypeEvaluation);
                } else {
                    $query->whereNull('idTypeEvaluation');
                }

                $existingRating = $query->first();

                $dataToSave = [
                    'value'         => $ratingData['value'],
                    'observation'   => $ratingData['observation'] ?? null,
                    'notemax'       => $noteMax,
                    'idCoeficient'  => $ratingData['idCoeficient'] ?? null,
                    'idClasse'      => $ratingData['idClasse'],
                    'idTeacher'     => $ratingData['idTeacher'] ?? null,
                    'idSchool'      => $student->idSchool,
                    'idSection'     => $student->idSection,
                    'created_by'    => auth()->id(),
                ];

                if ($existingRating) {
                    // ✅ Note existante → on écrase
                    $existingRating->update($dataToSave);
                    $rating = $existingRating->fresh();
                } else {
                    // ✅ Nouvelle note → on crée
                    $rating = Rating::create(array_merge($dataToSave, [
                        'idStudent'         => $ratingData['idStudent'],
                        'idMatter'          => $ratingData['idMatter'],
                        'idAssessmentType'  => $ratingData['idAssessmentType'],
                        'idAssessment'      => $ratingData['idAssessment'],
                        'idTypeEvaluation'  => $idTypeEvaluation,
                    ]));
                }

                RatingNotificationJob::dispatch($rating)->delay(now()->addMinutes(1));

                $responses[] = $rating;
            }

            return $this->sendResponse($responses, __("bulletin.notes_add_success"));
        });

    } catch (\Throwable $th) {
        Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
    }
}
    /**
     * Afficher les détails d'un rating(note)
     *
     * @param Rating $rating
     * @param $id
     * @return RatingResource|\Illuminate\Http\Response
     */
    public function show(Rating $rating,$id)
    {
        try {
            $rating = Rating::find($id);
            return new RatingResource($rating);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un rating (note)
     *
     * @param Request $request
     * @param Rating $rating
     * @param $id
     * @return RatingResource|\Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating,$id)
    {
        try {
            $assessment = Assessment::find($request->idAssessment);

            $rating = Rating::findOrFail($id);
            $rating->value = $request['value'] ?? null;
            $rating->observation = $request['observation'] ?? $rating['observation'];
            $rating->notemax = $request['notemax'] ?? $rating['notemax'];
            $rating->idCoeficient = $request['idCoeficient'] ?? $rating['idCoeficient'];
            $rating->idMatter = $request['idMatter'] ?? $rating['idMatter'];
            $rating->idStudent = $request['idStudent'] ?? $rating['idStudent'];
            $rating->idClasse = $request['idClasse'] ?? $rating['idClasse'];
            $rating->idAssessment = $request['idAssessment'] ?? $rating['idAssessment'];
            $rating->idAssessmentType = $request['idAssessmentType'] ?? $rating['idAssessmentType'];
            $rating->idTypeEvaluation = $request['idTypeEvaluation'] ?? $rating['idTypeEvaluation'];
            $rating->idTeacher = $request['idTeacher'] ?? $rating['idTeacher'];
            $rating->idSchool = $assessment->idSchool ?? $rating['idSchool'];
            $rating->idSection = $assessment->idSection ?? $rating['idSection'];
            $rating->updated_by = auth()->user()->id;
            $rating->save();

            return new RatingResource($rating);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

//    public function delete(Request $request)
//    {
//        try {
//            if (!empty($request['ratingsids'])) {
//                $ratingsids = $request['ratingsids'];
//                Rating::whereIn('id', $ratingsids)->delete();
//
//                return response(null, 200);
//            } else {
//                return  $this->sendError('The "ratingsids" key is missing from the request.');
//            }
//        } catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//        }
//    }

    /**
     * Effectuer une suppression multiple
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteInBulk(RatingsDeleteInBulkRequest $request)
    {
        try {
//            Rating::whereIn('id', $request['ratingsids'])->delete();
            Rating::whereIn('id', $request['ratingsids'])->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id
            ]);

            return response(null, 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un élément de rating
     *
     * @param Rating $rating
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Rating $rating,$id)
    {
        try {
            $rating = Rating::findOrFail($id);

            //TODO: Désormais on archive juste la note
//            $rating->delete();
            $rating->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id
            ]);

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletin(Request $request){


        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

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
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['totalNoteMax'] = $total_notemax_assessment;
                    $tabNote['user'][0]['totalSequence1User'] = $totalSequence1User;
                    $tabNote['user'][0]['totalSequence2User'] = $totalSequence2User;
                    $tabNote['user'][0]['totalSequence3User'] = $totalSequence3User;
                    $tabNote['user'][0]['totalSequence4User'] = $totalSequence4User;
                    $tabNote['user'][0]['totalSequence5User'] = $totalSequence5User;
                    $tabNote['user'][0]['totalSequence6User'] = $totalSequence6User;
                    $tabNote['user'][0]['totalSequence7User'] = $totalSequence7User;
                    $tabNote['user'][0]['totalSequence8User'] = $totalSequence8User;
                    $tabNote['user'][0]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                }

            }
            else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['totalNoteMax'] = $total_notemax_assessment;
                    $tabNote['user'][0]['totalSequence1User'] = $totalSequence1User;
                    $tabNote['user'][0]['totalSequence2User'] = $totalSequence2User;
                    $tabNote['user'][0]['totalSequence3User'] = $totalSequence3User;
                    $tabNote['user'][0]['totalSequence4User'] = $totalSequence4User;
                    $tabNote['user'][0]['totalSequence5User'] = $totalSequence5User;
                    $tabNote['user'][0]['totalSequence6User'] = $totalSequence6User;
                    $tabNote['user'][0]['totalSequence7User'] = $totalSequence7User;
                    $tabNote['user'][0]['totalSequence8User'] = $totalSequence8User;
                    $tabNote['user'][0]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                }


            }
            else if(!empty($request['idTrimestre'])){

            }
            else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][$i]['matterGroup'] = $matterGroup;

                    $totalSequence1User = null;
                    $totalSequence2User = null;
                    $totalSequence3User = null;
                    $totalSequence4User = null;
                    $totalSequence5User = null;
                    $totalSequence6User = null;
                    $totalSequence7User = null;
                    $totalSequence8User = null;

                    for ($j=0; $j < $matterGroup->count(); $j++) {
                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->where('matter_group.id',$matterGroup[$j]['id'])
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'] = $assessment;

                        $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->sum('assessments.notemax');

                        for ($k=0; $k < $assessment->count(); $k++) {
                            $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
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
                                //$total_matiere = $total_matiere + 1;
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

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                    $total = null;

                                    for ($n=0; $n < $assessmentType->count(); $n++) {
                                        $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                            ->join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->join('matter','matter.id','=','ratings.idMatter')
                                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                            ->where('assessment_type.id',$assessmentType[$n]['id'])
                                            ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->first();


                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                        if(!empty($ratings['value'])){
                                            $total = $total + $ratings['value'];
                                            $rating_exits = $rating_exits + 1;

                                            if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                                switch ($assessmentType[$n]['id']) {
                                                    case 1:
                                                        $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 2:
                                                        $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 3:
                                                        $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 4:
                                                        $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 5:
                                                        $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 6:
                                                        $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 7:
                                                        $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 8:
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

                    if($total_notemax_assessment != 0){
                        $tabNote['user'][$i]['totalNoteMax'] = $total_notemax_assessment;
                        $tabNote['user'][$i]['totalSequence1User'] = $totalSequence1User;
                        $tabNote['user'][$i]['totalSequence2User'] = $totalSequence2User;
                        $tabNote['user'][$i]['totalSequence3User'] = $totalSequence3User;
                        $tabNote['user'][$i]['totalSequence4User'] = $totalSequence4User;
                        $tabNote['user'][$i]['totalSequence5User'] = $totalSequence5User;
                        $tabNote['user'][$i]['totalSequence6User'] = $totalSequence6User;
                        $tabNote['user'][$i]['totalSequence7User'] = $totalSequence7User;
                        $tabNote['user'][$i]['totalSequence8User'] = $totalSequence8User;
                        $tabNote['user'][$i]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                    }
                }

                /******************************************************Debut calcul rang ********************************************/

                // Tableau des séquences
                $sequences = ['moyenneSequence1', 'moyenneSequence2', 'moyenneSequence3', 'moyenneSequence4', 'moyenneSequence5', 'moyenneSequence6', 'moyenneSequence7', 'moyenneSequence8'];

                // Tableau associatif pour stocker les rangs pour chaque séquence
                $rangsParSequence = [];

                // Boucle sur chaque séquence
                foreach ($sequences as $sequence) {
                    // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                    $moyennes = [];
                    foreach ($tabNote['user'] as $userId => $user) {
                        $moyennes[$userId] = $user[$sequence];
                    }

                    // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                    arsort($moyennes);

                    // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                    $rangs = [];
                    $rank = 1;
                    foreach ($moyennes as $userId => $moyenne) {
                        $rangs[$userId] = $rank;
                        $rank++;
                    }

                    // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                    foreach ($tabNote['user'] as $userId => &$user) {
                        $user['rang_'.$sequence] = $rangs[$userId];
                    }

                    // Stocker les rangs dans le tableau global
                    $rangsParSequence[$sequence] = $rangs;
                }

                // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément




                /******************************************************fin calcul rang ********************************************/
            }

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletinsecondaire(Request $request){


        try {
            $tabNote = array();

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
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;
                //$total_matiere = null;

                $trimestre = Trimestre::select('id','name')
                    ->where('idSchool',$request['idSchool'])
                    ->where('idSection',$request['idSection'])
                    ->where('id',$request['idTrimestre'])
                    ->get();

                $tabNote['user'][0]['trimestre'] = $trimestre;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;

                $totalCoef = null ;
                $totaltermAv = null ;

                for ($j=0; $j < $trimestre->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['trimestre'][$j]['assessment'] = $assessment;

                    for ($k=0; $k < $assessment->count(); $k++) {

                        $totalSequence1 = null;
                        $totalSequence2 = null;
                        $totalSequence3 = null;
                        $totalSequence4 = null;
                        $totalSequence5 = null;
                        $totalSequence6 = null;

                        $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                            ->join('modules','modules.idTeacher','=','users.id')
                            ->join('progressions','progressions.id','=','modules.idProgression')
                            ->where('progressions.idClasse',$request['idClasse'])
                            ->get();

                        //for ($l=0; $l < $typeEvaluation->count(); $l++) { ******************************ici *************************************************************
                        //$total_matiere = $total_matiere + 1;

                        $rating_exits = null;

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->get();

                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['assessmentType'] = $assessmentType;
                        $total = null;

                        $coefficient = Rating::select('coefficients.value as coefficient')
                            ->join('assessments','assessments.id','=','ratings.idAssessment')
                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                            ->join('matter','matter.id','=','ratings.idMatter')
                            ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                            ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                            ->first();

                        $totalCoef = $totalCoef + $coefficient['coefficient'];

                        for ($n=0; $n < $assessmentType->count(); $n++) {
                            $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                ->join('assessments','assessments.id','=','ratings.idAssessment')
                                ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                ->join('matter','matter.id','=','ratings.idMatter')
                                ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                ->where('assessment_type.id',$assessmentType[$n]['id'])
                                ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                ->first();


                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['assessmentType'][$n]['ratings'] = $ratings;


                            for($p=0; $p < $teachername->count(); $p++) {
                                if($teachername[$p]['moduleName'] = $assessment[$k]['nameMatter']){
                                    $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['tearcherName'] = $teachername[$p]['teacherName'];
                                }
                            }

                            if(!empty($ratings['value'])){
                                $total = $total + $ratings['value'];
                                $rating_exits = $rating_exits + 1;

                                if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                    switch ($assessmentType[$n]['id']) {
                                        case 1:
                                            $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                            break;
                                        case 2:
                                            $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                            break;
                                        case 3:
                                            $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                            break;
                                        case 4:
                                            $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                            break;
                                        case 5:
                                            $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                            break;
                                        case 6:
                                            $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }

                            }




                        }

                        if(!empty($rating_exits) && $rating_exits != 0){
                            //$tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['total_sequence_trimestre'] = $total;
                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['termAv'] = $total/$assessmentType->count();
                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                            $totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                        }else{
                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['total_trimestre'] = null;
                        }




                        //} *********************************************************** ici *********************************************************************

                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['coefficient'] = $coefficient['coefficient'];

                        //methode avec deux sequences par trimestre
                        switch ($request['idTrimestre']) {
                            case '1':
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence1'] = $totalSequence1;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence2'] = $totalSequence2;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre'] = $totalSequence1 + $totalSequence2;
                                break;
                            case '2':
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence1'] = $totalSequence3;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence2'] = $totalSequence4;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre'] = $totalSequence3 + $totalSequence4;
                                break;
                            case '3':
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence1'] = $totalSequence5;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence2'] = $totalSequence6;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre'] = $totalSequence5 + $totalSequence6;
                                break;
                        }

                        //methode affichant toute les sequences même les null
                        /*
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence1'] = $totalSequence1;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence2'] = $totalSequence2;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence3'] = $totalSequence3;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence4'] = $totalSequence4;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence5'] = $totalSequence5;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence6'] = $totalSequence6;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence7'] = $totalSequence7;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence8'] = $totalSequence8;
                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;
                        */

                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;

                    }

                }

                if($totalCoef != 0){
                    $tabNote['user'][0]['totalCoef'] = $totalCoef;
                    $tabNote['user'][0]['total'] = $totaltermAv;

                    //bonne methode moyenne
                    switch ($request['idTrimestre']) {
                        case '1':
                            $tabNote['user'][0]['moyenneStudent'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                            break;
                        case '2':
                            $tabNote['user'][0]['moyenneStudent'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                            break;
                        case '3':
                            $tabNote['user'][0]['moyenneStudent'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                            break;
                    }

                    //methode moyenne pour afficher tout
                    /*
                    $tabNote['user'][0]['moyenneSequence1'] = ($totalSequence1User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence2'] = ($totalSequence2User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence3'] = ($totalSequence3User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence4'] = ($totalSequence4User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence5'] = ($totalSequence5User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence6'] = ($totalSequence6User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence7'] = ($totalSequence7User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence8'] = ($totalSequence8User / $totalCoef);
                    */
                }

            }else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;
                //$total_matiere = null;

                $trimestre = Trimestre::select('id','name')
                    ->where('idSchool',$request['idSchool'])
                    ->where('idSection',$request['idSection'])
                    ->get();

                $tabNote['user'][0]['trimestre'] = $trimestre;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;

                $totalCoef = null ;
                $totaltermAv = null ;

                for ($j=0; $j < $trimestre->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['trimestre'][$j]['assessment'] = $assessment;

                    for ($k=0; $k < $assessment->count(); $k++) {

                        $totalSequence1 = null;
                        $totalSequence2 = null;
                        $totalSequence3 = null;
                        $totalSequence4 = null;
                        $totalSequence5 = null;
                        $totalSequence6 = null;

                        $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                            ->join('modules','modules.idTeacher','=','users.id')
                            ->join('progressions','progressions.id','=','modules.idProgression')
                            ->where('progressions.idClasse',$request['idClasse'])
                            ->get();

                        //for ($l=0; $l < $typeEvaluation->count(); $l++) { ******************************************************* ici *********************************************
                        //$total_matiere = $total_matiere + 1;

                        $rating_exits = null;

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->get();

                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['assessmentType'] = $assessmentType;
                        $total = null;

                        $coefficient = Rating::select('coefficients.value as coefficient')
                            ->join('assessments','assessments.id','=','ratings.idAssessment')
                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                            ->join('matter','matter.id','=','ratings.idMatter')
                            ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                            ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                            ->first();

                        $totalCoef = $totalCoef + $coefficient['coefficient'];

                        for ($n=0; $n < $assessmentType->count(); $n++) {
                            $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                ->join('assessments','assessments.id','=','ratings.idAssessment')
                                ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                ->join('matter','matter.id','=','ratings.idMatter')
                                ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                ->where('assessment_type.id',$assessmentType[$n]['id'])
                                ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                ->first();


                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['assessmentType'][$n]['ratings'] = $ratings;

                            for($p=0; $p < $teachername->count(); $p++) {
                                if($teachername[$p]['moduleName'] = $assessment[$k]['nameMatter']){
                                    $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['tearcherName'] = $teachername[$p]['teacherName'];
                                }
                            }

                            if(!empty($ratings['value'])){
                                $total = $total + $ratings['value'];
                                $rating_exits = $rating_exits + 1;

                                if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                    switch ($assessmentType[$n]['id']) {
                                        case 1:
                                            $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                            break;
                                        case 2:
                                            $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                            break;
                                        case 3:
                                            $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                            break;
                                        case 4:
                                            $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                            break;
                                        case 5:
                                            $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                            break;
                                        case 6:
                                            $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                }

                            }




                        }

                        if(!empty($rating_exits) && $rating_exits != 0){
                            //$tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['total_sequence_trimestre'] = $total;
                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['termAv'] = $total/$assessmentType->count();
                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                            $totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                        }else{
                            $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['total_trimestre'] = null;
                        }




                        //} ****************************************************** ici ***************************************

                        $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['coefficient'] = $coefficient['coefficient'];

                        //methode avec deux sequences par trimestre

                        switch ($trimestre[$j]['id']) {
                            case '1':
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence1'] = $totalSequence1;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence2'] = $totalSequence2;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                break;
                            case '2':
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence3'] = $totalSequence3;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence4'] = $totalSequence4;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                break;
                            case '3':
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence5'] = $totalSequence5;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalSequence6'] = $totalSequence6;
                                $tabNote['user'][0]['trimestre'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                break;
                        }

                        //methode affichant toute les sequences même les null
                        /*
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence1'] = $totalSequence1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence2'] = $totalSequence2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence3'] = $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence4'] = $totalSequence4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence5'] = $totalSequence5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence6'] = $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence7'] = $totalSequence7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalSequence8'] = $totalSequence8;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;
                        */

                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;

                    }

                }

                if($totalCoef != 0){
                    $tabNote['user'][0]['totalCoef'] = $totalCoef;
                    $tabNote['user'][0]['total'] = $totaltermAv;

                    //bonne moyenne 1

                    if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                        $tabNote['user'][0]['moyenneStudentTrimestre1'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                    }else{
                        $tabNote['user'][0]['moyenneStudentTrimestre1'] = null;
                    }

                    if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                        $tabNote['user'][0]['moyenneStudentTrimestre2'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                    }else{
                        $tabNote['user'][0]['moyenneStudentTrimestre2'] = null;
                    }

                    if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                        $tabNote['user'][0]['moyenneStudentTrimestre3'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                    }else{
                        $tabNote['user'][0]['moyenneStudentTrimestre3'] = null;
                    }

                    //bonne methode moyenne 2
                    /*
                    switch ($trimestre[$j]['id']) {
                        case '1':
                            $tabNote['user'][0]['moyenneStudentTrimestre1'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                            break;
                        case '2':
                            $tabNote['user'][0]['moyenneStudentTrimestre2'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                            break;
                        case '3':
                            $tabNote['user'][0]['moyenneStudentTrimestre3'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                            break;
                    }
                    */

                    //methode moyenne pour afficher tout
                    /*
                    $tabNote['user'][0]['moyenneSequence1'] = ($totalSequence1User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence2'] = ($totalSequence2User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence3'] = ($totalSequence3User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence4'] = ($totalSequence4User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence5'] = ($totalSequence5User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence6'] = ($totalSequence6User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence7'] = ($totalSequence7User / $totalCoef);
                    $tabNote['user'][0]['moyenneSequence8'] = ($totalSequence8User / $totalCoef);
                    */
                }

                $santion = Sanction::where('idUser',$entete[0]['id'])
                    ->count();

                $absence = Absence::where('idStudent',$entete[0]['id'])
                    ->count();

                $tabNote['user'][0]['totalAbs'] = $absence;
                $tabNote['user'][0]['totalPunishment'] = $santion;



            }else if(!empty($request['idTrimestre'])){

            }else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;
                //$total_matiere = null;

                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
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

                    $totalCoef = null ;
                    $totaltermAv = null ;

                    for ($j=0; $j < $trimestre->count(); $j++) {

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->get();

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'] = $assessmentType;

                        for ($k=0; $k < $assessmentType->count(); $k++) {

                            $totalSequence1 = null;
                            $totalSequence2 = null;
                            $totalSequence3 = null;
                            $totalSequence4 = null;
                            $totalSequence5 = null;
                            $totalSequence6 = null;
                            $totalNoteCoef = null;

                            $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                ->join('modules','modules.idTeacher','=','users.id')
                                ->join('progressions','progressions.id','=','modules.idProgression')
                                ->where('progressions.idClasse',$request['idClasse'])
                                ->get();

                            //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                            //$total_matiere = $total_matiere + 1;
                            $rating_exits = null;

                            $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                                ->join('matter','matter.id','=','assessments.idMatter')
                                ->where('assessments.idSchool',$request['idSchool'])
                                ->where('assessments.idSection',$request['idSection'])
                                ->where('assessments.idClasse',$request['idClasse'])
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['assessment'] = $assessment;
                            $total = null;

                            for ($n=0; $n < $assessment->count(); $n++) {


                                $coefficient = Rating::select('coefficients.value as coefficient')
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();

                                $totalCoef = $totalCoef + $coefficient['coefficient'];

                                $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                    ->where('assessment_type.id',$assessmentType[$k]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();


                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['assessment'][$n]['ratings'] = $ratings;


                                for($p=0; $p < $teachername->count(); $p++) {
                                    if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                    }
                                }
                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                    if($assessment[$n]['nameMatter'] = $ratings['nameMatter']){
                                        switch ($assessmentType[$k]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
                                                $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                                break;

                                            default:
                                                # code...
                                                break;
                                        }
                                    }

                                }

                                $totaltermAv = $totaltermAv + $total;


                            }

                            if(!empty($rating_exits) && $rating_exits != 0){
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                                //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total_trimestre'] = null;
                            }




                            //} *************************************************************** ici ***********************************************

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence'] = $total;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*$coefficient['coefficient'];
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['moyenne'] = $totalNoteCoef / $totalCoef;

                            //methode avec deux sequences par trimestre

                            /*
                        switch ($trimestre[$j]['id']) {
                            case '1':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                break;
                            case '2':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                break;
                            case '3':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                break;
                        }
                        */

                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            $totalSequence6User = $totalSequence6User + $totalSequence6;

                        }

                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        if($totalCoef != 0){
                            $tabNote['user'][$i]['trimestre'][$j]['totalCoef'] = $totalCoef;
                            $tabNote['user'][$i]['trimestre'][$j]['total'] = $totaltermAv;
                            //bonne moyenne 1
                            switch ($trimestre[$j]['id']) {
                                case 1:
                                    if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 2:
                                    if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 3:
                                    if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][$j]['totalAbs'] = $absence;
                        $tabNote['user'][$i]['trimestre'][$j]['totalPunishment'] = $santion;

                    }


                }

                /******************************************************Debut calcul rang ********************************************/

                // Tableau des séquences
                $sequences = ['moyenneTrimestre'];

                // Tableau associatif pour stocker les rangs pour chaque séquence
                $rangsParSequence = [];

                // Boucle sur chaque séquence
                foreach ($sequences as $sequence) {
                    // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                    $moyennes = [];
                    foreach ($tabNote['user'] as $userId => $user) {
                        $moyennes[$userId] = $user[$sequence];
                    }

                    // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                    arsort($moyennes);

                    // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                    $rangs = [];
                    $rank = 1;
                    foreach ($moyennes as $userId => $moyenne) {
                        $rangs[$userId] = $rank;
                        $rank++;
                    }

                    // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                    foreach ($tabNote['user'] as $userId => &$user) {
                        $user['rang_'.$sequence] = $rangs[$userId];
                    }

                    // Stocker les rangs dans le tableau global
                    $rangsParSequence[$sequence] = $rangs;
                }

                // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément




                /******************************************************fin calcul rang ********************************************/
            }


            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletinmaternelle(Request $request){


        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

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
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                    ->join('matter','matter.id','=','assessments.idMatter')
                    ->where('assessments.idSchool',$request['idSchool'])
                    ->where('assessments.idSection',$request['idSection'])
                    ->where('assessments.idClasse',$request['idClasse'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['assessment'] = $assessment;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                $total_notemax_assessment = null;

                for ($k=0; $k < $assessment->count(); $k++) {
                    $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                        ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                        ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                        ->where('assessments.id',$assessment[$k]['id'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                    $total_notemax_assessment = $total_notemax_assessment + $assessment[$k]['notemax'];

                    for ($l=0; $l < $typeEvaluation->count(); $l++) {
                        //$total_matiere = $total_matiere + 1;
                        $trimestre = Trimestre::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('id',$request['idTrimestre'])
                            ->get();

                        $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                        //gérer l'affichage des points devant le type_evaluation
                        if(!empty($assessment[$k]['oral'])){
                            if($typeEvaluation[$l]['name'] == "Oral")
                                $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                        }

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

                            $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                            $total = null;

                            for ($n=0; $n < $assessmentType->count(); $n++) {
                                $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                    ->where('assessment_type.id',$assessmentType[$n]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                    ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                    ->first();


                                $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;

                                    if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                        switch ($assessmentType[$n]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                }
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                }
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                }
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                }
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                }
                                                break;
                                            case 6:
                                                $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                }
                                                break;
                                            case 7:
                                                $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                }
                                                break;
                                            case 8:
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
                                $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                            }else{
                                $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                            }


                        }

                    }

                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                    $tabNote['user'][0]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                    $tabNote['user'][0]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                    $tabNote['user'][0]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                    $tabNote['user'][0]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                    $tabNote['user'][0]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                    $tabNote['user'][0]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                    $tabNote['user'][0]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

                    $totalSequence1User = $totalSequence1User + $totalSequence1;
                    $totalSequence2User = $totalSequence2User + $totalSequence2;
                    $totalSequence3User = $totalSequence3User + $totalSequence3;
                    $totalSequence4User = $totalSequence4User + $totalSequence4;
                    $totalSequence5User = $totalSequence5User + $totalSequence5;
                    $totalSequence6User = $totalSequence6User + $totalSequence6;
                    $totalSequence7User = $totalSequence7User + $totalSequence7;
                    $totalSequence8User = $totalSequence8User + $totalSequence8;

                }



                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / $total_notemax_assessment);
                }

            }
            else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                    ->join('matter','matter.id','=','assessments.idMatter')
                    ->where('assessments.idSchool',$request['idSchool'])
                    ->where('assessments.idSection',$request['idSection'])
                    ->where('assessments.idClasse',$request['idClasse'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['assessment'] = $assessment;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                $total_notemax_assessment = null;

                for ($k=0; $k < $assessment->count(); $k++) {
                    $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                        ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                        ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                        ->where('assessments.id',$assessment[$k]['id'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                    $total_notemax_assessment = $total_notemax_assessment + $assessment[$k]['notemax'];

                    for ($l=0; $l < $typeEvaluation->count(); $l++) {
                        //$total_matiere = $total_matiere + 1;
                        $trimestre = Trimestre::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->get();

                        $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                        //gérer l'affichage des points devant le type_evaluation
                        if(!empty($assessment[$k]['oral'])){
                            if($typeEvaluation[$l]['name'] == "Oral")
                                $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                        }

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

                            $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                            $total = null;

                            for ($n=0; $n < $assessmentType->count(); $n++) {
                                $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                    ->where('assessment_type.id',$assessmentType[$n]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                    ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                    ->first();


                                $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;

                                    if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                        switch ($assessmentType[$n]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                }
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                }
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                }
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                }
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                }
                                                break;
                                            case 6:
                                                $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                }
                                                break;
                                            case 7:
                                                $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                    $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                }
                                                break;
                                            case 8:
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
                                $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                            }else{
                                $tabNote['user'][0]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                            }


                        }

                    }

                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                    $tabNote['user'][0]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                    $tabNote['user'][0]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                    $tabNote['user'][0]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                    $tabNote['user'][0]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                    $tabNote['user'][0]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                    $tabNote['user'][0]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                    $tabNote['user'][0]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                    $tabNote['user'][0]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

                    $totalSequence1User = $totalSequence1User + $totalSequence1;
                    $totalSequence2User = $totalSequence2User + $totalSequence2;
                    $totalSequence3User = $totalSequence3User + $totalSequence3;
                    $totalSequence4User = $totalSequence4User + $totalSequence4;
                    $totalSequence5User = $totalSequence5User + $totalSequence5;
                    $totalSequence6User = $totalSequence6User + $totalSequence6;
                    $totalSequence7User = $totalSequence7User + $totalSequence7;
                    $totalSequence8User = $totalSequence8User + $totalSequence8;

                }



                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / $total_notemax_assessment);
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / $total_notemax_assessment);
                }


            }
            else if(!empty($request['idTrimestre'])){

            }
            else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][$i]['assessment'] = $assessment;

                    $totalSequence1User = null;
                    $totalSequence2User = null;
                    $totalSequence3User = null;
                    $totalSequence4User = null;
                    $totalSequence5User = null;
                    $totalSequence6User = null;
                    $totalSequence7User = null;
                    $totalSequence8User = null;

                    $total_notemax_assessment = null;

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][$i]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][$i]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][$i]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
                                                    }
                                                    break;
                                                case 8:
                                                    $totalSequence8 = $totalSequence8 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment8 = $total_note_assessment8 + $ratings['value'];
                                                        $total_notemax_assessment = $total_notemax_assessment + $typeEvaluation[$l]['value'];
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
                                    $tabNote['user'][$i]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][$i]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][$i]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][$i]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][$i]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][$i]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][$i]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][$i]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][$i]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][$i]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;
                        $totalSequence7User = $totalSequence7User + $totalSequence7;
                        $totalSequence8User = $totalSequence8User + $totalSequence8;

                    }



                    if($total_notemax_assessment != 0){
                        $tabNote['user'][$i]['moyenneSequence1'] = (($totalSequence1User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence2'] = (($totalSequence2User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence3'] = (($totalSequence3User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence4'] = (($totalSequence4User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence5'] = (($totalSequence5User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence6'] = (($totalSequence6User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence7'] = (($totalSequence7User * 20) / $total_notemax_assessment);
                        $tabNote['user'][$i]['moyenneSequence8'] = (($totalSequence8User * 20) / $total_notemax_assessment);
                    }
                }

                /******************************************************Debut calcul rang ********************************************/




                /******************************************************fin calcul rang ********************************************/
            }

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletinSecondaireFrancophone(Request $request){


        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

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
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                $matterGroup = null;

                if(!empty($request['idOptionLevel'])){
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                        ->orderBy("id", "asc")
                        ->get();
                }else{
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->orderBy("id", "asc")
                        ->get();
                }


                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / ($total_notemax_assessment-20));
                }

            }
            else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                $matterGroup = null;

                if(!empty($request['idOptionLevel'])){
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                        ->orderBy("id", "asc")
                        ->get();
                }else{
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->orderBy("id", "asc")
                        ->get();
                }

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / ($total_notemax_assessment-20));
                }


            }
            else if(!empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                $moyClasse = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
                        ->where('id',$request['idTrimestre'])
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
                    $totalCoefTrim = null;

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
                        ->get();

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'] = $assessmentType;

                    for ($k=0; $k < $assessmentType->count(); $k++) {

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

                        /*
                        $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                            ->join('modules','modules.idTeacher','=','users.id')
                                            ->join('progressions','progressions.id','=','modules.idProgression')
                                            ->where('progressions.idClasse',$request['idClasse'])
                                            ->get();
                        */

                        //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                        //$total_matiere = $total_matiere + 1;
                        $rating_exits = null;
                        $matterGroup = null;

                        if(!empty($request['idOptionLevel'])){
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                                ->orderBy("id", "asc")
                                ->get();
                        }else{
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->orderBy("id", "asc")
                                ->get();
                        }

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                        $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                            ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                            ->join('ratings','ratings.idAssessment','=','assessments.id')
                            ->where('assessment_type.id', $assessmentType[$k]['id'])
                            ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                            ->whereNotNull('ratings.value')
                            ->get();
                        /*
                        Rating::selectRaw('SUM(coefficients.value) as coefficient_sum')
                                                    ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                                    ->join('coefficients', 'ratings.idCoeficient', '=', 'coefficients.id')
                                                    ->where('assessment_type.id', $assessmentType[$k]['id'])
                                                    ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                                                    ->whereNotNull('ratings.value')
                                                    ->get();
                                                    */
                        switch ($assessmentType[$k]['id']) {
                            case 1:
                                $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 2:
                                $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 3:
                                $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 4:
                                $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 5:
                                $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 6:
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
                                ->where('assessment_type.id',$assessmentType[$k]['id'])
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'] = $assessment;
                            $total = null;

                            for ($n=0; $n < $assessment->count(); $n++) {

                                $teachername = User::select('users.name as teacherName')
                                    ->join('assessments','assessments.idTeacher','=','users.id')
                                    ->where('assessments.id',$assessment[$n]['id'])
                                    ->get();


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
                                    ->where('assessment_type.id',$assessmentType[$k]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();




                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                                if(!empty($teachername)){
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                                }

                                /*
                                for($p=0; $p < $teachername->count(); $p++) {
                                    if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                    }
                                }
                                */

                                if(!empty($ratings['coefficient'])){
                                    $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                                }

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];


                                    if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                        switch ($assessmentType[$k]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
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
                            $MatterGroupId = $matterGroup[$x]['id'] ;
                            switch ($matterGroup[$x]['id']) {
                                case $MatterGroupId:
                                    if($totalCoefMatterGroup1 != 0){
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                        $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroupAssessment,2));
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                        $totalSeq = $totalSeq + $total;
                                        $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                    }

                                    break;
                            }
                        }//MatterGroup boucle fin*******************************************************************



                        if(!empty($rating_exits) && $rating_exits != 0){
                            //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                            //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                            //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                        }else{
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['total_trimestre'] = null;
                        }




                        //} *************************************************************** ici ***********************************************
                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequence'] = $totalSeq;
                        switch ($assessmentType[$k]['id']) {
                            case 1:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq1 = floatval($cleanNumber);
                                }
                                $totalSequence1User = $totalSequence1User + $totalSequence1;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq1;
                                break;
                            case 2:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq2 = floatval($cleanNumber);
                                }
                                $totalSequence2User = $totalSequence2User + $totalSequence2;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq2;
                                break;
                            case 3:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq3 = floatval($cleanNumber);
                                }
                                $totalSequence3User = $totalSequence3User + $totalSequence3;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq3;
                                break;
                            case 4:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq4 = floatval($cleanNumber);
                                }
                                $totalSequence4User = $totalSequence4User + $totalSequence4;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq4;
                                break;
                            case 5:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq5 = floatval($cleanNumber);
                                }
                                $totalSequence5User = $totalSequence5User + $totalSequence5;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq5;
                                break;
                            case 6:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq6 = floatval($cleanNumber);
                                }
                                $totalSequence6User = $totalSequence6User + $totalSequence6;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq6;
                                break;
                        }



                        //methode avec deux sequences par trimestre

                        /*
                        switch ($trimestre[$j]['id']) {
                            case '1':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                break;
                            case '2':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                break;
                            case '3':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                break;
                        }
                        */

                    }

                    $santion = Sanction::where('idUser',$entete[$i]['id'])
                        ->count();

                    $absence = Absence::where('idStudent',$entete[$i]['id'])
                        ->count();

                    //bonne moyenne 1
                    switch ($trimestre[0]['id']) {
                        case 1:
                            if($totalCoef1 != 0 && $totalCoef2 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                                if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq1 + $moyseq2)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case 2:
                            if($totalCoef3 != 0 && $totalCoef4 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence3User + $totalSequence4User)/2;
                                if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence3User / $totalCoef3)+($totalSequence4User / $totalCoef4))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq3 + $moyseq4)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case 3:
                            if($totalCoef5 != 0 && $totalCoef6 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
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

                if($effectifClasse != 0){
                    $tabNote['moyenneClasse'] = floatval(str_replace(',', '.', number_format(($moyClasse /2) / $effectifClasse,2)));
                }else{
                    $tabNote['moyenneClasse'] = null;
                }

                /******************************************************Debut calcul rang ********************************************/
                for ($i = 0; $i < $entete->count(); $i++) {
                    // ... Autres calculs ...

                    // Calcul du rang par trimestre
                    $rangementsTrimestre = [];
                    foreach ($tabNote['user'] as $key => $value) {
                        $rangementsTrimestre[$key] = $value['trimestre'][0]['moyenneTrimestre'];
                    }

                    // Triez les moyennes en ordre décroissant et conservez les clés associatives
                    arsort($rangementsTrimestre);

                    // Attribuez le rang à chaque moyenne
                    $rang = 1;
                    $previousMoyenne = null;
                    foreach ($rangementsTrimestre as $key => $moyenne) {
                        if ($moyenne !== $previousMoyenne) {
                            $previousMoyenne = $moyenne;
                            $rangementsTrimestre[$key] = $rang;
                        } else {
                            $rangementsTrimestre[$key] = $rang;
                        }
                        $rang++;
                    }

                    // Affectez le rang à l'utilisateur actuel
                    $tabNote['user'][$i]['trimestre'][0]['rangTrimestre'] = $rangementsTrimestre[$i] ?? null;

                    // ... Autres calculs ...
                }

                //calculer le rang par sequence
                for ($i = 0; $i < count($tabNote['user']); $i++) {
                    for ($j = 0; $j < count($tabNote['user'][$i]['trimestre'][0]['assessmentType']); $j++) {
                        $currentMoyenne = $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$j]['moyenne'];
                        $rank = 1;

                        for ($k = 0; $k < count($tabNote['user']); $k++) {
                            if ($k != $i) {
                                $compareMoyenne = $tabNote['user'][$k]['trimestre'][0]['assessmentType'][$j]['moyenne'];
                                if ($compareMoyenne > $currentMoyenne) {
                                    $rank++;
                                } elseif ($compareMoyenne == $currentMoyenne) {
                                    // En cas d'égalité, le rang est le même
                                    $rank = $tabNote['user'][$k]['trimestre'][0]['assessmentType'][$j]['rang'];
                                }
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$j]['rang'] = $rank;
                    }
                }


                /******************************************************fin calcul rang ********************************************/

            }
            else if(!empty($request['idAssessmentType'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                $moyClasse = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


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

                        if(!empty($request['idOptionLevel'])){
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                                ->orderBy("id", "asc")
                                ->get();
                        }else{
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->orderBy("id", "asc")
                                ->get();
                        }

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'] = $matterGroup;

                        $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                            ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                            ->join('ratings','ratings.idAssessment','=','assessments.id')
                            ->where('assessment_type.id', $assessmentType[0]['id'])
                            ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                            ->whereNotNull('ratings.value')
                            ->get();

                        switch ($assessmentType[0]['id']) {
                            case 1:
                                $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 2:
                                $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 3:
                                $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 4:
                                $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 5:
                                $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 6:
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
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'] = $assessment;
                            $total = null;

                            for ($n=0; $n < $assessment->count(); $n++) {

                                $teachername = User::select('users.name as teacherName')
                                    ->join('assessments','assessments.idTeacher','=','users.id')
                                    ->where('assessments.id',$assessment[$n]['id'])
                                    ->get();


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
                                    ->where('assessment_type.id',$assessmentType[0]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();




                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                                if(!empty($teachername)){
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                                }

                                if(!empty($ratings['coefficient'])){
                                    $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                                }

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];


                                    if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                        switch ($assessmentType[0]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
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
                            $MatterGroupId = $matterGroup[$x]['id'] ;
                            switch ($matterGroup[$x]['id']) {
                                case $MatterGroupId:
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                    $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                    $totalSeq = $totalSeq + $total;
                                    $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                    break;
                                /*
                                case 2:
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup2;
                                    $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup2 / $totalCoefMatterGroup2,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                    break;
                                    */
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
                        switch ($assessmentType[0]['id']) {
                            case 1:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq1 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq1;
                                }
                                break;
                            case 2:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq2 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq2;
                                }
                                break;
                            case 3:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq3 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq3;
                                }
                                break;
                            case 4:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq4 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq4;
                                }
                                break;
                            case 5:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq5 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq5;
                                }
                                break;
                            case 6:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq6 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq6;
                                }
                                break;
                        }



                        switch ($assessmentType[0]['id']) {
                            case 1:
                                $totalSequence1User = $totalSequence1User + $totalSequence1;
                                break;
                            case 2:
                                $totalSequence2User = $totalSequence2User + $totalSequence2;
                                break;
                            case 3:
                                $totalSequence3User = $totalSequence3User + $totalSequence3;
                                break;
                            case 4:
                                $totalSequence4User = $totalSequence4User + $totalSequence4;
                                break;
                            case 5:
                                $totalSequence5User = $totalSequence5User + $totalSequence5;
                                break;
                            case 6:
                                $totalSequence6User = $totalSequence6User + $totalSequence6;
                                break;
                        }



                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        //bonne moyenne 1
                        switch ($trimestre[0]['id']) {
                            case 1:
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

                            case 2:
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

                            case 3:
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

            }
            else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
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

                    $totalCoef = null ;
                    $totaltermAv = null ;

                    for ($j=0; $j < $trimestre->count(); $j++) {

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->get();

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'] = $assessmentType;

                        for ($k=0; $k < $assessmentType->count(); $k++) {

                            $totalSequence1 = null;
                            $totalSequence2 = null;
                            $totalSequence3 = null;
                            $totalSequence4 = null;
                            $totalSequence5 = null;
                            $totalSequence6 = null;
                            $totalNoteCoef = null;
                            $total = null;
                            $coefficient = null;

                            $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                ->join('modules','modules.idTeacher','=','users.id')
                                ->join('progressions','progressions.id','=','modules.idProgression')
                                ->where('progressions.idClasse',$request['idClasse'])
                                ->get();

                            //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                            //$total_matiere = $total_matiere + 1;
                            $rating_exits = null;
                            $matterGroup = null;

                            if(!empty($request['idOptionLevel'])){
                                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                    ->where('matter_group.idSchool',$request['idSchool'])
                                    ->where('matter_group.idSection',$request['idSection'])
                                    ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                                    ->orderBy("id", "asc")
                                    ->get();
                            }else{
                                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                    ->where('matter_group.idSchool',$request['idSchool'])
                                    ->where('matter_group.idSection',$request['idSection'])
                                    ->orderBy("id", "asc")
                                    ->get();
                            }

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                            for ($x=0; $x < $matterGroup->count(); $x++) {
                                $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                                    ->join('matter','matter.id','=','assessments.idMatter')
                                    ->where('assessments.idSchool',$request['idSchool'])
                                    ->where('assessments.idSection',$request['idSection'])
                                    ->where('assessments.idClasse',$request['idClasse'])
                                    ->orderBy("id", "asc")
                                    ->get();

                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'] = $assessment;
                                $total = null;

                                for ($n=0; $n < $assessment->count(); $n++) {


                                    $coefficient = Rating::select('coefficients.value as coefficient')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                        ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->first();

                                    if(!empty($coefficient)){
                                        $totalCoef = $totalCoef + $coefficient['coefficient'];
                                    }else{
                                        $totalCoef = $totalCoef + 0;
                                    }

                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                        ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$k]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->first();


                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;


                                    for($p=0; $p < $teachername->count(); $p++) {
                                        if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                        }
                                    }
                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;
                                        $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                        if($assessment[$n]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$k]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }

                                    }

                                    $totaltermAv = $totaltermAv + $total;


                                }
                            }



                            if(!empty($rating_exits) && $rating_exits != 0){
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                                //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total_trimestre'] = null;
                            }




                            //} *************************************************************** ici ***********************************************

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence'] = $total;
                            if(!empty($coefficient)){
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*1;
                            }

                            if($totalCoef != 0){
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['moyenne'] = $totalNoteCoef / $totalCoef;
                            }

                            //methode avec deux sequences par trimestre

                            /*
                            switch ($trimestre[$j]['id']) {
                                case '1':
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                    break;
                                case '2':
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                    break;
                                case '3':
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                    break;
                            }
                            */

                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            $totalSequence6User = $totalSequence6User + $totalSequence6;

                        }

                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        if($totalCoef != 0){
                            $tabNote['user'][$i]['trimestre'][$j]['totalCoef'] = $totalCoef;
                            $tabNote['user'][$i]['trimestre'][$j]['total'] = $totaltermAv;
                            //bonne moyenne 1
                            switch ($trimestre[$j]['id']) {
                                case 1:
                                    if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 2:
                                    if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 3:
                                    if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][$j]['totalAbs'] = $absence;
                        $tabNote['user'][$i]['trimestre'][$j]['totalPunishment'] = $santion;

                    }


                }

                /******************************************************Debut calcul rang ********************************************/




                /******************************************************fin calcul rang ********************************************/
            }

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function bulletinSecondaireFrancophoneNewStructure(Request $request){


        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

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
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / ($total_notemax_assessment-20));
                }

            }else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / ($total_notemax_assessment-20));
                }


            }else if(!empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;

                $totalCoef1 = null ;
                $totalCoef2 = null ;
                $totalCoef3 = null ;
                $totalCoef4 = null ;
                $totalCoef5 = null ;
                $totalCoef6 = null ;
                $totalNoteCoef = null;

                for ($i=0; $i < $entete->count(); $i++) {

                    $matterGroup = null;

                    if(!empty($request['idOptionLevel'])){
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                            ->orderBy("id", "asc")
                            ->get();
                    }else{
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                            ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->orderBy("id", "asc")
                            ->get();
                    }

                    $tabNote['user'][$i]['matterGroup'] = $matterGroup;

                    for ($x=0; $x < $matterGroup->count(); $x++) {

                        $totalNoteCoefMatterGroup1 = null;
                        $MatterGroupId = null;
                        $totalNoteCoefMatterGroup2 = null;
                        $totalCoefMatterGroup1 = null;
                        $totalCoefMatterGroup2 = null;

                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->where('matter_group.id',$matterGroup[$x]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'] = $assessment;
                        $total = null;

                        for ($n=0; $n < $assessment->count(); $n++) {

                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $teachername = User::select('users.name as teacherName')
                                ->join('assessments','assessments.idTeacher','=','users.id')
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->get();

                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['teacherName'] = $teachername[0]['teacherName'];

                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'] = $trimestre;

                            $assessmentType = AssessmentType::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('idTrimestre',$trimestre[0]['id'])
                                ->get();

                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'] = $assessmentType;

                            for ($k=0; $k < $assessmentType->count(); $k++) {

                                $totalSequence1 = null;
                                $totalSequence2 = null;
                                $totalSequence3 = null;
                                $totalSequence4 = null;
                                $totalSequence5 = null;
                                $totalSequence6 = null;
                                $total = null;
                                $coefficient = null;
                                $rating_exits = null;

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
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                    ->where('assessment_type.id',$assessmentType[$k]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();

                                $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['ratings'] = $ratings;

                                $coefficientSum = Rating::selectRaw('SUM(coefficients.value) as coefficient_sum')
                                    ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                    ->join('coefficients', 'ratings.idCoeficient', '=', 'coefficients.id')
                                    ->where('assessment_type.id', $assessmentType[$k]['id'])
                                    ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                                    ->whereNotNull('ratings.value')
                                    ->get();


                                switch ($assessmentType[$k]['id']) {
                                    case 1:
                                        $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                                        break;
                                    case 2:
                                        $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                                        break;
                                    case 3:
                                        $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                                        break;
                                    case 4:
                                        $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                                        break;
                                    case 5:
                                        $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                                        break;
                                    case 6:
                                        $totalCoef6 = $coefficientSum[0]['coefficient_sum'];
                                        break;
                                }

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                    if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                        switch ($assessmentType[$k]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
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

                                            default:
                                                # code...
                                                break;
                                        }


                                    }

                                }

                                /*
                                if($rating_exits == 1 ){
                                    switch ($matterGroup[$x]['id']) {
                                        case 1:
                                            $totalCoefMatterGroup1 = $totalCoefMatterGroup1 + $ratings['coefficient'];
                                            break;
                                        case 2:
                                            $totalCoefMatterGroup2 = $totalCoefMatterGroup2 + $ratings['coefficient'];
                                            break;
                                    }
                                }
                                */


                                /*************************************************** Debut Total seq et Total Coef Seq**************************************/

                                switch ($assessmentType[$k]['id']) {
                                    case 1:
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence1;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoef1;
                                        if($totalCoef1 != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['moyenne'] = number_format($totalSequence1 / $totalCoef1,2);
                                        }
                                        break;
                                    case 2:
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence2;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoef2;
                                        if($totalCoef2 != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['moyenne'] = number_format($totalSequence2 / $totalCoef2,2);
                                        }
                                        break;
                                    case 3:
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence3;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoef3;
                                        if($totalCoef3 != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['moyenne'] = number_format($totalSequence3 / $totalCoef3,2);
                                        }
                                        break;
                                    case 4:
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence4;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoef4;
                                        if($totalCoef4 != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['moyenne'] = number_format($totalSequence4 / $totalCoef4,2);
                                        }
                                        break;
                                    case 5:
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence5;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoef5;
                                        if($totalCoef5 != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['moyenne'] = number_format($totalSequence5 / $totalCoef5,2);
                                        }
                                        break;
                                    case 6:
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence6;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoef6;
                                        if($totalCoef6 != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['trimestre'][0]['assessmentType'][$k]['moyenne'] = number_format($totalSequence6 / $totalCoef6,2);
                                        }
                                        break;
                                }

                                switch ($assessmentType[$k]['id']) {
                                    case 1:
                                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                                        break;
                                    case 2:
                                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                                        break;
                                    case 3:
                                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                                        break;
                                    case 4:
                                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                                        break;
                                    case 5:
                                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                                        break;
                                    case 6:
                                        $totalSequence6User = $totalSequence6User + $totalSequence6;
                                        break;
                                }


                                /*************************************************** Fin Total seq et Total Coef Seq**************************************/


                            }

                            /******************************************************Debut calcul moyenne ********************************************/

                            //bonne moyenne 1
                            switch ($trimestre[0]['id']) {
                                case 1:
                                    if($totalCoef1 != 0 && $totalCoef2 != 0){
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['totalCoef'] = ($totalCoef1 + $totalCoef2)/2;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                                        if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['moyenneTrimestre'] = number_format((($totalSequence1User / $totalCoef1)+($totalSequence2User / $totalCoef2))/2,2);
                                        }else{
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['moyenneTrimestre'] = null;
                                        }
                                    }

                                    break;

                                case 2:
                                    if($totalCoef3 != 0 && $totalCoef4 != 0){
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['totalCoef'] = ($totalCoef3 + $totalCoef4)/2;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['total'] = ($totalSequence3User + $totalSequence4User)/2;
                                        if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['moyenneTrimestre'] = number_format((($totalSequence3User / $totalCoef3)+($totalSequence4User / $totalCoef4))/2,2);
                                        }else{
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['moyenneTrimestre'] = null;
                                        }
                                    }

                                    break;

                                case 3:
                                    if($totalCoef5 != 0 && $totalCoef6 != 0){
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['totalCoef'] = ($totalCoef5 + $totalCoef6)/2;
                                        $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['total'] = ($totalSequence5User + $totalSequence6User)/2;
                                        if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['moyenneTrimestre'] = number_format((($totalSequence5User / $totalCoef5)+($totalSequence6User / $totalCoef6))/2,2);
                                        }else{
                                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['moyenneTrimestre'] = null;
                                        }
                                    }

                                    break;
                            }

                            $santion = Sanction::where('idUser',$entete[$i]['id'])
                                ->count();

                            $absence = Absence::where('idStudent',$entete[$i]['id'])
                                ->count();

                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['totalAbs'] = $absence;
                            $tabNote['user'][$i]['matterGroup'][$x]['assessment'][$n]['totalPunishment'] = $santion;


                            /******************************************************fin calcul moyenne ********************************************/



                        }

                        switch ($matterGroup[$x]['id']) {
                            case 1:
                                $tabNote['user'][$i]['matterGroup'][$x]['totalCoefMatterGroup1'] = $totalCoefMatterGroup1;
                                $tabNote['user'][$i]['matterGroup'][$x]['totalCoefNoteGroupMatter1'] = $totalNoteCoefMatterGroup1;
                                if($totalCoefMatterGroup1 != 0){
                                    $tabNote['user'][$i]['matterGroup'][$x]['moyenneMatterGroup1'] = number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2);
                                }
                                break;
                            case 2:
                                $tabNote['user'][$i]['matterGroup'][$x]['totalCoefMatterGroup2'] = $totalCoefMatterGroup2;
                                $tabNote['user'][$i]['matterGroup'][$x]['totalCoefNoteGroupMatter2'] = $totalNoteCoefMatterGroup2;
                                if($totalCoefMatterGroup2 != 0){
                                    $tabNote['user'][$i]['matterGroup'][$x]['moyenneMatterGroup2'] = number_format($totalNoteCoefMatterGroup2 / $totalCoefMatterGroup2,2);
                                }
                                break;
                        }



                    }






                }

                /******************************************************Debut calcul rang ********************************************/




                /******************************************************fin calcul rang ********************************************/

            }else if(!empty($request['idAssessmentType'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
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

                    $totalCoef = null ;
                    $totaltermAv = null ;

                    for ($j=0; $j < $trimestre->count(); $j++) {

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->where('id',$request['idAssessmentType'])
                            ->get();

                        if (!$assessmentType->isEmpty()) {
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'] = $assessmentType;
                            // Le reste de votre code...
                        } else {
                            return $this->sendError("vous n'avez pas d'assessmentType d'id ".$request['idAssessmentType']." pour le trismestre ".$trimestre[$j]['id']);
                        }


                        $totalSequence1 = null;
                        $totalSequence2 = null;
                        $totalSequence3 = null;
                        $totalSequence4 = null;
                        $totalSequence5 = null;
                        $totalSequence6 = null;
                        $totalNoteCoef = null;
                        $total = null;
                        $coefficient = null;

                        $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                            ->join('modules','modules.idTeacher','=','users.id')
                            ->join('progressions','progressions.id','=','modules.idProgression')
                            ->where('progressions.idClasse',$request['idClasse'])
                            ->get();

                        //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                        //$total_matiere = $total_matiere + 1;
                        $rating_exits = null;

                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                            ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['matterGroup'] = $matterGroup;

                        for ($x=0; $x < $matterGroup->count(); $x++) {
                            $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                                ->join('matter','matter.id','=','assessments.idMatter')
                                ->where('assessments.idSchool',$request['idSchool'])
                                ->where('assessments.idSection',$request['idSection'])
                                ->where('assessments.idClasse',$request['idClasse'])
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['matterGroup'][$x]['assessment'] = $assessment;
                            $total = null;

                            for ($n=0; $n < $assessment->count(); $n++) {


                                $coefficient = Rating::select('coefficients.value as coefficient')
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();

                                if(!empty($coefficient)){
                                    $totalCoef = $totalCoef + $coefficient['coefficient'];
                                }else{
                                    $totalCoef = $totalCoef + 0;
                                }

                                $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                    ->where('assessment_type.id',$assessmentType[0]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();


                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;


                                for($p=0; $p < $teachername->count(); $p++) {
                                    if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                    }
                                }
                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                    if($assessment[$n]['nameMatter'] = $ratings['nameMatter']){
                                        switch ($assessmentType[0]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
                                                $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                                break;

                                            default:
                                                # code...
                                                break;
                                        }
                                    }

                                }

                                $totaltermAv = $totaltermAv + $total;


                            }
                        }



                        if(!empty($rating_exits) && $rating_exits != 0){
                            //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                            //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                            //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                        }else{
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['total_trimestre'] = null;
                        }




                        //} *************************************************************** ici ***********************************************

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['totalSequence'] = $total;
                        if(!empty($coefficient)){
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['totalSequenceCoef'] = $total*$coefficient['coefficient'];
                        }else{
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['totalSequenceCoef'] = $total*1;
                        }

                        if($totalCoef != 0){
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][0]['moyenne'] = $totalNoteCoef / $totalCoef;
                        }


                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;



                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        if($totalCoef != 0){
                            $tabNote['user'][$i]['trimestre'][$j]['totalCoef'] = $totalCoef;
                            $tabNote['user'][$i]['trimestre'][$j]['total'] = $totaltermAv;
                            //bonne moyenne 1
                            switch ($trimestre[$j]['id']) {
                                case 1:
                                    if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 2:
                                    if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 3:
                                    if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][$j]['totalAbs'] = $absence;
                        $tabNote['user'][$i]['trimestre'][$j]['totalPunishment'] = $santion;

                    }


                }

                /******************************************************Debut calcul rang ********************************************/




                /******************************************************fin calcul rang ********************************************/

            }else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
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

                    $totalCoef = null ;
                    $totaltermAv = null ;

                    for ($j=0; $j < $trimestre->count(); $j++) {

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->get();

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'] = $assessmentType;

                        for ($k=0; $k < $assessmentType->count(); $k++) {

                            $totalSequence1 = null;
                            $totalSequence2 = null;
                            $totalSequence3 = null;
                            $totalSequence4 = null;
                            $totalSequence5 = null;
                            $totalSequence6 = null;
                            $totalNoteCoef = null;
                            $total = null;
                            $coefficient = null;

                            $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                ->join('modules','modules.idTeacher','=','users.id')
                                ->join('progressions','progressions.id','=','modules.idProgression')
                                ->where('progressions.idClasse',$request['idClasse'])
                                ->get();

                            //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                            //$total_matiere = $total_matiere + 1;
                            $rating_exits = null;

                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                            for ($x=0; $x < $matterGroup->count(); $x++) {
                                $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                                    ->join('matter','matter.id','=','assessments.idMatter')
                                    ->where('assessments.idSchool',$request['idSchool'])
                                    ->where('assessments.idSection',$request['idSection'])
                                    ->where('assessments.idClasse',$request['idClasse'])
                                    ->orderBy("id", "asc")
                                    ->get();

                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'] = $assessment;
                                $total = null;

                                for ($n=0; $n < $assessment->count(); $n++) {


                                    $coefficient = Rating::select('coefficients.value as coefficient')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                        ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->first();

                                    if(!empty($coefficient)){
                                        $totalCoef = $totalCoef + $coefficient['coefficient'];
                                    }else{
                                        $totalCoef = $totalCoef + 0;
                                    }

                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                        ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$k]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->first();


                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;


                                    for($p=0; $p < $teachername->count(); $p++) {
                                        if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                        }
                                    }
                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;
                                        $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                        if($assessment[$n]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$k]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }

                                    }

                                    $totaltermAv = $totaltermAv + $total;


                                }
                            }



                            if(!empty($rating_exits) && $rating_exits != 0){
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                                //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total_trimestre'] = null;
                            }




                            //} *************************************************************** ici ***********************************************

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence'] = $total;
                            if(!empty($coefficient)){
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*1;
                            }

                            if($totalCoef != 0){
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['moyenne'] = $totalNoteCoef / $totalCoef;
                            }

                            //methode avec deux sequences par trimestre

                            /*
                        switch ($trimestre[$j]['id']) {
                            case '1':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                break;
                            case '2':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                break;
                            case '3':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                break;
                        }
                        */

                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            $totalSequence6User = $totalSequence6User + $totalSequence6;

                        }

                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        if($totalCoef != 0){
                            $tabNote['user'][$i]['trimestre'][$j]['totalCoef'] = $totalCoef;
                            $tabNote['user'][$i]['trimestre'][$j]['total'] = $totaltermAv;
                            //bonne moyenne 1
                            switch ($trimestre[$j]['id']) {
                                case 1:
                                    if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 2:
                                    if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 3:
                                    if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][$j]['totalAbs'] = $absence;
                        $tabNote['user'][$i]['trimestre'][$j]['totalPunishment'] = $santion;

                    }


                }

                /******************************************************Debut calcul rang ********************************************/




                /******************************************************fin calcul rang ********************************************/
            }

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletin4(Request $request){


        try {
            $tabNote = array();

            $effectifClasse = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('roles.id',8)
                ->where('users.idSchool',$request['idSchool'])
                ->where('users.idSection',$request['idSection'])
                ->where('users.idClasse',$request['idClasse'])
                ->count();

            $tabNote['effectifClasse'] = $effectifClasse;


            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->where('users.idClasse',$request['idClasse'])
                ->orderBy("users.name", "asc")
                ->get();
            $tabNote['user'] = $entete;

            for ($r=0; $r < $entete->count(); $r++) {
                $assessment = Assessment::select('assessments.id as id','assessments.idMatter as idMatter')
                    ->where('idSchool',$request['idSchool'])
                    ->where('idSection',$request['idSection'])
                    ->get();

                $tabNote['user'][$r]['assessment'] = $assessment;

                for ($i=0; $i < $assessment->count(); $i++) {
                    $matterGroup = MatterGroup::select('id','name','description')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
                        ->get();

                    $tabNote['user'][$r]['assessment'][$i]['matterGroup'] = $matterGroup;

                    for ($j=0; $j < $matterGroup->count(); $j++) {
                        $matter = Matter::select('matter.id as id','matter.code as code','matter.libelle as libelle','matter.name as name')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->where('matter_group.id',$matterGroup[$j]['id'])
                            ->where('matter.id',$assessment[$i]['idMatter'])
                            ->where('matter.idSchool',$request['idSchool'])
                            ->where('matter.idSection',$request['idSection'])
                            ->orderBy("matter.id", "asc")
                            ->get();

                        $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'] = $matter;

                        for ($k=0; $k < $matter->count(); $k++) {
                            $typeEvaluation = TypeEvaluation::select('type_evaluation.id as id','type_evaluation.name as name')
                                ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                                ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                                ->where('assessments.id',$assessment[$i]['id'])
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'][$k]['typeEvaluation'] = $typeEvaluation;

                            for ($l=0; $l < $typeEvaluation->count(); $l++) {
                                $trimestre = Trimestre::select('id','name')
                                    ->where('idSchool',$request['idSchool'])
                                    ->where('idSection',$request['idSection'])
                                    ->get();

                                $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                                $rating_exits = null;
                                for ($m=0; $m < $trimestre->count(); $m++) {
                                    $assessmentType = AssessmentType::select('id','name')
                                        ->where('idSchool',$request['idSchool'])
                                        ->where('idSection',$request['idSection'])
                                        ->where('idTrimestre',$trimestre[$m]['id'])
                                        ->get();

                                    $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                    $total = null;

                                    for ($n=0; $n < $assessmentType->count(); $n++) {
                                        $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax')
                                            ->join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->where('ratings.idMatter',$matter[$k]['id'])
                                            ->where('assessment_type.id',$assessmentType[$n]['id'])
                                            ->where('ratings.idStudent',$tabNote['user'][$r]['id'])
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->first();

                                        $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                        if(!empty($ratings['value'])){
                                            $total = $total + $ratings['value'];
                                            $rating_exits = $rating_exits + 1;
                                        }
                                    }

                                    if($rating_exits == 3){
                                        $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                    }else{
                                        $tabNote['user'][$r]['assessment'][$i]['matterGroup'][$j]['matter'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                    }


                                }

                            }

                        }

                    }
                }
            }



            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletin2(Request $request){


        try {
            $tabNote = array();

            $effectifClasse = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('roles.id',8)
                ->where('users.idSchool',$request['idSchool'])
                ->where('users.idSection',$request['idSection'])
                ->where('users.idClasse',$request['idClasse'])
                ->count();

            $tabNote['effectifClasse'] = $effectifClasse;


            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->where('users.idClasse',$request['idClasse'])
                ->get();
            $tabNote['user'] = $entete;

            for ($i=0; $i < $entete->count(); $i++) {
                $trimestre = Trimestre::select('id','name')
                    ->where('idSchool',$request['idSchool'])
                    ->where('idSection',$request['idSection'])
                    ->get();

                $tabNote['user'][$i]['trimestre'] = $trimestre;

                for ($j=0; $j < $trimestre->count(); $j++) {
                    $assessmentType = AssessmentType::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
                        ->where('idTrimestre',$trimestre[$j]['id'])
                        ->get();

                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'] = $assessmentType;

                    for ($k=0; $k < $assessmentType->count(); $k++) {
                        $matterGroup = MatterGroup::select('id','name','description')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->get();

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                        for ($l=0; $l < $matterGroup->count(); $l++) {
                            $matter = Matter::select('matter.id as id','matter.code as code','matter.libelle as libelle','matter.name as name')
                                ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                                ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                                ->where('matter_group.id',$matterGroup[$l]['id'])
                                ->where('matter.idSchool',$request['idSchool'])
                                ->where('matter.idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$l]['matter'] = $matter;

                            for ($m=0; $m < $matter->count(); $m++) {
                                $ratings = Rating::select('ratings.value as value','type_evaluation.name as typeEvaluation','ratings.observation as observation')
                                    ->join('type_evaluation','type_evaluation.id','=','ratings.idTypeEvaluation')
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->where('ratings.idMatter',$matter[$m]['id'])
                                    ->where('assessments.idAssessmentType',$assessmentType[$k]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->get();

                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$l]['matter'][$m]['ratings'] = $ratings;

                                $total = 0;

                                for ($n=0; $n < $ratings->count(); $n++) {
                                    $total = $ratings[$n]['value'] + $total;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$l]['matter'][$m]['total'] = $total;
                                }

                            }

                        }

                    }

                }
            }

            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function bulletin3(Request $request){


        try {
            $tabNote = array();

            $idClasse = User::select('idClasse')->where('id',$request['idStudent'])->get();

            //return $idClasse[0]['idClasse'];

            $effectifClasse = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('roles.id',8)
                ->where('users.idSchool',$request['idSchool'])
                ->where('users.idSection',$request['idSection'])
                ->where('users.idClasse',$idClasse[0]['idClasse'])
                ->count();

            $tabNote['effectifClasse'] = $effectifClasse;

            $entete = User::select('users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->where('users.id',$request['idStudent'])
                ->first();
            $tabNote['entete'] = $entete;

            $notEleve = Rating::select('matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter', 'ratings.idStudent as idStudent','ratings.idAssessment as idAssessment','ratings.value as value',
                'ratings.observation as observation','ratings.idCoeficient as idCoeficient','ratings.idTeacher as idTeacher'
            )
                ->join('assessments', 'ratings.idAssessment', '=','assessments.id')
                ->join('matter','ratings.idMatter','=','matter.id')
                ->where('ratings.idSchool',$request['idSchool'])
                ->where('ratings.idSection',$request['idSection'])
                ->where('ratings.idStudent',$request['idStudent'])
                ->where('assessments.idAssessmentType',$request['idAssessmentType'])
                ->get();

            $tabNote['noteEleve'] = $notEleve;
            /*
            $idAssessmentType = $request['idAssessmentType'];
            $idAssessmentType2 = $request['idAssessmentType2'];

            $effectifClasse = User::join('classes','classes.id','=','users.idClasse')
                            ->count();

            $tabNote['effectifClasse'] = $effectifClasse;

            $entete = User::select('users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                                    'classes.name as classe','classes.idTeacher as idTeacher')
                            ->join('classes','classes.id','=','users.idClasse')
                            ->where('users.id',$request['idStudent'])
                            ->first();
            $tabNote['entete'] = $entete;

            $teacher = User::select('users.name as name')
                            ->where('users.id',$entete['idTeacher'])
                            ->first();

            $tabNote['teacher'] = $teacher;

            $noteClasse = DB::table('ratings')
                            ->select(DB::raw('MAX(ratings.value) as MAX'),DB::raw('MIN(ratings.value) as MIN'),DB::raw('AVG(ratings.value) as AVG'),'matter.name as nameMatter')
                            ->join('matter','ratings.idMatter','=','matter.id')
                            ->where('ratings.idSchool',$request['idSchool'])
                            ->where('ratings.idSection',$request['idSection'])
                            ->groupBy('matter.name')
                            ->get();
            $tabNote['noteClasse'] = $noteClasse;

            $notEleve = DB::table('ratings')
                            ->select('matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter', 'ratings.idStudent as idStudent','ratings.idAssessment as idAssessment','ratings.value as value',
                                    'ratings.observation as observation','ratings.idCoeficient as idCoeficient','ratings.idTeacher as idTeacher',
                                    DB::raw('ratings.value*coefficients.value as noteCoef'),'matter_group.name as matterGroup')
                            ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                            ->join('matter','ratings.idMatter','=','matter.id')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group_has_matter.matter_group_id','=','matter_group.id')
                            ->where('ratings.idSchool',$request['idSchool'])
                            ->where('ratings.idSection',$request['idSection'])
                            ->where('ratings.idStudent',$request['idStudent'])
                            ->groupBy('ratings.idStudent','matter.name','ratings.idAssessment','ratings.idCoeficient','ratings.idTeacher','ratings.value',
                                    'ratings.observation','coefficients.value','matter_group.name','matter.code','matter.libelle')
                            ->get();

            $tabNote['noteEleve'] = $notEleve;

            $totalTravailTrimestre = DB::table('ratings')
                                    ->select(DB::raw('SUM(ratings.value*coefficients.value) as TotalPoints'), DB::raw('SUM(coefficients.value) as TotalCoef'))
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->where('ratings.idSchool',$request['idSchool'])
                                    ->where('ratings.idSection',$request['idSection'])
                                    ->where('ratings.idStudent',$request['idStudent'])
                                    ->get();

            $tabNote['totalTravailTrimestre'] = $totalTravailTrimestre;

            $totalGroupeMatter = DB::table('ratings')
                                    ->select('matter_group.name','assessment_type.name as EVAL', DB::raw('SUM(ratings.value) as TotalNote'), DB::raw('SUM(coefficients.value) as TotalCoef'),DB::raw('SUM(ratings.value*coefficients.value) as TotalNoteCoef'))
                                    ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                    ->join('matter','ratings.idMatter','=','matter.id')
                                    ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                                    ->join('matter_group','matter_group_has_matter.matter_group_id','=','matter_group.id')
                                    ->join('assessments', 'ratings.idAssessment', '=', 'assessments.id')
                                    ->join('assessment_type', 'assessments.idAssessmentType', '=', 'assessment_type.id')
                                    ->where(function($query ) use($idAssessmentType,$idAssessmentType2){
                                        $query->where('assessment_type.id',$idAssessmentType)
                                              ->orWhere('assessment_type.id',$idAssessmentType2);
                                    })
                                    ->where('ratings.idSchool',$request['idSchool'])
                                    ->where('ratings.idSection',$request['idSection'])
                                    ->groupBy('matter_group.name','assessment_type.name')
                                    ->get();

            $tabNote['totalGroupeMatter'] = $totalGroupeMatter;

            $absTotaltrimestre = DB::table('courses')
                                    ->select('assessment_type.name as EVAL',DB::raw('SUM(courses.duration) as AbsTotales'))
                                    ->join('absences','courses.id','=','absences.idCourse')
                                    ->join('assessment_type','absences.idAssessmentType','=','assessment_type.id')
                                    ->where('courses.idSchool',$request['idSchool'])
                                    ->where('courses.idSection',$request['idSection'])
                                    ->where('absences.idStudent',$request['idStudent'])
                                    ->where(function($query ) use($idAssessmentType,$idAssessmentType2){
                                        $query->where('assessment_type.id',$idAssessmentType)
                                              ->orWhere('assessment_type.id',$idAssessmentType2);
                                    })
                                    ->groupBy('assessment_type.name')
                                    ->get();

            $tabNote['absTotaltrimestre'] = $absTotaltrimestre;

            $absTotaljustifietrimestre = DB::table('courses')
                                    ->select('assessment_type.name as EVAL',DB::raw('SUM(courses.duration) as AbsTotalesJustifie'))
                                    ->join('absences','courses.id','=','absences.idCourse')
                                    ->join('assessment_type','absences.idAssessmentType','=','assessment_type.id')
                                    ->where('courses.idSchool',$request['idSchool'])
                                    ->where('courses.idSection',$request['idSection'])
                                    ->where('absences.idStudent',$request['idStudent'])
                                    ->where(function($query ) use($idAssessmentType,$idAssessmentType2){
                                        $query->where('assessment_type.id',$idAssessmentType)
                                              ->orWhere('assessment_type.id',$idAssessmentType2);
                                    })
                                    ->where('absences.is_justified',1)
                                    ->groupBy('assessment_type.name')
                                    ->get();

            $tabNote['absTotaljustifietrimestre'] = $absTotaljustifietrimestre;

            $absTotalNonJustifieTrimestre = DB::table('courses')
                                    ->select('assessment_type.name as EVAL',DB::raw('SUM(courses.duration) as AbsTotalesNonJustifie'))
                                    ->join('absences','courses.id','=','absences.idCourse')
                                    ->join('assessment_type','absences.idAssessmentType','=','assessment_type.id')
                                    ->where('courses.idSchool',$request['idSchool'])
                                    ->where('courses.idSection',$request['idSection'])
                                    ->where('absences.idStudent',$request['idStudent'])
                                    ->where(function($query ) use($idAssessmentType,$idAssessmentType2){
                                        $query->where('assessment_type.id',$idAssessmentType)
                                              ->orWhere('assessment_type.id',$idAssessmentType2);
                                    })
                                    ->where('absences.is_justified',0)
                                    ->groupBy('assessment_type.name')
                                    ->get();

            $tabNote['absTotalNonJustifieTrimestre'] = $absTotalNonJustifieTrimestre;
            */

            /*--------------------------------------------------------------------*/

            /*
            $absTotalNonJustifieTrimestre = DB::table('ratings')
                                    ->select('assessment_type.name as EVAL',DB::raw('SUM(courses.duration) as AbsTotales)'))
                                    ->join('users','ratings.idStudent','=','users.id')
                                    ->join('absences','users.id','=','absences.idStudent')
                                    ->join('courses','absences.idCourse','=','courses.id')
                                    ->join('assessments', 'ratings.idAssessment', '=', 'assessments.id')
                                    ->join('assessment_type', 'assessments.idAssessmentType', '=', 'assessment_type.id')
                                    ->where('assessment_type.id',$request['idAssessmentType'])
                                    ->orWhere('assessment_type.id',$request['idAssessmentType2'])
                                    ->where('ratings.idSchool',$request['idSchool'])
                                    ->where('ratings.idSection',$request['idSection'])
                                    ->where('absences.is_justified',0)
                                    ->groupBy('assessment_type.name')
                                    ->get();

            $tabNote['absTotalNonJustifieTrimestre'] = $absTotalNonJustifieTrimestre;
            */

            return $this->sendResponse($tabNote, 'Notes');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }


    public function imprimerBulletin(Request $request){

        try {

            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

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
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['totalNoteMax'] = $total_notemax_assessment;
                    $tabNote['user'][0]['totalSequence1User'] = $totalSequence1User;
                    $tabNote['user'][0]['totalSequence2User'] = $totalSequence2User;
                    $tabNote['user'][0]['totalSequence3User'] = $totalSequence3User;
                    $tabNote['user'][0]['totalSequence4User'] = $totalSequence4User;
                    $tabNote['user'][0]['totalSequence5User'] = $totalSequence5User;
                    $tabNote['user'][0]['totalSequence6User'] = $totalSequence6User;
                    $tabNote['user'][0]['totalSequence7User'] = $totalSequence7User;
                    $tabNote['user'][0]['totalSequence8User'] = $totalSequence8User;
                    $tabNote['user'][0]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                }

            }else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['totalNoteMax'] = $total_notemax_assessment;
                    $tabNote['user'][0]['totalSequence1User'] = $totalSequence1User;
                    $tabNote['user'][0]['totalSequence2User'] = $totalSequence2User;
                    $tabNote['user'][0]['totalSequence3User'] = $totalSequence3User;
                    $tabNote['user'][0]['totalSequence4User'] = $totalSequence4User;
                    $tabNote['user'][0]['totalSequence5User'] = $totalSequence5User;
                    $tabNote['user'][0]['totalSequence6User'] = $totalSequence6User;
                    $tabNote['user'][0]['totalSequence7User'] = $totalSequence7User;
                    $tabNote['user'][0]['totalSequence8User'] = $totalSequence8User;
                    $tabNote['user'][0]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                }


            }else if(!empty($request['idTrimestre'])){

            }else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][$i]['matterGroup'] = $matterGroup;

                    $totalSequence1User = null;
                    $totalSequence2User = null;
                    $totalSequence3User = null;
                    $totalSequence4User = null;
                    $totalSequence5User = null;
                    $totalSequence6User = null;
                    $totalSequence7User = null;
                    $totalSequence8User = null;

                    for ($j=0; $j < $matterGroup->count(); $j++) {
                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->where('matter_group.id',$matterGroup[$j]['id'])
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'] = $assessment;

                        $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->sum('assessments.notemax');

                        for ($k=0; $k < $assessment->count(); $k++) {
                            $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
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
                                //$total_matiere = $total_matiere + 1;
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

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                    $total = null;

                                    for ($n=0; $n < $assessmentType->count(); $n++) {
                                        $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                            ->join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->join('matter','matter.id','=','ratings.idMatter')
                                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                            ->where('assessment_type.id',$assessmentType[$n]['id'])
                                            ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->first();


                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                        if(!empty($ratings['value'])){
                                            $total = $total + $ratings['value'];
                                            $rating_exits = $rating_exits + 1;

                                            if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                                switch ($assessmentType[$n]['id']) {
                                                    case 1:
                                                        $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 2:
                                                        $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 3:
                                                        $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 4:
                                                        $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 5:
                                                        $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 6:
                                                        $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 7:
                                                        $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 8:
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

                    if($total_notemax_assessment != 0){
                        $tabNote['user'][$i]['totalNoteMax'] = $total_notemax_assessment;
                        $tabNote['user'][$i]['totalSequence1User'] = $totalSequence1User;
                        $tabNote['user'][$i]['totalSequence2User'] = $totalSequence2User;
                        $tabNote['user'][$i]['totalSequence3User'] = $totalSequence3User;
                        $tabNote['user'][$i]['totalSequence4User'] = $totalSequence4User;
                        $tabNote['user'][$i]['totalSequence5User'] = $totalSequence5User;
                        $tabNote['user'][$i]['totalSequence6User'] = $totalSequence6User;
                        $tabNote['user'][$i]['totalSequence7User'] = $totalSequence7User;
                        $tabNote['user'][$i]['totalSequence8User'] = $totalSequence8User;
                        $tabNote['user'][$i]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                    }
                }

                /******************************************************Debut calcul rang ********************************************/

                // Tableau des séquences
                $sequences = ['moyenneSequence1', 'moyenneSequence2', 'moyenneSequence3', 'moyenneSequence4', 'moyenneSequence5', 'moyenneSequence6', 'moyenneSequence7', 'moyenneSequence8'];

                // Tableau associatif pour stocker les rangs pour chaque séquence
                $rangsParSequence = [];

                // Boucle sur chaque séquence
                foreach ($sequences as $sequence) {
                    // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                    $moyennes = [];
                    foreach ($tabNote['user'] as $userId => $user) {
                        $moyennes[$userId] = $user[$sequence];
                    }

                    // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                    arsort($moyennes);

                    // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                    $rangs = [];
                    $rank = 1;
                    foreach ($moyennes as $userId => $moyenne) {
                        $rangs[$userId] = $rank;
                        $rank++;
                    }

                    // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                    foreach ($tabNote['user'] as $userId => &$user) {
                        $user['rang_'.$sequence] = $rangs[$userId];
                    }

                    // Stocker les rangs dans le tableau global
                    $rangsParSequence[$sequence] = $rangs;
                }

                // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément




                /******************************************************fin calcul rang ********************************************/
            }


            $pdf = Pdf::loadView('home',compact('tabNote'));
            return $pdf->download('bulletin.pdf');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function imprimerbulletinSecondaireFrancophone(Request $request){
        ini_set('max_execution_time', 300); // Augmente la limite à 300 secondes (5 minutes)
        //ini_set('xdebug.max_nesting_level', 512);



        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

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
            $tabNote['vide'] = 0;
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                $matterGroup = null;

                if(!empty($request['idOptionLevel'])){
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                        ->orderBy("id", "asc")
                        ->get();
                }else{
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->orderBy("id", "asc")
                        ->get();
                }


                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / ($total_notemax_assessment-20));
                }

            }else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                $matterGroup = null;

                if(!empty($request['idOptionLevel'])){
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                        ->orderBy("id", "asc")
                        ->get();
                }else{
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                        ->where('matter_group.idSchool',$request['idSchool'])
                        ->where('matter_group.idSection',$request['idSection'])
                        ->orderBy("id", "asc")
                        ->get();
                }

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['moyenneSequence1'] = (($totalSequence1User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence2'] = (($totalSequence2User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence3'] = (($totalSequence3User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence4'] = (($totalSequence4User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence5'] = (($totalSequence5User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence6'] = (($totalSequence6User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence7'] = (($totalSequence7User * 20) / ($total_notemax_assessment-20));
                    $tabNote['user'][0]['moyenneSequence8'] = (($totalSequence8User * 20) / ($total_notemax_assessment-20));
                }


            }else if(!empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                $moyClasse = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
                        ->where('id',$request['idTrimestre'])
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
                    $totalCoefTrim = null;

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
                        ->get();

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'] = $assessmentType;

                    for ($k=0; $k < $assessmentType->count(); $k++) {

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

                        /*
                            $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                                ->join('modules','modules.idTeacher','=','users.id')
                                                ->join('progressions','progressions.id','=','modules.idProgression')
                                                ->where('progressions.idClasse',$request['idClasse'])
                                                ->get();
                            */

                        //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                        //$total_matiere = $total_matiere + 1;
                        $rating_exits = null;
                        $matterGroup = null;

                        if(!empty($request['idOptionLevel'])){
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                                ->orderBy("id", "asc")
                                ->get();
                        }else{
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->orderBy("id", "asc")
                                ->get();
                        }

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                        $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                            ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                            ->join('ratings','ratings.idAssessment','=','assessments.id')
                            ->where('assessment_type.id', $assessmentType[$k]['id'])
                            ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                            ->whereNotNull('ratings.value')
                            ->get();
                        /*
                                Rating::selectRaw('SUM(coefficients.value) as coefficient_sum')
                                                            ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                                            ->join('coefficients', 'ratings.idCoeficient', '=', 'coefficients.id')
                                                            ->where('assessment_type.id', $assessmentType[$k]['id'])
                                                            ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                                                            ->whereNotNull('ratings.value')
                                                            ->get();
                                                            */
                        switch ($assessmentType[$k]['id']) {
                            case 1:
                                $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 2:
                                $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 3:
                                $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 4:
                                $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 5:
                                $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 6:
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
                                ->where('assessment_type.id',$assessmentType[$k]['id'])
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'] = $assessment;
                            $total = null;

                            for ($n=0; $n < $assessment->count(); $n++) {

                                $teachername = User::select('users.name as teacherName')
                                    ->join('assessments','assessments.idTeacher','=','users.id')
                                    ->where('assessments.id',$assessment[$n]['id'])
                                    ->get();


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
                                    ->where('assessment_type.id',$assessmentType[$k]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();




                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                                if(!empty($teachername)){
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                                }

                                /*
                                        for($p=0; $p < $teachername->count(); $p++) {
                                            if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                            }
                                        }
                                        */

                                if(!empty($ratings['coefficient'])){
                                    $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                                }

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];


                                    if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                        switch ($assessmentType[$k]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
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
                            $MatterGroupId = $matterGroup[$x]['id'] ;
                            switch ($matterGroup[$x]['id']) {
                                case $MatterGroupId:
                                    if($totalCoefMatterGroup1 != 0){
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                        $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2));
                                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                        $totalSeq = $totalSeq + $total;
                                        $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                    }

                                    break;
                            }
                        }//MatterGroup boucle fin*******************************************************************



                        if(!empty($rating_exits) && $rating_exits != 0){
                            //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                            //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                            //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                        }else{
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['total_trimestre'] = null;
                        }




                        //} *************************************************************** ici ***********************************************
                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequence'] = $totalSeq;
                        switch ($assessmentType[$k]['id']) {
                            case 1:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq1 = floatval($cleanNumber);
                                }
                                $totalSequence1User = $totalSequence1User + $totalSequence1;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq1;
                                break;
                            case 2:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq2 = floatval($cleanNumber);
                                }
                                $totalSequence2User = $totalSequence2User + $totalSequence2;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq2;
                                break;
                            case 3:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq3 = floatval($cleanNumber);
                                }
                                $totalSequence3User = $totalSequence3User + $totalSequence3;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq3;
                                break;
                            case 4:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq4 = floatval($cleanNumber);
                                }
                                $totalSequence4User = $totalSequence4User + $totalSequence4;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq4;
                                break;
                            case 5:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq5 = floatval($cleanNumber);
                                }
                                $totalSequence5User = $totalSequence5User + $totalSequence5;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq5;
                                break;
                            case 6:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                    $moyseq6 = floatval($cleanNumber);
                                }
                                $totalSequence6User = $totalSequence6User + $totalSequence6;
                                $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                                $moyClasse = $moyClasse + $moyseq6;
                                break;
                        }



                        //methode avec deux sequences par trimestre

                        /*
                            switch ($trimestre[$j]['id']) {
                                case '1':
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                    break;
                                case '2':
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                    break;
                                case '3':
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                    break;
                            }
                            */

                    }

                    $santion = Sanction::where('idUser',$entete[$i]['id'])
                        ->count();

                    $absence = Absence::where('idStudent',$entete[$i]['id'])
                        ->count();

                    //bonne moyenne 1
                    switch ($trimestre[0]['id']) {
                        case 1:
                            if($totalCoef1 != 0 && $totalCoef2 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                                if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq1 + $moyseq2)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case 2:
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

                        case 3:
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

                if($effectifClasse != 0){
                    $tabNote['moyenneClasse'] = floatval(str_replace(',', '.', number_format(($moyClasse /2) / $effectifClasse,2)));
                }else{
                    $tabNote['moyenneClasse'] = null;
                }

                /******************************************************Debut calcul rang ********************************************/
                for ($i = 0; $i < $entete->count(); $i++) {
                    // ... Autres calculs ...

                    // Calcul du rang par trimestre
                    $rangementsTrimestre = [];
                    foreach ($tabNote['user'] as $key => $value) {
                        $rangementsTrimestre[$key] = $value['trimestre'][0]['moyenneTrimestre'];
                    }

                    // Triez les moyennes en ordre décroissant et conservez les clés associatives
                    arsort($rangementsTrimestre);

                    // Attribuez le rang à chaque moyenne
                    $rang = 1;
                    $previousMoyenne = null;
                    foreach ($rangementsTrimestre as $key => $moyenne) {
                        if ($moyenne !== $previousMoyenne) {
                            $previousMoyenne = $moyenne;
                            $rangementsTrimestre[$key] = $rang;
                        } else {
                            $rangementsTrimestre[$key] = $rang;
                        }
                        $rang++;
                    }

                    // Affectez le rang à l'utilisateur actuel
                    $tabNote['user'][$i]['trimestre'][0]['rangTrimestre'] = $rangementsTrimestre[$i] ?? null;

                    // ... Autres calculs ...
                }

                //calculer le rang par sequence
                for ($i = 0; $i < count($tabNote['user']); $i++) {
                    for ($j = 0; $j < count($tabNote['user'][$i]['trimestre'][0]['assessmentType']); $j++) {
                        $currentMoyenne = $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$j]['moyenne'];
                        $rank = 1;

                        for ($k = 0; $k < count($tabNote['user']); $k++) {
                            if ($k != $i) {
                                $compareMoyenne = $tabNote['user'][$k]['trimestre'][0]['assessmentType'][$j]['moyenne'];
                                if ($compareMoyenne > $currentMoyenne) {
                                    $rank++;
                                } elseif ($compareMoyenne == $currentMoyenne) {
                                    // En cas d'égalité, le rang est le même
                                    $rank = $tabNote['user'][$k]['trimestre'][0]['assessmentType'][$j]['rang'];
                                }
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$j]['rang'] = $rank;
                    }
                }



                /******************************************************fin calcul rang ********************************************/

            }else if(!empty($request['idAssessmentType'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                $moyClasse = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


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

                        if(!empty($request['idOptionLevel'])){
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                                ->orderBy("id", "asc")
                                ->get();
                        }else{
                            $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                ->where('matter_group.idSchool',$request['idSchool'])
                                ->where('matter_group.idSection',$request['idSection'])
                                ->orderBy("id", "asc")
                                ->get();
                        }

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'] = $matterGroup;

                        $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                            ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                            ->join('ratings','ratings.idAssessment','=','assessments.id')
                            ->where('assessment_type.id', $assessmentType[0]['id'])
                            ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                            ->whereNotNull('ratings.value')
                            ->get();

                        switch ($assessmentType[0]['id']) {
                            case 1:
                                $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 2:
                                $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 3:
                                $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 4:
                                $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 5:
                                $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                                break;
                            case 6:
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
                                ->orderBy("id", "asc")
                                ->get();

                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'] = $assessment;
                            $total = null;

                            for ($n=0; $n < $assessment->count(); $n++) {

                                $teachername = User::select('users.name as teacherName')
                                    ->join('assessments','assessments.idTeacher','=','users.id')
                                    ->where('assessments.id',$assessment[$n]['id'])
                                    ->get();


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
                                    ->where('assessment_type.id',$assessmentType[0]['id'])
                                    ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                    ->first();




                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                                if(!empty($teachername)){
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                                }

                                if(!empty($ratings['coefficient'])){
                                    $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                                }

                                if(!empty($ratings['value'])){
                                    $total = $total + $ratings['value'];
                                    $rating_exits = $rating_exits + 1;
                                    $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];


                                    if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                        switch ($assessmentType[0]['id']) {
                                            case 1:
                                                $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                break;
                                            case 2:
                                                $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                break;
                                            case 3:
                                                $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                break;
                                            case 4:
                                                $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                break;
                                            case 5:
                                                $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                break;
                                            case 6:
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
                            $MatterGroupId = $matterGroup[$x]['id'] ;
                            switch ($matterGroup[$x]['id']) {
                                case $MatterGroupId:
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                    $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                    $totalSeq = $totalSeq + $total;
                                    $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                    break;
                                /*
                                            case 2:
                                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup2;
                                                $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup2 / $totalCoefMatterGroup2,2));
                                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                                break;
                                                */
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
                        switch ($assessmentType[0]['id']) {
                            case 1:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq1 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq1;
                                }
                                break;
                            case 2:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq2 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq2;
                                }
                                break;
                            case 3:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq3 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq3;
                                }
                                break;
                            case 4:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq4 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq4;
                                }
                                break;
                            case 5:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq5 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq5;
                                }
                                break;
                            case 6:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                                if($totalCoefSeq != 0){
                                    $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                    $moyseq6 = floatval($cleanNumber);
                                    $moyClasse = $moyClasse + $moyseq6;
                                }
                                break;
                        }



                        switch ($assessmentType[0]['id']) {
                            case 1:
                                $totalSequence1User = $totalSequence1User + $totalSequence1;
                                break;
                            case 2:
                                $totalSequence2User = $totalSequence2User + $totalSequence2;
                                break;
                            case 3:
                                $totalSequence3User = $totalSequence3User + $totalSequence3;
                                break;
                            case 4:
                                $totalSequence4User = $totalSequence4User + $totalSequence4;
                                break;
                            case 5:
                                $totalSequence5User = $totalSequence5User + $totalSequence5;
                                break;
                            case 6:
                                $totalSequence6User = $totalSequence6User + $totalSequence6;
                                break;
                        }



                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        //bonne moyenne 1
                        switch ($trimestre[0]['id']) {
                            case 1:
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

                            case 2:
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

                            case 3:
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

            }else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {


                    $trimestre = Trimestre::select('id','name')
                        ->where('idSchool',$request['idSchool'])
                        ->where('idSection',$request['idSection'])
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

                    $totalCoef = null ;
                    $totaltermAv = null ;

                    for ($j=0; $j < $trimestre->count(); $j++) {

                        $assessmentType = AssessmentType::select('id','name')
                            ->where('idSchool',$request['idSchool'])
                            ->where('idSection',$request['idSection'])
                            ->where('idTrimestre',$trimestre[$j]['id'])
                            ->get();

                        $tabNote['user'][$i]['trimestre'][$j]['assessmentType'] = $assessmentType;

                        for ($k=0; $k < $assessmentType->count(); $k++) {

                            $totalSequence1 = null;
                            $totalSequence2 = null;
                            $totalSequence3 = null;
                            $totalSequence4 = null;
                            $totalSequence5 = null;
                            $totalSequence6 = null;
                            $totalNoteCoef = null;
                            $total = null;
                            $coefficient = null;

                            $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                ->join('modules','modules.idTeacher','=','users.id')
                                ->join('progressions','progressions.id','=','modules.idProgression')
                                ->where('progressions.idClasse',$request['idClasse'])
                                ->get();

                            //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                            //$total_matiere = $total_matiere + 1;
                            $rating_exits = null;
                            $matterGroup = null;

                            if(!empty($request['idOptionLevel'])){
                                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                    ->where('matter_group.idSchool',$request['idSchool'])
                                    ->where('matter_group.idSection',$request['idSection'])
                                    ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                                    ->orderBy("id", "asc")
                                    ->get();
                            }else{
                                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                                    ->where('matter_group.idSchool',$request['idSchool'])
                                    ->where('matter_group.idSection',$request['idSection'])
                                    ->orderBy("id", "asc")
                                    ->get();
                            }

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                            for ($x=0; $x < $matterGroup->count(); $x++) {
                                $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                                    ->join('matter','matter.id','=','assessments.idMatter')
                                    ->where('assessments.idSchool',$request['idSchool'])
                                    ->where('assessments.idSection',$request['idSection'])
                                    ->where('assessments.idClasse',$request['idClasse'])
                                    ->orderBy("id", "asc")
                                    ->get();

                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'] = $assessment;
                                $total = null;

                                for ($n=0; $n < $assessment->count(); $n++) {


                                    $coefficient = Rating::select('coefficients.value as coefficient')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                        ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->first();

                                    if(!empty($coefficient)){
                                        $totalCoef = $totalCoef + $coefficient['coefficient'];
                                    }else{
                                        $totalCoef = $totalCoef + 0;
                                    }

                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter','coefficients.value as coefficient',DB::raw(('(ratings.value * coefficients.value) as noteCoef')))
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('coefficients','ratings.idCoeficient','=','coefficients.id')
                                        ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$k]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->first();


                                    $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;


                                    for($p=0; $p < $teachername->count(); $p++) {
                                        if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                        }
                                    }
                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;
                                        $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                        if($assessment[$n]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$k]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }

                                    }

                                    $totaltermAv = $totaltermAv + $total;


                                }
                            }



                            if(!empty($rating_exits) && $rating_exits != 0){
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                                //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                                //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total_trimestre'] = null;
                            }




                            //} *************************************************************** ici ***********************************************

                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence'] = $total;
                            if(!empty($coefficient)){
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*$coefficient['coefficient'];
                            }else{
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequenceCoef'] = $total*1;
                            }

                            if($totalCoef != 0){
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['moyenne'] = $totalNoteCoef / $totalCoef;
                            }

                            //methode avec deux sequences par trimestre

                            /*
                        switch ($trimestre[$j]['id']) {
                            case '1':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                                break;
                            case '2':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                                break;
                            case '3':
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                                $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                                break;
                        }
                        */

                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            $totalSequence6User = $totalSequence6User + $totalSequence6;

                        }

                        $santion = Sanction::where('idUser',$entete[$i]['id'])
                            ->count();

                        $absence = Absence::where('idStudent',$entete[$i]['id'])
                            ->count();

                        if($totalCoef != 0){
                            $tabNote['user'][$i]['trimestre'][$j]['totalCoef'] = $totalCoef;
                            $tabNote['user'][$i]['trimestre'][$j]['total'] = $totaltermAv;
                            //bonne moyenne 1
                            switch ($trimestre[$j]['id']) {
                                case 1:
                                    if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence1User / $totalCoef)+($totalSequence2User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 2:
                                    if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence3User / $totalCoef)+($totalSequence4User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;

                                case 3:
                                    if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = (($totalSequence5User / $totalCoef)+($totalSequence6User / $totalCoef))/2;
                                    }else{
                                        $tabNote['user'][$i]['trimestre'][$j]['moyenneTrimestre'] = null;
                                    }
                                    break;
                            }
                        }

                        $tabNote['user'][$i]['trimestre'][$j]['totalAbs'] = $absence;
                        $tabNote['user'][$i]['trimestre'][$j]['totalPunishment'] = $santion;

                    }


                }

                /******************************************************Debut calcul rang ********************************************/




                /******************************************************fin calcul rang ********************************************/
            }


            $pdf = Pdf::loadView('bulletin/bulletinsecondairefrancophoneSeq',compact('tabNote'));
            //return $pdf->stream();
            //$pdf = Pdf::loadView('home',compact('tabNote'));
            return $pdf->download('bulletinsecondairefrancophone.pdf');
            //return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function genererZipBulletinsSecondaireFrancophone(Request $request)
    {
        ini_set('max_execution_time', 300);
        $infosBulletins = $this->bulletinSecondaireFrancophone($request)->getData();

        try {
            if($infosBulletins->success != true || $infosBulletins->data->effectifClasse == 0){
                return $this->sendResponse("", "Nothing to do");
            }

            $liensBulletins = [];

            $json_data = $infosBulletins->data;

            $zip_file = "Bulletins-".date("y-m-d-h-i-s").".zip";

            $zip = new \ZipArchive();
            $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $cle = Key::where('route', $request['route'])->first();

            for ($case = 0; $case < $json_data->effectifClasse; $case++){

                $data = [
                    'effectifClasse' => $json_data->effectifClasse,
                    'user' => $json_data->user[$case],
                    'moyenneClasse' => $json_data->moyenneClasse,
                    'school_logo' => $cle->logo
                ];

                $filename = Str::slug($json_data->user[$case]->name);

                $dompdf = new Dompdf();

                // Récupérer la vue
                $view = View::make('bulletin.bulletinsecondairefrancophone')->with($data);
                //$view = View::make('receipt')->with($formattedData);

                // Récupérer le contenu de la vue
                $html = $view->render();

                // Charger le contenu HTML dans Dompdf
                $dompdf->loadHtml($html);

                // (Optionnel) Définir la taille et l'orientation du papier
                $dompdf->setPaper('A4', 'portrait');

                // Exécuter le rendu du PDF
                $dompdf->render();

                file_put_contents(public_path("bulletin-$filename.pdf"), $dompdf->output());

                $zip->addFile("bulletin-$filename.pdf");

                $liensBulletins[] = public_path("bulletin-$filename.pdf"); //storage_path("app/tmp/bulletin-trimestre-$filename.pdf");
            }

            $zip->close();

            $this->deletePDFTempFiles($liensBulletins);

            return $this->sendResponse(asset($zip_file), "Bulletins");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function genererBulletinsSecondaireFrancophonePersonnel(GenererBulletinSecondaireFrancophoneRequest $request)
    {
        $idStudent = $request['idStudent'];

        ini_set('max_execution_time', 300);
        $infosBulletins = $this->bulletinSecondaireFrancophone($request)->getData();

        try {
            if($infosBulletins->success != true || $infosBulletins->data->effectifClasse == 0){
                return $this->sendResponse("", "Nothing to do");
            }

            $liensBulletins = [];

            $json_data = $infosBulletins->data;

            $infosBulletins->data->user = collect($infosBulletins->data->user)->filter(function($user) use ($idStudent){
                return $user->id == $idStudent;
            });
            foreach ($infosBulletins->data->user as $key => $user){
                $infosBulletins->data->user = [$user];
            }
            if(count((array)$infosBulletins->data->user) == 0){
                return $this->sendError("idStudent '$idStudent' invalide");
            }

            $cle = Key::where('route', $request['route'])->first();

            $data = [
                'effectifClasse' => $json_data->effectifClasse,
                'user' => $json_data->user[0],
                'moyenneClasse' => $json_data->moyenneClasse,
                'school_logo' => $cle->logo
            ];

            $filename = Str::slug($json_data->user[0]->name);

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('bulletin.bulletinsecondairefrancophone')->with($data);
            //$view = View::make('receipt')->with($formattedData);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            file_put_contents(public_path("pdfs/bulletin-secondaire-francophone-$filename.pdf"), $dompdf->output());

//            $zip->addFile("bulletin-trimestre-$filename.pdf");

            $liensBulletins[] = public_path("pdfs/bulletin-secondaire-francophone-$filename.pdf"); //storage_path("app/tmp/bulletin-trimestre-$filename.pdf");

            return $this->sendResponse(asset("pdfs/bulletin-secondaire-francophone-$filename.pdf"), "Bulletin personnel");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
