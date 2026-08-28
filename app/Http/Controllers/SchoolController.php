<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\School;
use App\Http\Requests\Admin\SchoolRequest;
use App\Http\Requests\School\SchoolArchiveRequest;
use App\Http\Resources\Admin\SchoolResource;
use App\Http\Requests\Admin\SchoolGetAllRequest;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group School
 *
 * Gestion de l'école
 */
class SchoolController extends BaseController
{
    /**
     * Afficher la liste des écoles
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            $schools = School::query();

            if(!empty($request['idPrincipal'])){
                $schools = $schools->where('idPrincipal',$request['idPrincipal'])
                    ->orWhere('idAssistant', $request['idPrincipal']);
            }

            if(!empty($request['idAdjoint'])){
                $schools = $schools->where('idAdjoint',$request['idAdjoint'])
                    ->orWhere('idAdjoint', $request['idAdjoint']);
            }

            if(!empty($request['idEstablishment'])){
                $schools = $schools->where('idEstablishment',$request['idEstablishment']);
            }

            if (!empty($request['idUser'])) {
                $idUser = $request['idUser'];

                // On filtre uniquement les écoles où l'utilisateur est principal, assistant ou secrétaire
                $schools = $schools->where(function ($query) use ($idUser) {
                    $query->where('idPrincipal', $idUser)
                        ->orWhere('idAssistant', $idUser)
                        ->orWhere('secretary_id', $idUser)
                        ->orWhere('idAdjoint', $idUser);
                });
            }

            return SchoolResource::collection(
                $schools->orderBy("id", "desc")->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    /**
     * Ajouter une école
     * @param SchoolRequest $request
     * @return SchoolResource|JsonResponse
     */
    public function store(SchoolRequest $request)
    {
        try {
            $school = $request->validated();

            $school = new School();

            $school->name = $request['name'];
            $school->adresse = $request['adresse'];
            $school->phone = $request['phone'];
            $school->city = $request['city'];
            $school->section = $request['section'];
            $school->idEstablishment = $request['idEstablishment'];
            $school->scholar_level = $request['scholar_level'];
            $school->email = $request['email'] ?? null;
            $school->website = $request['website'] ?? null;
            $school->logo = $request['logo'] ?? null;
            $school->matricule_code = $request['matricule_code'];
            $school->land_title = $request['land_title'] ?? null;
            $school->building_permit = $request['building_permit'] ?? null;
            $school->creation_authorization = $request['creation_authorization'] ?? null;
            $school->opening_authorization = $request['opening_authorization'] ?? null;
            $school->nui = $request['nui'] ?? null;
            $school->cnps = $request['cnps'] ?? null;
            $school->location_plan = $request['location_plan'] ?? null;
            $school->information_sheets = $request['information_sheets'] ?? null;
            $school->idPrincipal = $request['idPrincipal'] ?? null;
            $school->idAdjoint = $request['idAdjoint'] ?? null;
            $school->idAssistant = $request['idAssistant'] ?? null;
            $school->secretary_id = $request['idSecretary'] ?? null;
            $school->created_by =  auth()->user()->id;
            $school->save();

            return new SchoolResource($school);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'une école
     *
     * @param School $school
     * @param $id
     * @return SchoolResource|\Illuminate\Http\Response
     */
    public function show(School $school,$id)
    {
        try {
            $school = School::find($id);
            return new SchoolResource($school);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une école
     *
     * @param SchoolRequest $request
     * @param School $school
     * @param $id
     * @return SchoolResource|\Illuminate\Http\Response
     */
    public function update(SchoolRequest $request, School $school,$id)
    {
        try {
            $school = School::find($id);

            $school->name = $request['name'] ?? $school['name'];
            $school->adresse = $request['adresse'] ?? $school['adresse'];
            $school->phone = $request['phone'] ?? $school['phone'];
            $school->city = $request['city'] ?? $school['city'];
            $school->section = $request['section'] ?? $school['section'];
            $school->idEstablishment = $request['idEstablishment'] ?? $school['idEstablishment'];
            $school->scholar_level = $request['scholar_level'] ?? $school['scholar_level'];
            $school->email = $request['email'] === null ? null : ($request['email'] ?? $school['email']);
            $school->website = $request['website'] ?? null;
            $school->logo = $request['logo'] ?? null;
            $school->matricule_code = $request['matricule_code'] ?? $school->matricule_code;
            $school->land_title = $request['land_title'] ?? $school->land_title;
            $school->building_permit = $request['building_permit'] ?? $school->building_permit;
            $school->creation_authorization = $request['creation_authorization'] ?? $school->creation_authorization;
            $school->opening_authorization = $request['opening_authorization'] ?? $school->opening_authorization;
            $school->nui = $request['nui'] ?? $school->nui;
            $school->cnps = $request['cnps'] ?? $school->cnps;
            $school->location_plan = $request['location_plan'] ?? $school->location_plan;
            $school->information_sheets = $request['information_sheets'] ?? $school->information_sheets;
            $school->idPrincipal = $request['idPrincipal'] ?? null;
            $school->idAdjoint = $request['idAdjoint'] ?? $school->idAdjoint;
            $school->idAssistant = $request['idAssistant'] ?? null;
            $school->secretary_id = $request['idSecretary'] ?? $school->secretary_id;
            $school->updated_by =  auth()->user()->id;
            $school->save();

            return new SchoolResource($school);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une école
     *
     * @param School $school
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(School $school,$id)
    {
        try {
            $school = School::find($id);
            $school->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des écoles à la corbeille (soft delete).
     *
     * @param  SchoolArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(SchoolArchiveRequest $request): JsonResponse
    {
        try {
            School::whereIn('id', $request->ids)->delete();
            Log::info('Schools mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des écoles supprimées (soft delete).
     *
     * @param  SchoolArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(SchoolArchiveRequest $request): JsonResponse
    {
        try {
            School::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Schools restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des écoles (hard delete).
     *
     * @param  SchoolArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(SchoolArchiveRequest $request): JsonResponse
    {
        try {
            School::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Schools supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
