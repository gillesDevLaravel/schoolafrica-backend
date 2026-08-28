<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\LevelResource;
use App\Http\Requests\Admin\LevelRequest;
use App\Http\Requests\Level\LevelArchiveRequest;
use App\Models\Level;
use App\Models\Cycle;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Level
 */
class LevelController extends BaseController
{
    /**
     * Afficher la liste des niveaux (Level)
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idCycle = $request['idCycle'] ?? null;

            $levels = Level::query();

            if(!is_null($idSchool)) $levels = $levels->where('idSchool', $idSchool);

            if(!is_null($idSection)) $levels = $levels->where('idSection',$idSection );

            if(!is_null($idCycle)){
                $levels = $levels->where('idCycle',$idCycle );
            }

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $levels->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('description', 'like', "%$filter_value%");
                });
            }

            return LevelResource::collection(
                $levels
                    ->orderBy("id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un niveau
     *
     * @param LevelRequest $request
     * @return LevelResource|\Illuminate\Http\Response
     */
    public function store(LevelRequest $request)
    {
        try {
            foreach ($request->levels as $level) {
                Level::create([
                    'name' => $level['name'],
                    'idCycle' => $level['idCycle'],
                    'idSchool' => $level['idSchool'],
                    'idSection' => $level['idSection'] ?? null,
                    'description' => $level['description'] ?? null,
                    'created_by' => auth()->user()->id
                ]);
            }

            return $this->sendResponse([], "Levels créés avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un niveau
     *
     * @param Level $Level
     * @param $id
     * @return LevelResource|\Illuminate\Http\Response
     */
    public function show(Level $Level,$id)
    {
        try {
            $Level = Level::find($id);
            return new LevelResource($Level);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un niveau
     *
     * @param LevelRequest $request
     * @param $id
     * @return LevelResource|Response
     */
    public function update(Request $request, $id)
    {
        try {
            $level = Level::find($id);
            $level->name = $request['name'] ?? $level->name;
            // mettre à jour le cycle
            $level->idCycle = $request['idCycle'] ?? $level->idCycle;

            // prendre les idSchool et idSection du cycle
            if (!is_null($level->idCycle)) {
                $cycle = Cycle::find($level->idCycle);
                if ($cycle) {
                    $level->idSchool = $cycle->idSchool;
                    $level->idSection = $cycle->idSection;
                }
            }
            $level->description = $request['description'] ?? null;
            $level->updated_by = auth()->user()->id;

            $level->save();
            return new LevelResource($level);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un niveau
     *
     * @param Level $level
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Level $level,$id)
    {
        try {
            $level = Level::find($id);
            $level->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des niveaux à la corbeille (soft delete).
     *
     * @param  LevelArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(LevelArchiveRequest $request): JsonResponse
    {
        try {
            Level::whereIn('id', $request->ids)->delete();
            Log::info('Levels mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des niveaux supprimés (soft delete).
     *
     * @param  LevelArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(LevelArchiveRequest $request): JsonResponse
    {
        try {
            Level::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Levels restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des niveaux (hard delete).
     *
     * @param  LevelArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(LevelArchiveRequest $request): JsonResponse
    {
        try {
            Level::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Levels supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
