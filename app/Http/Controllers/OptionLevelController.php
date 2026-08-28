<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\OptionLevelGetRequest;
use App\Http\Requests\OptionLevel\OptionLevelArchiveRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\OptionLevelResource;
use App\Http\Requests\Admin\OptionLevelRequest;
use App\Models\OptionLevel;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @group Option Level
 */
class OptionLevelController extends BaseController
{
    /**
     * Afficher la liste des Options de Niveau
     *
     * @param OptionLevelGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(OptionLevelGetRequest $request)
    {
        try {
            $optionsLevel = OptionLevel::select('option_level.id as id','option_level.name as name','option_level.description as description','option_level.lang as lang','option_level.idSchool as idSchool','option_level.idSection as idSection','option_level.idLevel as idLevel','option_level.idFiliere as idFiliere');
            $idLevel = $request['idLevel'] ?? null;

            if(!is_null($request['idSchool'])) $optionsLevel = $optionsLevel->where('option_level.idSchool', $request['idSchool']);

            if(!is_null($request['idSection'])) $optionsLevel = $optionsLevel->where('option_level.idSection', $request['idSection']);
            if(!is_null($request['idSection'])) $optionsLevel = $optionsLevel->where('option_level.idSection', $request['idSection']);

            if(!is_null($request['idLevel'])){
                $optionsLevel = $optionsLevel->where('option_level.idLevel', $request['idLevel'])
                    ->orWhereHas('levels', function($q) use ($idLevel) {
                        $q->where('levels.id', $idLevel);
                    });
            }

            if(!is_null($request['lang'])) $optionsLevel = $optionsLevel->where('option_level.lang', $request['lang']);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $optionsLevel->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('description', 'like', "%$filter_value%")
                        ->orWhere('lang', 'like', "%$filter_value%");
                });
            }

            return OptionLevelResource::collection($optionsLevel->orderBy("option_level.id", "desc")->get());
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un option de niveau
     *
     * @param OptionLevelRequest $request
     * @return OptionLevelResource|\Illuminate\Http\Response
     */
    public function store(OptionLevelRequest $request)
    {
        try {
            foreach ($request->optionlevels as $optionLevel) {
                $optl = OptionLevel::create([
                    'name' => $optionLevel['name'],
                    'idLevel' => $optionLevel['idLevel'] ?? null,
                    'idFiliere' => $optionLevel['idFiliere'] ?? null,
                    'idSchool' => $optionLevel['idSchool'],
                    'idSection' => $optionLevel['idSection'] ?? null,
                    'description' => $optionLevel['description'] ?? null,
                    'lang' => $optionLevel['lang'] ?? null,
                    'created_by' => auth()->user()->id
                ]);

                if(!empty($optionLevel['levels'])){
                    $optl->levels()->sync($optionLevel['levels']);
                }
            }

            return $this->sendResponse([], "OptionLevels créés avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un option de niveau
     *
     * @param OptionLevel $optionLevel
     * @param $id
     * @return OptionLevelResource|\Illuminate\Http\Response
     */
    public function show(OptionLevel $optionLevel,$id)
    {
        try {
            $optionLevel = OptionLevel::find($id);
            return new OptionLevelResource($optionLevel);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un option de niveau
     *
     * @param OptionLevelRequest $request
     * @param OptionLevel $optionLevel
     * @param $id
     * @return OptionLevelResource|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $optionLevel = OptionLevel::find($id);
            $optionLevel->name = $request['name'] ?? $optionLevel->name;
            $optionLevel->idLevel = $request['idLevel'] ?? $optionLevel->idLevel;
            $optionLevel->idFiliere = $request['idFiliere'] ?? $optionLevel->idFiliere;
            $optionLevel->idSchool = $request['idSchool'] ?? $optionLevel->idSchool;
            $optionLevel->idSection = $request['idSection'] ?? $optionLevel->idSection;
            $optionLevel->description = $request['description'] ?? $optionLevel->description;
            $optionLevel->lang = $request['lang'] ?? $optionLevel->lang;
            $optionLevel->updated_by = auth()->user()->id;

            $optionLevel->save();

            if(!empty($request['levels'])){
                $optionLevel->levels()->sync($request['levels']);
            }
            return new OptionLevelResource($optionLevel);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un option de niveau
     *
     * @param OptionLevel $optionLevel
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(OptionLevel $optionLevel,$id)
    {
        try {
            $optionLevel = OptionLevel::find($id);
            $optionLevel->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des options de niveau à la corbeille (soft delete).
     *
     * @param  OptionLevelArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(OptionLevelArchiveRequest $request): JsonResponse
    {
        try {
            OptionLevel::whereIn('id', $request->ids)->delete();
            Log::info('OptionLevels mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des options de niveau supprimées (soft delete).
     *
     * @param  OptionLevelArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(OptionLevelArchiveRequest $request): JsonResponse
    {
        try {
            OptionLevel::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('OptionLevels restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des options de niveau (hard delete).
     *
     * @param  OptionLevelArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(OptionLevelArchiveRequest $request): JsonResponse
    {
        try {
            OptionLevel::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('OptionLevels supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
