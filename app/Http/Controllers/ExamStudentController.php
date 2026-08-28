<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staffs\ExamStudentAllRequest;
use App\Http\Requests\Staffs\ExamStudentRequest;
use App\Http\Requests\Staffs\ExamStudentsUpdateRequest;
use App\Http\Resources\Staffs\ExamStudentResource;
use App\Models\ExamStudent;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamStudentController extends BaseController
{
    /**
     * Récupère une liste des examens étudiants avec des options de filtrage et de pagination.
     *
     * @param ExamStudentAllRequest $request Requête contenant les paramètres de filtrage et de pagination.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Liste des examens étudiants au format JSON.
     */
    public function index(ExamStudentAllRequest $request) {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $examStudents = ExamStudent::query();
            $examStudents = $examStudents->where("statut", "valid");

            if (!is_null($request["AssessmentType"])) {
                $examStudents = $examStudents->where("AssessmentType", $request["AssessmentType"]);
            }

            if (!is_null($request["Assessment"])) {
                $examStudents = $examStudents->where("Assessment", $request["Assessment"]);
            }

            if (!is_null($request["idUser"])) {
                $examStudents = $examStudents->where("idUser", $request["idUser"]);
            }

            return ExamStudentResource::collection(
                $examStudents->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée un nouvel examen étudiant après vérification des conditions.
     *
     * @param ExamStudentRequest $request Requête contenant les données de l'examen.
     * @return \Illuminate\Http\JsonResponse Réponse indiquant le succès ou l'échec de l'opération.
     */
    public function store(ExamStudentRequest $request) {
        DB::beginTransaction();
        try {
            $result = ExamStudent::lockForUpdate()
                ->where("idAssessment", $request["idAssessment"])
                ->where("idAssessmentType", $request["idAssessmentType"])
                ->where("idUser", auth()->user()->id)
                ->where("statut", "valid")
                ->get();

            if (!$result->isEmpty()) {
                DB::rollBack();
                return $this->sendError("Vous avez déjà effectué cet examen");
            }

            ExamStudent::create([
                'idAssessment' => $request['idAssessment'],
                'idAssessmentType' => $request['idAssessmentType'],
                'idUser' => auth()->user()->id,
                'statut' => "valid"
            ]);

            DB::commit();
            return $this->sendResponse([], "Début de l'examen");
        } catch (Exception $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'un examen étudiant spécifique.
     *
     * @param int $id Identifiant de l'examen étudiant.
     * @return ExamStudentResource|\Illuminate\Http\JsonResponse Détails de l'examen ou erreur.
     */
    public function show($id) {
        try {
            $examStudent = ExamStudent::findOrFail($id);
            return new ExamStudentResource($examStudent);
        } catch (Exception $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met à jour le statut d'un examen étudiant.
     *
     * @param ExamStudentsUpdateRequest $request Requête contenant les nouvelles données.
     * @param int $id Identifiant de l'examen étudiant.
     * @return \Illuminate\Http\JsonResponse Réponse avec le statut mis à jour.
     */
    public function update(ExamStudentsUpdateRequest $request, $id) {
        try {
            $examStudent = ExamStudent::findOrFail($id);

            $examStudent->update([
                'statut' => $examStudent["statut"] === "valid" ? "invalid" : "valid",
                "updated_by" => auth()->user()->id,
            ]);

            $statut = ($examStudent["statut"] == 1)? "revalidé": "annulé";

            return $this->sendResponse([ExamStudentResource::make($examStudent)], "Examen étudiant ". $statut ." avec succès.");
        } catch (Exception $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime un examen étudiant en le marquant comme supprimé.
     *
     * @param int $id Identifiant de l'examen étudiant.
     * @return \Illuminate\Http\JsonResponse Réponse confirmant la suppression.
     */
    public function trash($id)
    {
        try {

            if(!auth()->user() || !in_array(auth()->user()->getRole()->id, [2])){
                return $this->sendError("Operation non autorisée");
            }

            $examStudent = ExamStudent::findOrFail($id);

            $examStudent->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true,
            ]);

            return $this->sendResponse([], "Examen étudiant supprimé avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure un examen étudiant supprimé.
     *
     * @param int $id Identifiant de l'examen étudiant.
     * @return \Illuminate\Http\JsonResponse Réponse confirmant la restauration.
     */
    public function restore($id)
    {
        try {

            if(!auth()->user() || !in_array(auth()->user()->getRole()->id, [2])){
                return $this->sendError("Operation non autorisée");
            }

            $examStudent = ExamStudent::findOrFail($id);

            $examStudent->update([
                'deleted' => false
            ]);

            return $this->sendResponse([ExamStudentResource::make($examStudent)], "Examen étudiant restauré avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
