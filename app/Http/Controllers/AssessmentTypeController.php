<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssessmentType\AssessmentTypeArchiveRequest;
use App\Http\Requests\Staffs\AssessmentTypeGetAllRequest;
use App\Http\Requests\Staffs\AssessmentTypeRequest;
use App\Http\Resources\Staffs\AssessmentTypeResource;
use App\Models\AssessmentType;
use App\Models\Rating;
use App\Models\Trimestre;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Assessment Type
 */
class AssessmentTypeController extends BaseController
{
    /**
     * Listing des AssessmentType
     * @param AssessmentTypeGetAllRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(AssessmentTypeGetAllRequest $request)
    {
        try {
            $assessmentType  = $request->validated();
            $idSection = $assessmentType["idSection"] ?? null;
            $takenIntoAccount = $request->takenIntoAccount ?? 0;

            $assessmentTypes = AssessmentType::where('idSchool',$assessmentType['idSchool'])
                ->where('takenIntoAccount', $takenIntoAccount);

            // Filtrer par notes_completed = true pour les parents et les étudiants
            if (auth()->user() && in_array(auth()->user()->getRole()->id, [7, 8])) { 
                $assessmentTypes = $assessmentTypes->where('notes_completed', true);
            }

            if(!is_null($idSection)) $assessmentTypes = $assessmentTypes->where('idSection', $idSection);

            return AssessmentTypeResource::collection(
                $assessmentTypes
                    ->orderBy("id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param AssessmentTypeRequest $request
     * @return JsonResponse
     */
    public function store(AssessmentTypeRequest $request)
    {
        try {
            $assessmentTypes = [];
            foreach ($request->assessmenttypes as $assessmentType){
                $trimestre = Trimestre::find($assessmentType['idTrimestre']);

                $assessmentTypes []= AssessmentType::create([
                    'name' => $assessmentType['name'],
                    'numbering' => $assessmentType['numbering'] ?? null,
                    'idTrimestre' => $assessmentType['idTrimestre'] ?? null,
                    'takenIntoAccount' => $trimestre['takenIntoAccount'] ?? 0,
                    'pourcentage' => $assessmentType['pourcentage'] ?? null,
                    'notes_completed' => $assessmentType['notes_completed'] ?? false,
                    'start_date' => $assessmentType['start_date'] ?? false,
                    'end_date' => $assessmentType['end_date'] ?? false,
                    'idSchool' => $trimestre['idSchool'] ?? null,
                    'idSection' => $trimestre['idSection'] ?? null,
                    'created_by' => auth()->user()->id,
                ]);
            }

            return $this->sendResponse(AssessmentTypeResource::collection($assessmentTypes), "Assessmenttypes créés avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les détails d'une séquence (AssessmentType)
     *
     * @param AssessmentType $assessmentType
     * @param $id
     * @return AssessmentTypeResource|Response
     */
    public function show(AssessmentType $assessmentType,$id)
    {
        try {
            $assessmentType = AssessmentType::find($id);
            return new AssessmentTypeResource($assessmentType);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Mise à jour des infos d'une séquence
     * @param Request $request
     * @param AssessmentType $assessmentType
     * @param $id
     * @return AssessmentTypeResource|JsonResponse
     */
    public function update(Request $request, AssessmentType $assessmentType,$id)
    {
        try {
            $trimestre = Trimestre::find($request['idTrimestre']);

            $assessmentType = AssessmentType::find($id);
            $assessmentType->name = $request['name'] ?? $assessmentType['name'];
            $assessmentType->numbering = $request['numbering'] ?? $assessmentType['numbering'];
            $assessmentType->pourcentage = $request['pourcentage'] ?? $assessmentType['pourcentage'];
            $assessmentType->notes_completed = $request['notes_completed'] ?? $assessmentType->notes_completed;
            $assessmentType->start_date = $request['start_date'] ?? $assessmentType->start_date;
            $assessmentType->end_date = $request['end_date'] ?? $assessmentType->end_date;
            $assessmentType->idTrimestre = $request['idTrimestre'] ?? $assessmentType['idTrimestre'];
            $assessmentType->takenIntoAccount = $request->takenIntoAccount ?? $assessmentType->takenIntoAccount;
            $assessmentType->idSchool = $trimestre->idSchool ?? $assessmentType->idSchool;
            $assessmentType->idSection = $trimestre->idSection ?? $assessmentType->idSection;
            $assessmentType->updated_by = auth()->user()->id;
            $assessmentType->save();

            return new AssessmentTypeResource($assessmentType);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une séquence (#trash)
     * @param AssessmentType $assessmentType
     * @param $id
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function destroy(AssessmentType $assessmentType,$id)
    {
        try {
            $assessmentType = AssessmentType::findOrFail($id);

            $existingRatings = Rating::where('idAssessmentType', $id)->count();

            if($existingRatings !==0){
                return $this->sendError("Impossible car note existante", []);
            }

//            $assessmentType->delete();
            $assessmentType->update([
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
     * Met des types d'évaluation à la corbeille (soft delete).
     *
     * @param  AssessmentTypeArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(AssessmentTypeArchiveRequest $request): JsonResponse
    {
        try {

            AssessmentType::whereIn('id', $request->ids)->delete();
            Log::info('AssessmentTypes mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des types d'évaluation supprimés (soft delete).
     *
     * @param  AssessmentTypeArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(AssessmentTypeArchiveRequest $request): JsonResponse
    {
        try {
            AssessmentType::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('AssessmentTypes restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des types d'évaluation (hard delete).
     *
     * @param  AssessmentTypeArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(AssessmentTypeArchiveRequest $request): JsonResponse
    {
        try {
            AssessmentType::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('AssessmentTypes supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
