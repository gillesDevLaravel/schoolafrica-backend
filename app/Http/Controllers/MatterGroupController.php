<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatterGroup\MatterGroupArchiveRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\MatterGroupResource;
use App\Http\Requests\Staffs\MatterGroupRequest;
use App\Http\Requests\Staffs\MatterGroupGetAllRequest;
use App\Models\MatterGroup;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @group Matter Group
 */
class MatterGroupController extends BaseController
{
    /**
     * Afficher la liste des groupes de matières
     *
     * @param MatterGroupGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(MatterGroupGetAllRequest $request)
    {
        try {
            $matterGroup = $request->validated();
            $idSection = $request['idSection'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $matterGroups = MatterGroup::where('idSchool',$matterGroup['idSchool']);

            if(!is_null($idSection)) $matterGroups = $matterGroups->where('idSection',$matterGroup['idSection']);

            if(!is_null($idLevel)){
                $matterGroups = $matterGroups
                    ->join('matter_group_has_level', 'matter_group_has_level.matter_group_id', '=', 'matter_group.id')
                    ->where('matter_group_has_level.level_id', $request['idLevel']);
            }

            if(!is_null($idOptionLevel)) $matterGroups = $matterGroups->where('idOptionLevel', $request['idOptionLevel']);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $matterGroups->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('description', 'like', "%$filter_value%");
                });
            }

            return MatterGroupResource::collection(
                $matterGroups
                    ->select('matter_group.*')
                    ->orderBy("matter_group.id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un Groupe de matières
     *
     * @param MatterGroupRequest $request
     * @return MatterGroupResource|\Illuminate\Http\Response
     */
    public function store(MatterGroupRequest $request)
    {
        try {
            $matterGroup = $request->validated();

            $matterGroup = MatterGroup::create([
                'name' => $request['name'],
                'idOptionLevel' => $request['idOptionLevel'] ?? null,
                'description' => $request['description'] ?? null,
                'idSchool' => $request['idSchool'] ?? null,
                'idSection' => $request['idSection'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            if(!empty($request['matter'])){
                $matterGroup->matters()->sync($request['matter']);
            }

            if(!empty($request['levels'])){
                $matterGroup->levels()->sync($request['levels']);
            }

            return new MatterGroupResource($matterGroup);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'un groupe de matière
     *
     * @param MatterGroup $matterGroup
     * @param $id
     * @return MatterGroupResource|\Illuminate\Http\Response
     */
    public function show(MatterGroup $matterGroup,$id)
    {
        try {
            $matterGroup = MatterGroup::find($id);
            return new MatterGroupResource($matterGroup);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un groupe de matières
     *
     * @param MatterGroupRequest $request
     * @param $id
     * @return MatterGroupResource|\Illuminate\Http\Response
     */
    public function update(MatterGroupRequest $request, $id)
    {
        try {
            $matterGroup = $request->validated();

            $matterGroup = MatterGroup::find($id);
            $matterGroup->name = $request['name'];
            $matterGroup->idOptionLevel = $request['idOptionLevel'] ?? null;
            $matterGroup->description = $request['description'] ?? null;
            $matterGroup->idSchool = $request['idSchool'] ?? null;
            $matterGroup->idSection = $request['idSection'] ?? null;
            $matterGroup->updated_by = auth()->user()->id;

            $matterGroup->save();

            if(!empty($request['matter'])){
                $matterGroup->matters()->sync($request['matter']);
            }

            if(!empty($request['levels'])){
                $matterGroup->levels()->sync($request['levels']);
            }
            return new MatterGroupResource($matterGroup);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Suppression d'un groupe de matières
     *
     * @param MatterGroup $matterGroup
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(MatterGroup $matterGroup,$id)
    {
        try {
            $matterGroup = MatterGroup::find($id);
            $matterGroup->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des groupes de matières à la corbeille (soft delete).
     *
     * @param  MatterGroupArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(MatterGroupArchiveRequest $request): JsonResponse
    {
        try {
            MatterGroup::whereIn('id', $request->ids)->delete();
            Log::info('MatterGroups mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des groupes de matières supprimés (soft delete).
     *
     * @param  MatterGroupArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(MatterGroupArchiveRequest $request): JsonResponse
    {
        try {
            MatterGroup::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('MatterGroups restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des groupes de matières (hard delete).
     *
     * @param  MatterGroupArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(MatterGroupArchiveRequest $request): JsonResponse
    {
        try {
            MatterGroup::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('MatterGroups supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
