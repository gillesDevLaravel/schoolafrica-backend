<?php

namespace App\Http\Controllers;

use App\Models\Progression;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Http\Requests\Staffs\ModuleRequest;
use App\Http\Requests\Staffs\ModuleGetAllRequest;
use App\Http\Resources\Staffs\ModuleResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @group Module
 */
class ModuleController extends BaseController
{
    /**
     * Afficher la liste des modules
     *
     * @param ModuleGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(ModuleGetAllRequest $request)
    {
        try {
            $module  = $request->validated();
            $idProgression = $request['idProgression'] ?? null;
            $idSchool = $request['idSchool'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $modules  = Module::query();
            $school = !is_null($idSchool) ? School::find($idSchool) : null;

            if(!is_null($school) && in_array($school->scholar_level, ['Primary', 'Nursery'])){
                $idTeacher = null;
            }


            $modules = $modules->when($request->idClasse, function ($query) use ($request) {
                // Filtrer par idClasse via la relation progression
                return $query->whereHas('progression', function ($q) use ($request) {
                    $q->where('idClasse', $request->idClasse);
                });
            });


            if(!is_null($idSchool)) $modules = $modules->where('modules.idSchool',$request['idSchool']);
            if(!is_null($idSection)) $modules = $modules->where('modules.idSection',$request['idSection']);
            if(!is_null($idTeacher)) $modules = $modules->where('modules.idTeacher',$request['idTeacher']);
            if(!is_null($idProgression)) $modules = $modules->where('idProgression',$request['idProgression']);

            $user = User::select('users.id as id','roles.name as role')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->join('schools','schools.id','=','users.idSchool')
                ->where('users.id', auth()->user()->id)
                ->first();

            // Pour l'étudiant à l'université
            if(!is_null($school) && $school->scholar_level == "University" && $user->role == "Inscription"){
                $modules->join('pension_users', 'pension_users.idTranche', 'modules.idTranche')
                    ->where('pension_users.idStudent', $user->id)
                    ->where('pension_users.solvable', 'terminé');
            }

            $filter_value = $request['filter_value'] ?? null;

            if(!is_null($filter_value)){
                $modules->where(function($query) use ($filter_value) {
                    $query
                        ->where('modules.name', 'like', "%$filter_value%")
                        ->orWhere('modules.startDate', 'like', "%$filter_value%")
                        ->orWhere('modules.endDate', 'like', "%$filter_value%")
                        ->orwhereHas('progression', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return ModuleResource::collection(
                $modules
                    ->orderBy("modules.id", "asc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }



    /**
     * Ajouter un module
     *
     * @param ModuleRequest $request
     * @return ModuleResource|\Illuminate\Http\Response
     */
    public function store(ModuleRequest $request)
    {
        try {
            $module = $request->validated();

            $progression = Progression::find($request['idProgression']);

            $module = new Module();

            $module->name = $request['name'];
            $module->description = $request['description'];
            $module->nbrChapters = $request['nbrChapters'] ?? null;
            $module->status = $request['status'] ?? null;
            $module->observation = $request['observation'] ?? null;
            $module->startDate = $request['startDate'] ?? null;
            $module->endDate = $request['endDate'] ?? null;
            $module->duration = $request['duration'] ?? null;
            $module->image = $request['image'] ?? null;
            $module->idProgression = $request['idProgression'];
            $module->idMatter = $request['idMatter'] ?? null;
            $module->idTeacher = $request['idTeacher'] ?? null;
            $module->idSchool = $progression->idSchool;
            $module->idSection = $progression->idSection;
            $module->idTranche = $request['idTranche'];
            $module->created_by = auth()->user()->id;
            $module->save();

            return new ModuleResource($module);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un module
     *
     * @param Module $module
     * @param $id
     * @return ModuleResource|\Illuminate\Http\Response
     */
    public function show(Module $module,$id)
    {
        try {
            $module = Module::find($id);
            return new ModuleResource($module);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un module
     *
     * @param ModuleRequest $request
     * @param Module $module
     * @param $id
     * @return ModuleResource|\Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, Module $module,$id)
    {
        try {
            $progression = Progression::find($request['idProgression']);

            $module = Module::find($id);
            $module->name = $request['name'];
            $module->description = $request['description'];
            $module->nbrChapters = $request['nbrChapters'] ?? null;
            $module->status = $request['status'] ?? null;
            $module->observation = $request['observation'] ?? $module['observation'];
            $module->startDate = $request['startDate'] ?? null;
            $module->endDate = $request['endDate'] ?? null;
            $module->duration = $request['duration'] ?? null;
            $module->image = $request['image'] ?? $module['image'];
            $module->idProgression = $request['idProgression'];
            $module->idMatter = $request['idMatter'] ?? null;
            $module->idTeacher = $request['idTeacher'] ?? null;
            $module->idSchool = $progression->idSchool ?? $module->idSchool;
            $module->idSection = $progression->idSection ?? $module->idSection;
            $module->updated_by = auth()->user()->id;
            $module->save();

            return new ModuleResource($module);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un module
     *
     * @param Module $module
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Module $module,$id)
    {
        try {
            $module = Module::find($id);
            $module->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
