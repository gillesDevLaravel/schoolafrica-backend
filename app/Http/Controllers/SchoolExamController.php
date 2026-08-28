<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolExam\SchoolExamArchiveRequest;
use App\Http\Requests\SchoolExam\SchoolExamCreateRequest;
use App\Http\Requests\SchoolExam\SchoolExamGetRequest;
use App\Http\Requests\SchoolExam\SchoolExamUpdateRequest;
use App\Http\Resources\SchoolExamResource;
use App\Models\SchoolExam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Examens scolaires
 *
 * Gestion des examens d'école (schools_exams)
 */
class SchoolExamController extends BaseController
{
    /**
     * Lister les examens
     *
     * @queryParam filter_value string Recherche par nom. Example: Math
     * @queryParam idAssessment integer Filtrer par évaluation. Example: 2
     * @queryParam idAssessmentType integer Filtrer par type d'évaluation. Example: 1
     * @queryParam pageItems integer Numéro de page. Example: 1
     * @queryParam nbreItems integer Nombre par page. Example: 50
     * @authenticated
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(SchoolExamGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $query = SchoolExam::query();

            if ($request->filled('filter_value')) {
                $query->where('name', 'like', '%' . $request->filter_value . '%');
            }
            if ($request->filled('idMatter')) {
                $query->where('idMatter', $request->idMatter);
            }
            if ($request->filled('idOptionlevel')) {
                $query->where('idOptionlevel', $request->idOptionlevel);
            }
            if ($request->filled('idAssessmentType')) {
                $query->where('idAssessmentType', $request->idAssessmentType);
            }

            return SchoolExamResource::collection(
                $query->orderBy('id', 'desc')->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Créer des examens (création en masse)
     *
     * @bodyParam exams array required Tableau des examens à créer.
     * @bodyParam exams[].name string required Nom de l'examen. Example: Examen Trimestre 1
     * @bodyParam exams[].description string Description de l'examen. Example: Examen de fin de trimestre
     * @bodyParam exams[].answer string Réponse à l'examen. Example: Réponse type
     * @bodyParam exams[].idAssessment integer required Identifiant de l'évaluation. Example: 2
     * @bodyParam exams[].idAssessmentType integer required Type d'évaluation. Example: 1
     * @bodyParam exams[].classes array Tableau des IDs des classes. Example: [1,2,3]
     * @authenticated
     * @return JsonResponse
     */
    public function store(SchoolExamCreateRequest $request): JsonResponse
    {
        try {
            $data = [];
            foreach ($request->exams as $exam) {
                // Créer l'examen
                $schoolExam = SchoolExam::create([
                    'name' => $exam['name'],
                    'image' => $exam['image'] ?? null,
                    'description' => $exam['description'] ?? null,
                    'answer' => $exam['answer'] ?? null,
                    'idMatter' => $exam['idMatter'],
                    'idAssessmentType' => $exam['idAssessmentType'],
                    'idOptionLevel' => $exam['idOptionLevel'] ?? null,
                    'created_by' => auth()->id(),
                ]);

                // Créer les enregistrements dans la table pivot si des classes sont fournies
                if (isset($exam['classes']) && is_array($exam['classes'])) {
                    foreach ($exam['classes'] as $classeId) {
                        $schoolExam->classes()->attach($classeId);
                    }
                }

                $data[] = $schoolExam->load('classes');
            }

            return $this->sendResponse($data, 'Examens créés avec succès');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Afficher un examen
     *
     * @urlParam school_exam integer required ID de l'examen. Example: 12
     * @authenticated
     * @return SchoolExamResource|JsonResponse
     */
    public function show(SchoolExam $school_exam)
    {
        try {
            return new SchoolExamResource($school_exam);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Mettre à jour un examen
     *
     * @urlParam school_exam integer required ID de l'examen. Example: 12
     * @bodyParam name string Nom de l'examen. Example: Examen final
     * @bodyParam description string Description de l'examen. Example: Examen de fin d'année
     * @bodyParam answer string Réponse à l'examen. Example: Réponse type
     * @bodyParam idAssessment integer Identifiant de l'évaluation. Example: 3
     * @bodyParam idAssessmentType integer Type d'évaluation. Example: 2
     * @bodyParam classes array Tableau des IDs des classes. Example: [1,2,3]
     * @authenticated
     * @return JsonResponse
     */
    public function update(SchoolExamUpdateRequest $request, SchoolExam $school_exam): JsonResponse
    {
        try {
            $school_exam->update([
                'name' => $request['name'] ?? $school_exam->name,
                'image' => $request['image'] ?? $school_exam->image,
                'description' => $request['description'] ?? $school_exam->description,
                'answer' => $request['answer'] ?? $school_exam->answer,
                'idOptionLevel' => $request['idOptionLevel'] ?? $school_exam->idOptionLevel,
                'idMatter' => $request['idMatter'] ?? $school_exam->idMatter,
                'idAssessmentType' => $request['idAssessmentType'] ?? $school_exam->idAssessmentType,
                'updated_by' => auth()->id(),
            ]);

            // Mise à jour des classes associées (si fournies)
            if ($request->filled('classes')) {
                $school_exam->classes()->detach();

                $classesData = [];
                foreach ($request->classes as $classeId) {
                    $classesData[] = $classeId;
                }
                // Synchronise les classes avec les nouvelles données
                $school_exam->classes()->sync($classesData);
            }

            return $this->sendResponse($school_exam->load('classes'), 'Examen mis à jour avec succès');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Archiver des examens (soft delete)
     *
     * @bodyParam ids array required Liste des IDs à archiver. Example: [1,2,3]
     * @bodyParam ids.* integer ID d'un examen existant. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function trash(SchoolExamArchiveRequest $request): JsonResponse
    {
        try {
            SchoolExam::whereIn('id', $request->ids)->delete();
            return $this->sendResponse([], 'Examens archivés avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Restaurer des examens archivés
     *
     * @bodyParam ids array required Liste des IDs à restaurer. Example: [1,2,3]
     * @bodyParam ids.* integer ID d'un examen existant. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function restore(SchoolExamArchiveRequest $request): JsonResponse
    {
        try {
            SchoolExam::withTrashed()->whereIn('id', $request->ids)->restore();
            return $this->sendResponse([], 'Examens restaurés avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement des examens
     *
     * @bodyParam ids array required Liste des IDs à supprimer définitivement. Example: [1,2,3]
     * @bodyParam ids.* integer ID d'un examen existant. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function destroy(SchoolExamArchiveRequest $request): JsonResponse
    {
        try {
            SchoolExam::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            return $this->sendResponse([], 'Examens supprimés définitivement', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }
}
