<?php

namespace App\Http\Controllers;

use App\Models\Trimestre;
use App\Http\Requests\Trimestre\TrimestreArchiveRequest;
use App\Http\Requests\Staffs\StoreTrimestreRequest;
use App\Http\Requests\Staffs\UpdateTrimestreRequest;
use App\Http\Resources\Staffs\TrimestreResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Trimestre
 */
class TrimestreController extends BaseController
{
    /**
     * Afficher la liste des trimestres
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            $takenIntoAccount = $request->takenIntoAccount ?? 0;

            $trimestres = Trimestre::query()
                ->when(!is_null($request['idSchool']), function($query) use ($request) {
                    $query->where('idSchool', $request['idSchool']);
                })
                ->when(!is_null($request['idSection']), function($query) use ($request) {
                    $query->where('idSection', $request['idSection']);
                })
                ->when(!is_null($request['idSemestre']), function($query) use ($request) {
                    $query->where('idSemestre', $request['idSemestre']);
                })
                ->where('takenIntoAccount', $takenIntoAccount);

               /* Filtrage spécifique pour les parents: ne renvoyer que les trimestres 
               où TOUS les assessment types ont notes_completed = true */

               if (auth()->user() && auth()->user()->getRole()->id === 7) { 
               $trimestres = $trimestres->whereHas('assessmentTypes')
                  ->whereDoesntHave('assessmentTypes', function ($query) {
                     $query->where('notes_completed', false);
                 });
               }
            $trimestres = $trimestres->orderBy("id", "desc")->get();

            return TrimestreResource::collection($trimestres);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un trimestre
     *
     * @param StoreTrimestreRequest $request
     * @return JsonResponse
     */
    public function store(StoreTrimestreRequest $request)
    {
        try {
            $trimestres = [];
            foreach ($request->trimestres as $trimestre) {
                $trimestres []= Trimestre::create([
                    'name' => $trimestre['name'],
                    'numbering' => $trimestre['numbering'] ?? null,
                    'idSchool' => $trimestre['idSchool'],
                    'idSection' => $trimestre['idSection'],
                    'idSemestre' => $trimestre['idSemestre'] ?? null,
                    'takenIntoAccount' => $trimestre['takenIntoAccount'] ?? false,
                    'created_by' => auth()->user()->id
                ]);
            }

            return $this->sendResponse(TrimestreResource::collection($trimestres), "Trimestres créés avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Aficher les informations d'un trimestre
     * @param Trimestre $trimestre
     * @param $id
     * @return TrimestreResource|JsonResponse
     */
    public function show(Trimestre $trimestre,$id)
    {
        try {
            $trimestre = Trimestre::find($id);
            return new TrimestreResource($trimestre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour les informations d'un trimestre
     * @param Request $request
     * @param $id
     * @return TrimestreResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $trimestre = Trimestre::findOrFail($id);
            $trimestre->name = $request['name'] ?? $trimestre->name;
            $trimestre->numbering = $request['numbering'] ?? $trimestre->numbering;
            $trimestre->idSchool = $request['idSchool'] ?? $trimestre->idSchool;
            $trimestre->idSection = $request['idSection'] ?? $trimestre->idSection;
            $trimestre->idSemestre = $request['idSemestre'] ?? $trimestre->idSemestre;
            $trimestre->takenIntoAccount = $request['takenIntoAccount'] ?? $trimestre->takenIntoAccount;
            $trimestre->updated_by = auth()->user()->id;

            $trimestre->save();
            return new TrimestreResource($trimestre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un trimestre
     *
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id)
    {
        try {
            $trimestre = Trimestre::findOrFail($id);
            $trimestre->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des trimestres à la corbeille (soft delete).
     *
     * @param  TrimestreArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(TrimestreArchiveRequest $request): JsonResponse
    {
        try {
            Trimestre::whereIn('id', $request->ids)->delete();
            Log::info('Trimestres mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des trimestres supprimés (soft delete).
     *
     * @param  TrimestreArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(TrimestreArchiveRequest $request): JsonResponse
    {
        try {
            Trimestre::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Trimestres restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des trimestres (hard delete).
     *
     * @param  TrimestreArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(TrimestreArchiveRequest $request): JsonResponse
    {
        try {
            Trimestre::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Trimestres supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
