<?php

namespace App\Http\Controllers;

use App\Http\Requests\Matter\MatterArchiveRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\MatterResource;
use App\Http\Requests\Staffs\MatterRequest;
use App\Http\Requests\Staffs\MatterGetAllRequest;
use App\Models\Matter;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

/**
 * @group Matter
 */
class MatterController extends BaseController
{
    /**
     * Afficher la liste des matières
     *
     * @param MatterGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(MatterGetAllRequest $request)
    {
        try {
            $matter = $request->validated();
            $idSection = $request['idSection'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;
            $assessment = $request['assessment'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $matters = Matter::select('matter.id as id','matter.libelle as libelle','matter.code as code','matter.name as name','matter.description as description','matter.idOptionLevel as idOptionLevel','matter.assessment as assessment','matter.idSchool as idSchool','matter.idSection as idSection')
                ->where('matter.idSchool',$matter['idSchool']);

            if(!is_null($idSection)) $matters = $matters->where('matter.idSection',$matter['idSection']);

            if(!is_null($idLevel)){
                $matters = $matters
                    ->join('matter_has_level','matter_has_level.matter_id','=','matter.id')
                    ->where('matter_has_level.level_id', $request['idLevel']);
            }

            if(!is_null($idOptionLevel)) $matters = $matters->where('matter.idOptionLevel',$request['idOptionLevel']);

            if(!is_null($assessment)) $matters = $matters->where('matter.assessment',$request['assessment']);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $matters->where(function($query) use ($filter_value) {
                    $query->where('matter.name', 'like', "%$filter_value%");
                });
            }

            return MatterResource::collection($matters->orderBy('matter.id', 'desc')->paginate($nbreItems, ['*'], 'page', $pageItems));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter une matière
     *
     * @param MatterRequest $request
     * @return MatterResource|\Illuminate\Http\Response
     */
    public function store(MatterRequest $request)
    {
        try {
            $matter = $request->validated();

            $matter = new Matter();
            $matter->code = $request['code'] ?? null;
            $matter->libelle = $request['libelle'] ?? null;
            $matter->name = $request['name'];
            $matter->assessment = $request['assessment'] ?? null;
            $matter->description = $request['description'] ?? null;
            $matter->idOptionLevel = $request['idOptionLevel'] ?? null;
            $matter->idSchool = $request['idSchool'] ?? null;
            $matter->idSection = $request['idSection'] ?? null;
            $matter->created_by = auth()->user()->id;

            $matter->save();
            if(!empty($request['levels'])){
                $matter->levels()->sync($request['levels']);
            }

            return new MatterResource($matter);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function duplicateMatter(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $matterduplicated = [];
                if (!empty($request['matters_id'])) {
                    $matterIds = $request['matters_id'];

                    foreach ($matterIds as $matterId) {
                        $originalMatter = Matter::findOrFail($matterId);

                        $matter = new Matter();
                        $matter->code = $originalMatter['code'];
                        $matter->libelle = $originalMatter['libelle'];
                        $matter->name = $originalMatter['name'];
                        $matter->assessment = $originalMatter['assessment'];
                        $matter->description = $originalMatter['description'];
                        $matter->idOptionLevel = $originalMatter['idOptionLevel'];
                        $matter->idSchool = $request['idSchool'];
                        $matter->idSection = $request['idSection'];
                        $matter->created_by = auth()->user()->id;

                        $matter->save();

                        if (!empty($request['levels'])) {
                            $matter->levels()->sync($request['levels']);
                        }

                        $matterduplicated[] =$matter;
                    }
                }

                return $this->sendResponse($matterduplicated, "Successfully duplicated matters");
            });

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'une matière
     *
     * @param $id
     * @return MatterResource|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $matter = Matter::find($id);
            return new MatterResource($matter);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une matière
     *
     * @param MatterRequest $request
     * @param $id
     * @return MatterResource|\Illuminate\Http\Response
     */
    public function update(MatterRequest $request, $id)
    {
        try {
            $matter = $request->validated();

            $matter = Matter::find($id);
            $matter->code = $request['code'] ?? $matter['code'];
            $matter->libelle = $request['libelle'] ?? $matter['libelle'];
            $matter->name = $request['name'] ?? $matter['name'];
            $matter->assessment = $request['assessment'] ?? $matter['assessment'];
            $matter->description = $request['description'] ?? $matter['description'];
            $matter->idOptionLevel = $request['idOptionLevel'] ?? $matter['idOptionLevel'];
            $matter->idSchool = $request['idSchool'] ?? $matter['idSchool'];
            $matter->idSection = $request['idSection'] ?? $matter['idSection'];
            $matter->created_by = auth()->user()->id;
            $matter->save();

            if(!empty($request['levels'])){
                $matter->levels()->sync($request['levels']);
            }

            return new MatterResource($matter);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une matière
     *
     * @param Matter $matter
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try {
        $matter = Matter::findOrFail($id);

        $courses = Course::where('idMatter', $id)->exists();
        $usermatter = User::where('idMatter', $id)->exists();

        if ($courses) {
            return $this->sendError('impossible, cours existant');
        }

        if ($usermatter) {
            return $this->sendError('impossible, affecte a un utilisateur');
        }

        $matter->delete();
        return $this->sendResponses(null);

    } catch (\Throwable $th) {
        Log::critical(
            $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine()
        );
        return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
    }

    }

    /**
     * Met des matières à la corbeille (soft delete).
     *
     * @param  MatterArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(MatterArchiveRequest $request): JsonResponse
    {
        try {
            Matter::whereIn('id', $request->ids)->delete();
            Log::info('Matters mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des matières supprimées (soft delete).
     *
     * @param  MatterArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(MatterArchiveRequest $request): JsonResponse
    {
        try {
            Matter::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Matters restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des matières (hard delete).
     *
     * @param  MatterArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(MatterArchiveRequest $request): JsonResponse
    {
        try {
            Matter::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Matters supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
