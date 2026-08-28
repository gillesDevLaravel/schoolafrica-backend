<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\QuestionnaireAllRequest;
use App\Http\Requests\Admin\QuestionnaireStoreRequest;
use App\Http\Resources\Admin\QuestionnaireResource;
use App\Http\Resources\Admin\QuestionnaireSimpResource;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends BaseController
{
    /**
     * Lister les questions d'un examen
     *
     * @param QuestionnaireAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(QuestionnaireAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $idSchool = $request->idSchool;
            $idSection = $request->idSection;
            $idAssessment = $request->idAssessment;
            $idAssessmentType = $request->idAssessmentType;
            $order = $request->order ?? true;

            $pages = Questionnaire::select('questionnaires.*');

            if(!is_null($request->idSchool)) {
                $pages = $pages
                    ->join('assessments', 'assessments.id', '=', 'questionnaires.idAssessment')
                    ->where('assessments.idSchool', $idSchool)
                    ->when(!is_null($request['idSection']), function($query) use ($request) {
                        $query->where('idSection', $request['idSection']);
                    });
            }

            if(!is_null($request->idAssessment)) $pages = $pages->where('idAssessment', $idAssessment);
            if(!is_null($request->idAssessmentType)) $pages = $pages->where('idAssessmentType', $idAssessmentType);

            if(!is_null($filter_value)){
                $pages->where(function($query) use ($filter_value) {
                    $query->where('questionnaires.intitule', 'like', "%$filter_value%");
//                        ->orWhere('reponse', 'like', "%$filter_value%");
                });
            }

            // si on veut récupérer les questions dans un ordre complétement aléatoire
            if(!$order) $pages = $pages->inRandomOrder();

            $returnData = $pages
                ->orderBy('questionnaires.id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            // On retourne l'objet sans réponse si c'est un student
            if(auth()->user()->getRole()->id === 8){
                return QuestionnaireSimpResource::collection($returnData);
            }else{
                return QuestionnaireResource::collection($returnData);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une question
     *
     * @param $idQuestionnaire
     * @return QuestionnaireResource|QuestionnaireSimpResource|\Illuminate\Http\JsonResponse
     */
    public function show($idQuestionnaire)
    {
        try {
            $question = Questionnaire::findOrFail($idQuestionnaire);

            if(auth()->user()->getRole()->id === 8){
                return QuestionnaireSimpResource::make($question);
            }else{
                return QuestionnaireResource::make($question);
            }
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une question d'examen
     *
     * @param QuestionnaireStoreRequest $request
     * @return QuestionnaireResource
     */
    public function store(QuestionnaireStoreRequest $request)
    {
        try {
            $questionnaire = Questionnaire::updateOrCreate([
                'idAssessment' => $request->idAssessment,
                'idAssessmentType' => $request->idAssessmentType,
                'intitule' => $request->intitule,
            ], [
                'reponse' => $request->reponse,
                'notemax' => $request->notemax,
            ]);

            return QuestionnaireResource::make($questionnaire);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une question d'examen
     *
     * @param QuestionnaireStoreRequest $request
     * @param $id
     * @return QuestionnaireResource|\Illuminate\Http\JsonResponse
     */
    public function update(QuestionnaireStoreRequest $request, $id)
    {
        try {
            $questionnaure = Questionnaire::findOrFail($id);

            $questionnaure->update([
                'idAssessment' => $request->idAssessment ?? $questionnaure->idAssessment,
                'idAssessmentType' => $request->idAssessmentType ?? $questionnaure->idAssessmentType,
                'intitule' => $request->intitule ?? $questionnaure->intitule,
                'reponse' => $request->reponse ?? $questionnaure->reponse,
                'notemax' => $request->notemax ?? $questionnaure->notemax,
                'updated_by' => auth()->user()->id,
            ]);

            return QuestionnaireResource::make($questionnaure);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer une question à la corbeille
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash($id)
    {
        if(auth()->user()->getRole()->id === 8){
            return $this->sendError("Non autorisé", [], 403);
        }

        try {
            $pageLivre = Questionnaire::findOrFail($id);

            $pageLivre->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return $this->sendResponse([], "Question supprimée avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une question de la corbeille
     * NB: Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return QuestionnaireResource|\Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        if(auth()->user()->getRole()->id === 8){
            return $this->sendError("Non autorisé", [], 403);
        }

        try {
            $pageLivre = Questionnaire::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $pageLivre->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);

            return QuestionnaireResource::make($pageLivre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
