<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staffs\TaskGetAllRequest;
use App\Http\Requests\Staffs\TaskRequest;
use App\Http\Resources\Staffs\TaskResource;
use App\Models\Event;
use App\Models\Notification;
use App\Models\School;
use App\Models\Task;
use App\Models\User;
use App\Traits\NotificationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Task
 */
class TaskController extends BaseController
{
    use NotificationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskGetAllRequest $request)
    {
        try {
            $task  = $request->validated();
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idProject = $request['idProject'] ?? null;
            $idUser = $request['idUser'] ?? null;
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $status = $request->status;
            $priority = $request->priority;
            $due_date = $request->due_date;

            $tasks = Task::query();

            if(!is_null($idSchool)) $tasks = $tasks->where('idSchool', $idSchool);
            if(!is_null($idSection)) $tasks = $tasks->where('idSection', $idSection);
            if(!is_null($idSection)) $tasks = $tasks->where('idSection', $idSection);
            if(!is_null($idProject)) $tasks = $tasks->where('idProject', $idProject);
            if(!is_null($idUser)) $tasks = $tasks->where('idUser',$request['idUser']);

            if(!is_null($filter_value)){
                $tasks->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('due_date', 'like', "%$filter_value%")
                        ->orWhere('status', 'like', "%$filter_value%")
                        ->orWhere('priority', 'like', "%$filter_value%")
                        ->orWhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            if(!is_null($status)) $tasks->where('status', 'like', "%$status%");
            if(!is_null($priority)) $tasks->where('priority', 'like', "%$priority%");
            if(!is_null($due_date)) $tasks->where('due_date', $due_date);

            return TaskResource::collection(
                $tasks
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        try {
            foreach ($request->tasks as $task) {
                $t = new Task();

                $user = User::find($task['idUser']);

                $t->name = $task['name'];
                $t->description = $task['description'] ?? null;
                $t->due_date = $task['due_date'];
                $t->priority = $task['priority'];
                $t->status = $task['status'];
                $t->duree_mise = $task['duree_mise'] ?? null;
                $t->estimation = $task['estimation'] ?? null;
                $t->observation = $task['observation'] ?? null;
                $t->idProject = $task['idProject'] ?? null;
                $t->idUser = $task['idUser'];
                $t->idSchool = $task['idSchool'];
                $t->idSection = $task['idSection'] ?? $user->idSection;
                $t->created_by = auth()->user()->id;
                $t->save();

                Notification::create([
                    'notificationable_type' => Task::class,
                    'notificationable_id' => $t->id,
                    'title' => __('notifs.task_title'),
                    'description' => $t->name,
                    'user_id' => $task['idUser'],
                    'grouped_users' => null
                ]);
            }

            return $this->sendResponse([], "Taches créées avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task,$id)
    {
        try {
            $task = Task::find($id);
            return new TaskResource($task);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task,$id)
    {
        try {
            $task = Task::find($id);
            $task->name = $request['name'] ?? $task['name'];
            $task->description = $request['description'] ?? $task['description'];
            $task->due_date = $request['due_date'] ?? $task['due_date'];
            $task->priority = $request['priority'] ?? $task['priority'];
            $task->status = $request['status'] ?? $task['status'];

            $task->duree_mise = $request['duree_mise'] ?? $task['duree_mise'];
            $task->estimation = $request['estimation'] ?? $task['estimation'];
            $task->observation = $request['observation'] ?? $task['observation'];
            $task->idProject = $request['idProject'] ?? $task['idProject'];

            $task->idUser = $request['idUser'] ?? $task['idUser'];
            $task->idSchool = $request['idSchool'] ?? $task['idSchool'];
            $task->idSection = $request['idSection'] ?? $task['idSection'];
            $task->updated_by = auth()->user()->id;
            $task->save();

            return new TaskResource($task);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task,$id)
    {
        try {
            $task = Task::find($id);
            $task->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
