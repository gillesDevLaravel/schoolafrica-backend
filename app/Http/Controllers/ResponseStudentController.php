<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponseStudentGetRequest;
use App\Http\Requests\ResponseStudentUpdateRequest;
use App\Http\Requests\Staffs\ResponseStudentAllRequest;
use App\Http\Requests\Staffs\ResponseStudentRequest;
use App\Http\Resources\ResponseStudentGetResource;
use App\Http\Resources\Staffs\ResponseStudentResource;
use App\Models\Assessment;
use App\Models\ExamStudent;
use App\Models\Matter;
use App\Models\Questionnaire;
use App\Models\ResponseUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class ResponseStudentController extends BaseController
{
    /**
     * Récupérer la liste des examens avec la possibilité d'appliquer des filtres
     * @param ResponseStudentGetRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(ResponseStudentGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $responses = ResponseUser::query()
                ->with(['question.assessment.assessmentTypes', 'user', 'question']);

            // Filtres dynamiques
            if (!is_null($request->idAssessmentType)) {
                $responses->whereHas('question.assessment.assessmentTypes', function ($q) use ($request) {
                    $q->where('assessment_type.id', $request->idAssessmentType);
                });
            }

            if (!is_null($request->idAssessment)) {
                $responses->where('idAssessment', $request->idAssessment);
            }

            if (!is_null($request->idUser)) {
                $responses->where('idUser', $request->idUser);
            }

            if (!is_null($request->idQuestion)) {
                $responses->where('idQuestionnaire', $request->idQuestion);
            }

            $assessment_filters = [
                'idClasse' => $request->idClasse,
                'idSchool' => $request->idSchool,
                'idSection' => $request->idSection
            ];
            foreach ($assessment_filters as $column => $value) {
                if (!is_null($value)) {
                    $responses->whereHas('question.assessment', function ($q) use ($column, $value) {
                        $q->where($column, $value);
                    });
                }
            }

            if (!is_null($request->filter_value)) {
                $responses->where(function ($query) use ($request) {
                    $query->where('response', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('note', 'like', '%' . $request->filter_value . '%');
                });
            }

            // Pagination avec Resource Collection
            $paginatedResponses = $responses->paginate($nbreItems, ['*'], 'page', $pageItems);

            return ResponseStudentGetResource::collection($paginatedResponses);

        } catch (\Exception $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
    /**
     * Enregistre les réponses d'un étudiant pour un examen.
     *
     * @param ResponseStudentRequest $request Les données de la requête validées.
     * @return \Illuminate\Http\JsonResponse Réponse JSON avec un message de succès ou une erreur.
     */
    public function store(ResponseStudentRequest $request) {

        try {
            // Vérification que l'utilisateur a commencé l'examen et n'a pas déjà soumis de réponse
            $exam = ExamStudent::where("idAssessment", $request["idAssessment"])
                ->where("idAssessmentType", $request["idAssessmentType"])
                ->where("idUser", auth()->user()->id)
                ->where("statut", "valid")
                ->get();

            if (count($exam) !== 1) {
                return $this->sendError("Réponse inacceptable car l'examen n'a pas été démarré dans les normes");
            }

            if($exam->where("finished", false) === null){
                return $this->sendError("Impossible d'enregistrer des réponses plusieurs fois pour une même examen");
            }

            // Vérification que l'utilisateur est dans les temps pour l'examen
            $tempsDepart = strtotime($exam->first()["created_at"]);
            $tempsActuel = time();
            $duree = intval(($tempsActuel - $tempsDepart) / 60);

            $evaluation = Assessment::find($request["idAssessment"]);

//            if ($duree > $evaluation["duration"]) {
//                return $this->sendError("Réponse inacceptable car vous avez dépassé la durée de cette évaluation");
//            }

            // Enregistrement des réponses
            $nbrReponsesEnregistrees = 0;

            // Parcours des réponses fournies dans la requête
            foreach ($request["responses"] ?? [] as $response) {
                // Vérification que la question existe et correspond à l'évaluation
                $question = Questionnaire::find($response["idQuestion"]);

                if ($question !== null &&
                    $question["idAssessment"] === $request["idAssessment"] &&
                    $question["idAssessmentType"] === $request["idAssessmentType"]) {

                    // Vérification qu'une réponse unique est enregistrée par question
                    $result = ResponseUser::join("questionnaires", "questionnaires.id", "=", "response_users.idQuestionnaire")
                        ->where("questionnaires.idAssessmentType", $request["idAssessmentType"])
                        ->where("response_users.idAssessment", $request["idAssessment"])
                        ->where("questionnaires.id", $response["idQuestion"])
                        ->where("response_users.idUser", auth()->user()->id)
                        ->get();

                    if ($result->isEmpty() && !is_null($response['response'])) {
                        ResponseUser::create([
                            'idUser' => auth()->user()->id,
                            'idQuestionnaire' => $response["idQuestion"],
                            'idAssessment' => $request['idAssessment'],
                            'response' => $response['response']?? null,
//                        'status' => "valid"
                        ]);

                        $nbrReponsesEnregistrees++;
                    }
                }
            }

            // Marquer l'examen comme terminé
            ExamStudent::where('idAssessment', $request['idAssessment'])
                ->where('idAssessmentType', $request['idAssessmentType'])
                ->where('idUser', auth()->user()->id)
                ->update([
                    'finished' => true
                ]);

            // Retourner un message en fonction des réponses enregistrées
            return $this->sendResponses("Vous avez terminer cette évaluation");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    public function update(ResponseStudentUpdateRequest $request, $id)
    {
        try {

                $response = ResponseUser::find($id);

                if ($response) {
                    $response->response = $request['response'] ?? $response->response;
                    $response->updated_by = auth()->id();
                    $response->save();
                }

            return $this->sendResponses("Les reponses ont été modifiées");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Supprime une réponse d'étudiant.
     *
     * @param int $id L'identifiant de la réponse à supprimer.
     * @return \Illuminate\Http\JsonResponse Réponse JSON avec un message de succès ou une erreur.
     */
    public function trash($id)
    {
        try {
            // Vérification des autorisations
            if (!auth()->user() || !in_array(auth()->user()->getRole()->id, [2])) {
                return $this->sendError("Opération non autorisée");
            }

            // Trouver la réponse et la marquer comme supprimée
            $responseStudent = ResponseUser::findOrFail($id);

            $responseStudent->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true,
            ]);

            return $this->sendResponse([ResponseStudentResource::make($responseStudent)], "Réponse supprimée.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure une réponse d'étudiant supprimée.
     *
     * @param int $id L'identifiant de la réponse à restaurer.
     * @return \Illuminate\Http\JsonResponse Réponse JSON avec un message de succès ou une erreur.
     */
    public function restore($id)
    {
        try {
            // Vérification des autorisations
            if (!auth()->user() || !in_array(auth()->user()->getRole()->id, [2])) {
                return $this->sendError("Opération non autorisée");
            }

            // Trouver la réponse et la restaurer
            $examStudent = ResponseUser::findOrFail($id);

            $examStudent->update([
                'deleted' => false
            ]);

            return $this->sendResponse([], "Réponse restaurée avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
