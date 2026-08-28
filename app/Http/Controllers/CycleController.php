<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\CycleResource;
use App\Http\Requests\Admin\CyclesRequest;
use App\Http\Requests\Cycle\CycleArchiveRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Cycle;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Cycle
 */
class CycleController extends BaseController
{
    /**
     * Afficher la liste des cycles
     *
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;

            $cycles = Cycle::query();

            if(!is_null($idSchool)) $cycles = $cycles->where('idSchool',$request['idSchool']);
            if(!is_null($idSection)) $cycles = $cycles->where('idSection',$request['idSection']);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $cycles->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('description', 'like', "%$filter_value%");
                });
            }

            return CycleResource::collection(
                $cycles
                    ->orderBy('id', 'desc')
                    ->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un cycle
     *
     * @param CyclesRequest $request
     * @return JsonResponse
     */
    public function store(CyclesRequest $request)
    {
        try {
            foreach ($request->cycles as $cycle) {
                $cyc = Cycle::create([
                    'name' => $cycle['name'],
                    'idCampus' => $cycle['idCampus'] ?? null,
                    'idSchool' => $cycle['idSchool'],
                    'idSection' => $cycle['idSection'] ?? null,
                    'description' => $cycle['description'] ?? null,
                    'created_by' => auth()->user()->id
                ]);

                if(isset($cycle['filieres'])){
                    $cyc->filieres()->attach($cycle['filieres']);
                }
            }

            return $this->sendResponse([], "Cycles créés avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un cycle
     *
     * @param $id
     * @return CycleResource|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $cycle = Cycle::findOrFail($id);

            return new CycleResource($cycle);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un cycle
     *
     * @param CyclesRequest $request
     * @param Cycle $cycle
     * @param $id
     * @return CycleResource|\Illuminate\Http\Response
     */
    public function update(Request $request,Cycle $cycle, $id)
    {
        try {
            $cycle = Cycle::find($id);

            $cycle->name = $request['name'] ?? $cycle->name;
            $cycle->idCampus = $request['idCampus'] ?? null;
            $cycle->idSchool = $request['idSchool'] ?? $cycle->idSchool;
            $cycle->idSection = $request['idSection'] ?? $cycle->idSection;
            $cycle->description = $request['description'] ?? null;
            $cycle->updated_by = auth()->user()->id;

            $cycle->save();

            if(isset($request->filieres)){
                $cycle->filieres()->sync($request->filieres);
            }

            return new CycleResource($cycle);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un cycle
     *
     * @param Cycle $cycle
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Cycle $cycle,$id)
    {
        try {
            $cycle = Cycle::findOrFail($id);

            $cycle->filieres()->sync([]);
            $cycle->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des cycles à la corbeille (soft delete).
     *
     * @param  CycleArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(CycleArchiveRequest $request): JsonResponse
    {
        try {
            Cycle::whereIn('id', $request->ids)->delete();
            Log::info('Cycles mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des cycles supprimés (soft delete).
     *
     * @param  CycleArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(CycleArchiveRequest $request): JsonResponse
    {
        try {
            Cycle::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Cycles restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des cycles (hard delete).
     *
     * @param  CycleArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(CycleArchiveRequest $request): JsonResponse
    {
        try {
            Cycle::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Cycles supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
