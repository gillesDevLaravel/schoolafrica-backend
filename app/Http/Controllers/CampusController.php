<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\CampusResource;
use App\Http\Requests\Admin\CampusRequest;
use App\Http\Requests\Campus\CampusArchiveRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Campus;
use Illuminate\Support\Facades\Log;

/**
 * @group Campus
 */
class CampusController extends BaseController
{
    /**
     * Afficher la liste des Campus
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;

            $campus = Campus::query();

            if(!is_null($idSchool)) $campus = $campus->where('idSchool', $idSchool);

            return CampusResource::collection(
                $campus->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    /**
     * Ajouter un Campus
     *
     * @param CampusRequest $request
     * @return CampusResource|\Illuminate\Http\Response
     */
    public function store(CampusRequest $request)
    {
        try {
            $campus = $request->validated();

            $campus = Campus::create([
                'name' => $campus['name'],
                'adresse' => $campus['adresse'],
                'idSchool' => $campus['idSchool'],
                'created_by' => auth()->user()->id
            ]);

            return new CampusResource($campus);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un Campus
     *
     * @param Campus $campus
     * @param $id
     * @return CampusResource|\Illuminate\Http\Response
     */
    public function show(Campus $campus,$id)
    {
        try {
            $campus = Campus::find($id);
            return new CampusResource($campus);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un Campus
     *
     * @param CampusRequest $request
     * @param Campus $campus
     * @param $id
     * @return CampusResource|\Illuminate\Http\Response
     */
    public function update(CampusRequest $request,Campus $campus, $id)
    {
        try {
            $campus = Campus::find($id);
            $campus->name = $request['name'];
            $campus->adresse = $request['adresse'];
            $campus->idSchool = $request['idSchool'];
            $campus->updated_by = auth()->user()->id;

            $campus->save();
            return new CampusResource($campus);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un Campus
     *
     * @param Campus $campus
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Campus $campus,$id)
    {
        try {
            $campus = Campus::find($id);
            $campus->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des campus à la corbeille (soft delete).
     *
     * @param  CampusArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(CampusArchiveRequest $request): JsonResponse
    {
        try {
            Campus::whereIn('id', $request->ids)->delete();
            Log::info('Campus mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des campus supprimés (soft delete).
     *
     * @param  CampusArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(CampusArchiveRequest $request): JsonResponse
    {
        try {
            Campus::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Campus restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des campus (hard delete).
     *
     * @param  CampusArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(CampusArchiveRequest $request): JsonResponse
    {
        try {
            Campus::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Campus supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
