<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LocationStoreRequest;
use App\Http\Requests\Admin\ProjectAllRequest;
use App\Http\Requests\Admin\ProjectBulkStoreRequest;
use App\Http\Requests\Admin\ProjectStoreRequest;
use App\Http\Resources\Admin\LocationResource;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\Location;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends BaseController
{
    /**
     * Lister les projets non supprimés
     *
     * @param ProjectAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProjectAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $projects = Project::query();

            if(!is_null($filter_value)){
                $projects->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhere('name', 'like', "%$filter_value%");
                });
            }

            return ProjectResource::collection(
                $projects
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un projet
     *
     * @param $idProject
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     */
    public function show($idProject)
    {
        try {
            $project = Project::findOrFail($idProject);
            return ProjectResource::make($project);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une nouveau projet
     *
     * @param ProjectStoreRequest $request
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     */
    public function store(ProjectStoreRequest $request)
    {
        try {
            $new_project = Project::firstOrCreate([
                'name' => $request->name,
                'description' => $request->description
            ],[
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'created_by' => auth()->user()->id,
            ]);

            $new_project->users()->attach($request->users);

            return ProjectResource::make($new_project);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer plusieurs projets
     *
     * @param ProjectBulkStoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function bulkStore(ProjectBulkStoreRequest $request)
    {
        try {
            $projects = $request->projects;
            $new_projects = array();

            foreach ($projects as $project) {
                $tmp_project = Project::firstOrCreate([
                    'name' => $project['name'],
                    'description' => $project['description']
                ],[
                    'name' => $project['name'],
                    'description' => $project['description'],
                    'start_date' => $project['start_date'],
                    'end_date' => $project['end_date'],
                    'created_by' => auth()->user()->id,
                ]);

                $tmp_project->users()->sync($project['users']);

                $new_projects[] = $tmp_project;
            }

            return ProjectResource::collection(array_unique($new_projects));
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un projet
     *
     * @param ProjectStoreRequest $request
     * @param $id
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     */
    public function update(ProjectStoreRequest $request, $id)
    {
        try {
            $project = Project::findOrFail($id);

            $project->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'updated_by' => auth()->user()->id,
            ]);

            $project->users()->sync($request->users);

            return ProjectResource::make($project);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer un projet à la corbeille
     *
     * @param $id
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     */
    public function trash($id)
    {
        try {
            $project = Project::findOrFail($id);

            $project->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return ProjectResource::make($project);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer un projet de la corbeille
     * NB: Il n'est pas possible de restaurer un projet qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return ProjectResource|\Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        try {
            $project = Project::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $project->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);

            return ProjectResource::make($project);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
