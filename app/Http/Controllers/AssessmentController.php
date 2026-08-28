<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\DuplicateAssessmentRequest;
use App\Models\Classes;
use App\Models\Matter;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Http\Requests\Staffs\AssessmentRequest;
use App\Http\Requests\Staffs\AssessmentGetAllRequest;
use App\Http\Resources\Staffs\AssessmentResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Assessment
 */
class AssessmentController extends BaseController
{
    /**
     * Lister les assessments (Evaluations)
     *
     * @param AssessmentGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(AssessmentGetAllRequest $request)
    {
        try {
            $assessment  = $request->validated();
            $idAssessmentType = $request['idAssessmentType'] ?? null;
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idMatter = $request['idMatter'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;
            $is_qcm = $request['is_qcm'] ?? null;
            $date = $request['date'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $assessments = Assessment::query();

            if(!is_null($idSchool)) $assessments = $assessments->where('assessments.idSchool',$assessment['idSchool']);
            if(!is_null($idSection)) $assessments = $assessments->where('assessments.idSection',$assessment['idSection']);
            if(!is_null($date)){
                // Vérifier si la date est déjà au format Y-m-d
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    // Si ce n'est pas le bon format, formater la date
                    $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                } else {
                    // Si c'est déjà au bon format, on garde la date telle quelle
                    $formattedDate = $date;
                }

                $assessments = $assessments->where('assessments.date', $formattedDate);
            }

            if(!empty($request['idAssessmentType']) && !empty($request['idClasse']) && !empty($request['idTeacher'])){
                $assessments = $assessments->select('assessments.id as id','assessments.idCoeficient as idCoeficient','assessments.hour as hour','assessments.duration as duration','assessments.day as day','assessments.date as date','assessments.idSchool as idSchool','assessments.idSection as idSection','assessments.idClasse as idClasse','assessments.idTeacher as idTeacher','assessments.idMatter as idMatter')
                    ->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                    ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
//                        ->where('assessments.idSchool',$assessment['idSchool'])
//                        ->where('assessments.idSection',$assessment['idSection'])
                    ->where('assessments.idClasse',$request['idClasse'])
                    ->where('assessment_type.id',$request['idAssessmentType'])
                    ->where('assessments.idTeacher',$request['idTeacher']);
            }
            else if(!empty($request['idTeacher']) && !empty($request['idClasse'])){
                $assessments = $assessments->where('idClasse',$request['idClasse'])
                    ->where('idTeacher',$request['idTeacher']);
            }
            else if(!empty($request['idAssessmentType']) && !empty($request['idClasse'])){
                $assessments = $assessments->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                    ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                    ->where('assessments.idClasse',$request['idClasse'])
                    ->where('assessment_type.id',$request['idAssessmentType']);

            }
            else if($idAssessmentType != null){
                $assessments = $assessments->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                    ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                    ->where('assessment_type.id',$request['idAssessmentType']);
            }

            if($idClasse != null){
                $assessments = $assessments->where('idClasse',$request['idClasse']);
            }
            if($idTeacher != null){
                $assessments = $assessments->where('idTeacher',$request['idTeacher']);
            }
            if($idMatter != null){
                $assessments = $assessments->where('idMatter',$request['idMatter']);
            }
            if($idOptionLevel != null){
                $assessments
                    ->join('matter','matter.id','=','assessments.idMatter')
                    ->where('matter.idOptionLevel',$idOptionLevel);
            }

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $assessments->where(function($query) use ($filter_value) {
                    $query
                        ->orwhereHas('classe', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('matter', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('teacher', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            if($is_qcm != null) $assessments = $assessments->where('is_qcm',$request['is_qcm']);

            return AssessmentResource::collection(
                $assessments
                    ->select('assessments.*')
//                    ->select('assessments.id as id','assessments.idCoeficient as idCoeficient','assessments.hour as hour','assessments.duration as duration','assessments.day as day','assessments.date as date','assessments.idSchool as idSchool','assessments.idSection as idSection','assessments.idClasse as idClasse','assessments.idTeacher as idTeacher','assessments.idMatter as idMatter')
                    ->orderBy("assessments.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );


        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function formatingErrorForExistingAssessments($existingAssessments){
        $formatingMessage = "";
        foreach ($existingAssessments as $existingAssessment){
            $assessmentTypesNames = $existingAssessment->pluck('assessmentTypes') // Récupérer les types d'évaluation
            ->flatten() // Aplatir la collection
            ->pluck('name') // Extraire uniquement les noms
            ->unique() // Supprimer les doublons
            ->implode(','); // Joindre les noms avec "séquence(s)"

            $formatingMessage .= Matter::find($existingAssessment[0]['idMatter'])->name . ' -> ' . __('assessments.assessment_type') . " ($assessmentTypesNames)\n";
        }

        return $formatingMessage;
    }

    /**
     * Créer un nouvel assessment (évaluation)
     *
     * @param AssessmentRequest $request
     * @return AssessmentResource|\Illuminate\Http\Response
     */
    public function store(AssessmentRequest $request)
    {
        try {
            $existingAssessments = [];
            foreach ($request->assessments as $assess) {
                $classe = Classes::find($assess['idClasse']);

                $foundAssessments = Assessment::where("idClasse", $assess['idClasse'])
                    ->where("idMatter", $assess['idMatter'])
                    ->whereHas('assessmentTypes', function ($query) use ($assess) {
                        $query->whereIn('assessment_type.id', $assess['assessmentTypes']);
                    })
                    ->with('assessmentTypes') // Récupérer les types d'évaluations associés
                    ->get();

                if ($foundAssessments->isNotEmpty()) {
                    $existingAssessments[] = $foundAssessments;
                }
                else{
                    $assessment = Assessment::create([
                        'hour' => $assess['hour'] ?? null,
                        'libelle' => $assess['libelle'] ?? null,
                        'duration' => $assess['duration'] ?? null,
                        'day' => $assess['day'] ?? null,
                        'notemax' => $assess['notemax'] ?? null,
                        'oral' => $assess['oral'] ?? null,
                        'idCoeficient' => $assess['idCoeficient'] ?? 1,
                        'orale' => $assess['orale'] ?? null,
                        'ecrit' => $assess['ecrit'] ?? null,
                        'written' => $assess['written'] ?? null,
                        'attitude' => $assess['attitude'] ?? null,
                        'savoir_etre' => $assess['savoir_etre'] ?? null,
                        'pratical' => $assess['pratical'] ?? null,
                        'pratique' => $assess['pratique'] ?? null,
                        'percentage' => $assess['percentage'] ?? null,
                        'date' => $assess['date'] ?? null,
                        'idMatter' => $assess['idMatter'] ?? null,
                        'idClasse' => $assess['idClasse'] ?? null,
                        'idTeacher' => $assess['idTeacher'] ?? null,
                        'is_qcm' => $assess['is_qcm'] ?? false,
                        'idSchool' => $classe->idSchool,
                        'idSection' => $classe->idSection,
                        'created_by' => auth()->user()->id,
                    ]);

                    if(!empty($assess['typeevaluations'])){
                        $assessment->typeEvaluations()->sync($assess['typeevaluations']);
                    }

                    if(!empty($assess['assessmentTypes'])){
                        $assessment->assessmentTypes()->sync($assess['assessmentTypes']);
                    }
                }
            }

            if (!empty($existingAssessments)){
                $message = __('assessments.existing_assessment_error') . $this->formatingErrorForExistingAssessments($existingAssessments);
                return $this->sendError($message);
            }

            return $this->sendResponse([], 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function duplicateAssessment(DuplicateAssessmentRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $duplicatedassessments = [];
                if (!empty($request['assessments_id'])) {
                    $assessmentIds = $request['assessments_id'];
                    sort($assessmentIds);

//                    dd($assessmentIds);
                    $existingAssessments = [];

                    foreach ($assessmentIds as $assessmentId) {

                        $originalAssessment = Assessment::findOrFail($assessmentId);

                        // Récupération des séquences de l'évaluation originale
                        $originalAssessmentTypeIds = $originalAssessment->assessmentTypes->pluck('id')->toArray();

                        // Si l'appel ne fournit pas d'idAssessmentTypes, on utilisera ceux de l'original
                        $typesToCheck = !empty($request->idAssessmentTypes) ? $request->idAssessmentTypes : $originalAssessmentTypeIds;

                        // Empêcher les évaluations dupliquées pour la même matière et même(s) séquence(s)
                        $foundAssessments = Assessment::where('idClasse', $request->idClasse)
                            ->where('idMatter', $originalAssessment->idMatter)
                            ->whereHas('assessmentTypes', function ($query) use ($typesToCheck) {
                                $query->whereIn('assessment_type.id', $typesToCheck);
                            })
                            ->with('assessmentTypes')
                            ->get();

                        if ($foundAssessments->isNotEmpty()) {
                            $existingAssessments[] = $foundAssessments;
                        }
                        else{


                            $classe = Classes::find($request['idClasse']);

                            $assessment = $originalAssessment->replicate();

                            $assessment->idClasse = $request['idClasse'];
                            $assessment->idTeacher = $request['idTeacher'];
                            $assessment->idSchool = $classe->idSchool;
                            $assessment->idSection = $classe->idSection;
                            $assessment->date = $request->date ?? $originalAssessment->date; //PRENDRE LA DATE DE L'ASSESSMENT A DUPLIQUER SI NON FOURNI DANS REQUEST
                            $assessment->created_by = auth()->user()->id;
                            $assessment->save();

                            $originalTypeEvaluationsIds = $originalAssessment->typeEvaluations()->pluck('type_evaluation.id')->toArray();
                            $assessment->typeEvaluations()->sync($originalTypeEvaluationsIds);


                            if(!empty($request->idAssessmentTypes)){
                                $assessment->assessmentTypes()->sync($request->idAssessmentTypes);
                            }
                            else{
                                $originalAssessmentTypeIds = $originalAssessment->assessmentTypes()->pluck('assessment_type.id')->toArray();
                                $assessment->assessmentTypes()->sync($originalAssessmentTypeIds);
                            }

                            $duplicatedassessments[] = $assessment;
                        }
                    }
                }

                if (!empty($existingAssessments)){
                    $message = __('assessments.existing_assessment_error') . $this->formatingErrorForExistingAssessments($existingAssessments);
                    return $this->sendError($message);
                }

                return $this->sendResponse($duplicatedassessments, "Successfully duplicated assessments");
            });
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Afficher les détails d'un assessment
     *
     * @param Assessment $assessment
     * @param $id
     * @return AssessmentResource
     */
    public function show(Assessment $assessment,$id)
    {
        try {
            $assessment = Assessment::find($id);
            return new AssessmentResource($assessment);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un assessment
     * @param Request $request
     * @param Assessment $assessment
     * @param $id
     * @return AssessmentResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $assessment = Assessment::find($id);

            $assessmentTypeIds = $request['assessmentTypes'] ?? $assessment->assessmentTypes->pluck('id')->toArray();

            $foundAssessments = Assessment::where('id', '!=', $id)
                ->where("idClasse", $request['idClasse'] ?? $assessment->idClasse)
                ->where("idMatter", $request['idMatter'] ?? $assessment->idMatter)
                ->whereHas('assessmentTypes', function ($query) use ($assessmentTypeIds) {
                    $query->whereIn('assessment_type.id', $assessmentTypeIds);
                })
                ->with('assessmentTypes') // Récupérer les types d'évaluations associés
                ->get();

            if ($foundAssessments->isNotEmpty()) {
                $message = __('assessments.existing_assessment_error') . $this->formatingErrorForExistingAssessments([$foundAssessments]);
                return $this->sendError($message);
            }

            $classe = Classes::find($request['idClasse']);

            $assessment->hour = $request['hour'] ?? $assessment['hour'];
            $assessment->libelle = $request['libelle'] ?? $assessment['libelle'];
            $assessment->duration = $request['duration'] ?? $assessment['duration'];
            $assessment->day = $request['day'] ?? $assessment['day'];
            $assessment->notemax = $request['notemax'] ?? $assessment['notemax'];
            $assessment->oral = $request['oral'] ?? $assessment['oral'];
            $assessment->orale = $request['orale'] ?? $assessment['orale'];
            $assessment->idCoeficient = $request['idCoeficient'] ?? $assessment['idCoeficient'];
            $assessment->ecrit = $request['ecrit'] ?? $assessment['ecrit'];
            $assessment->written = $request['written'] ?? $assessment['written'];
            $assessment->attitude = $request['attitude'] ?? $assessment['attitude'];
            $assessment->savoir_etre = $request['savoir_etre'] ?? $assessment['savoir_etre'];
            $assessment->pratical = $request['pratical'] ?? $assessment['pratical'];
            $assessment->pratique = $request['pratique'] ?? $assessment['pratique'];
            $assessment->percentage = $request['percentage'] ?? $assessment['percentage'];
            $assessment->is_qcm = $request['is_qcm'] ?? $assessment['is_qcm'];
            $assessment->date = $request['date'] ?? $assessment['date'];
            $assessment->idMatter = $request['idMatter'] ?? $assessment['idMatter'];
            $assessment->idClasse = $request['idClasse'] ?? $assessment['idClasse'];
            $assessment->idTeacher = $request['idTeacher'] ?? $assessment['idTeacher'];
            $assessment->idSchool = $classe->idSchool ?? $assessment['idSchool'];
            $assessment->idSection = $classe->idSection ?? $assessment['idSection'];
            $assessment->updated_by = auth()->user()->id;
            $assessment->save();

            if(!empty($request['typeevaluations'])){
                //TODO: Avant de modifier les types d'evals, on doti s'assurer qu'il n'y a pas de note eux
                $actual_typeEvaluations =  $assessment->typeEvaluations()->pluck('type_evaluation.id')->toArray();
                $new_typeEvaluations = $request['typeevaluations'];

                $typeEvaluations_to_remove = array_diff($actual_typeEvaluations, $new_typeEvaluations);

                if(!empty($typeEvaluations_to_remove)){
                    $typeEvaluation_has_note = array();
                    // Il essaie de retirer une ou plusieurs séquences.. on vérifie qu'il n'y a pas de notes
                    foreach ($typeEvaluations_to_remove as $tmp_typeEvaluation) {
                        $count_ratings_on_assessment_and_assessmentType = Rating::where([
                            'idAssessment' => $assessment->id,
                            'idTypeEvaluation' => $tmp_typeEvaluation,
                            'deleted' => 0
                        ])->count();

                        if($count_ratings_on_assessment_and_assessmentType > 0){
                            $typeEvaluation_has_note[] = $tmp_typeEvaluation;
                        }
                    }

                    if(!empty($typeEvaluation_has_note)){
                        return $this->sendError(__('app.impossible_to_remove_typeEvaluation_on_assessment', ['typeEvaluations' => implode(",", $typeEvaluation_has_note)]), [], 403);
                    }

                }

                // Si on arrive ici, ce qu'il n'essaie pas de retirer un typeEval avec note.
                $assessment->typeEvaluations()->sync($request['typeevaluations']);
            }

            if(!empty($request['assessmentTypes'])){
                //TODO: Avant de modifier les séquences, on doit s'assurer qu'il n'y a pas de note sur eux
                $actual_assessmentTypes =  $assessment->assessmentTypes()->pluck('assessment_type.id')->toArray();
                $new_assessmentTypes = $request['assessmentTypes'];

                $assessmentTypes_to_remove = array_diff($actual_assessmentTypes, $new_assessmentTypes);

                if(!empty($assessmentTypes_to_remove)){
                    $assessmentType_has_note = array();
                    // Il essaie de retirer une ou plusieurs séquences.. on vérifie qu'il n'y a pas de notes
                    foreach ($assessmentTypes_to_remove as $tmp_assessmentType) {
                        $count_ratings_on_assessment_and_assessmentType = Rating::where([
                            'idAssessment' => $assessment->id,
                            'idAssessmentType' => $tmp_assessmentType,
                            'deleted' => 0
                        ])->count();

                        if($count_ratings_on_assessment_and_assessmentType > 0){
                            $assessmentType_has_note[] = $tmp_assessmentType;
                        }
                    }

                    if(!empty($assessmentType_has_note)){
                        return $this->sendError(__('app.impossible_to_remove_assessmentType_on_assessment', ['assessmentTypes' => implode(",", $assessmentType_has_note)]), [], 403);
                    }

                }

                // Si on arrive ici, ce qu'il n'essaie pas de retirer une séquence avec note.
                $assessment->assessmentTypes()->sync($request['assessmentTypes']);
            }

            return new AssessmentResource($assessment);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer les infos d'un assessment
     *
     * @param Assessment $assessment
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Assessment $assessment,$id)
    {
        try {
            $assessment = Assessment::findOrFail($id);
            // On vérifie que y'a pas de notes sur cet assessment

            $existingRatings = Rating::where('idAssessment', $id)->count();

            if($existingRatings !==0){
                return $this->sendError("Impossible car note existante", []);
            }

//            $assessment->delete();
            $assessment->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id,
            ]);

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer plusieurs assessments
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBulk(Request $request)
{
    try {
        // Validation de la requête : on attend un tableau d'IDs
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:assessments,id',
        ]);

        $ids = $request->input('ids');
        $notDeletable = [];

        foreach ($ids as $id) {
            $assessment = Assessment::findOrFail($id);

            // Vérifie s'il existe des notes
            $existingRatings = Rating::where('idAssessment', $id)->count();
            if ($existingRatings !== 0) {
                $notDeletable[] = $id;
                continue;
            }

            // Suppression logique
            $assessment->update([
                'deleted' => true,
                'deleted_by' => auth()->id(),
            ]);
        }

        // Si certains assessments n'ont pas pu être supprimés
        if (!empty($notDeletable)) {
            return $this->sendError(
                "Impossible de supprimer les assessments suivants car note existante",
                $notDeletable
            );
        }

        return $this->sendResponse(null, 'Assessments supprimés avec succès.');

    } catch (\Throwable $th) {
        Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
    }
}

}
