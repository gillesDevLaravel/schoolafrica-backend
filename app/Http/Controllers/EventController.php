<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventArchiveRequest;
use App\Http\Requests\Staffs\EventsGetRequest;
use App\Models\Classes;
use App\Models\Homework;
use App\Models\Notification;
use App\Models\School;
use App\Models\User;
use App\Traits\NotificationsTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\EventResource;
use App\Http\Requests\Staffs\EventRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Event;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

/**
 * @group Event
 */
class EventController extends BaseController
{
    use NotificationsTrait;

    /**
     * Afficher la liste des events
     *
     * @param EventsGetRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(EventsGetRequest $request)
    {
        try {
            $idSection = $request['idSection'] ?? null;
            $classes = $request['classes'] ?? null; // array
            $levels = $request['levels'] ?? null; // array
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $type = $request['type'] ?? null;
            $filter_value = $request['filter_value'];
            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;

            $events = Event::where('idSchool', $request['idSchool']);

            if(!empty($idSection)) $events = $events->where('idSection', $request['idSection']);
            if(!empty($classes)) $events = $events->whereIn('classes', $request['classes']);
            if(!empty($levels)) $events = $events->whereIn('levels', $request['levels']);
            if(!empty($type)) $events = $events->where('type',$request['type']);

            // Filtres par date
            
            if(!empty($date_start)) {
                $events = $events->whereDate('startDate', '>=', $date_start);
            }
            if(!empty($date_end)) {
                $events = $events->whereDate('startDate', '<=', $date_end);
            }

            if(!is_null($filter_value)){
                $events->where(function($query) use ($filter_value) {
                    $query
                        ->where('events.name', 'like', "%$filter_value%")
                        ->orWhere('events.type', 'like', "%$filter_value%")
                        ->orWhere('events.startDate', 'like', "%$filter_value%")
                        ->orWhere('events.endDate', 'like', "%$filter_value%");
                });
            }

            return EventResource::collection(
                $events
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un event
     *
     * @param EventRequest $request
     * @return EventResource|\Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        try {
            $event = $request->validated();

            $event = Event::create([
                'name' => $event['name'],
                'description' => $event['description'],
                'startDate' => $event['startDate'],
                'endDate' => $request['endDate'] ?? null,
                'type' => $request['type'],
                'parentalContribution' => $request['parentalContribution'] ?? null,
                'budget' => $request['budget'] ?? null,
                'idSchool' => $request['idSchool'],
                'classes' => (!is_null($request['classes'])) ? implode(',', $request['classes']) : null,
                'levels' => (!is_null($request['levels'])) ? implode(',', $request['levels']) : null,
                'idSection' => $request['idSection'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            // TODO: Modifier pour prendre en considérations 'levels' et/ou 'classes'

            $school = School::find($request['idSchool']);

            // Notifier tous les concernés par l'évènement
            $users = [];

            /**
             * Si interne, staff
             * Sinon
             *  Si classes ... notifier les parents des élèves des classes
             *  Sinon Si levels notifier les parents des enfants dans les classes de ces levels
             * Sinon notifier tout le monde dans la BD
             */
            if(!is_null($request['classes'])){
                $users = User::where('deleted', 0)
                    ->whereIn('idClasse', $request['classes']);

                $users = (in_array($school->scholar_level, ["University", "CF"]))
                    ? $users->pluck('id')->toArray()
                    : $users->pluck('idParent')->toArray();

            }else if(!is_null($request['levels'])){
                // on récupère d'abord toutes les classes de ces levels
                $classes_id = Classes::whereIn('idLevel', $request['levels'])->pluck('id')->toArray();

                // Ensuite on récupère les personnes de ces classes
                $users = User::where('deleted', 0)
                    ->whereIn('idClasse', $classes_id);

                $users = (in_array($school->scholar_level, ["University", "CF"]))
                    ? $users->pluck('id')->toArray()
                    : $users->pluck('idParent')->toArray();

            }else if($request['type'] == 'interne'){
                // TODO: Notifier tout le staff, la fondatrice et enseignants
                $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.whatsapp_number as whatsapp_number')
                    ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('users.deleted',0)
                    ->whereIn('roles.type', ['staffs', 'Direction'])
                    ->orWhere('roles.id', 5)
                    ->pluck('id')
                    ->toArray();

            }else if($request['type'] == 'externe'){
                $users = User::where('deleted', 0)
                    ->where('idSchool', $request['idSchool'])
                    ->pluck('id')
                    ->toArray();
            }

            Notification::create([
                'notificationable_type' => Event::class,
                'notificationable_id' => $event->id,
                'title' => __('notifs.event_title'),
                'description' => $event->name ,
                'user_id' => null,
                'grouped_users' => json_encode($users)
            ]);
            return new EventResource($event);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un event
     *
     * @param Event $event
     * @param $id
     * @return EventResource|\Illuminate\Http\Response
     */
    public function show(Event $event,$id)
    {
        try {
            $event = Event::find($id);
            return new EventResource($event);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un event
     *
     * @param EventRequest $request
     * @param Event $event
     * @param $id
     * @return EventResource|\Illuminate\Http\Response
     */
    public function update(EventRequest $request,Event $event, $id)
    {
        try {
            $event = Event::find($id);
            $event->name = $request['name'];
            $event->description = $request['description'];
            $event->startDate = $request['startDate'];
            $event->endDate = $request['endDate'];
            $event->type = $request['type'];
            $event->parentalContribution = $request['parentalContribution'] ?? null;
            $event->budget = $request['budget'] ?? null;
            $event->idSchool = $request['idSchool'];
            $event->idSection = $request['idSection'];
            $event->classes = (!is_null($request['classes'])) ? implode(',', $request['classes']) : $event->idClasse;
            $event->levels = (!is_null($request['levels'])) ? implode(',', $request['levels']) : $event->idLevel;
            $event->updated_by = auth()->user()->id;

            $event->save();
            return new EventResource($event);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un event
     *
     * @param Event $event
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Event $event,$id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->forceDelete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des événements à la corbeille (soft delete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */

    public function trash(EventArchiveRequest $request): JsonResponse
    {
        try {
            Event::whereIn('id', $request->ids)->delete();
            Log::info('Événements mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('event.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des événements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

     /**
     * Restaure des événements de la corbeille.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restore(EventArchiveRequest $request): JsonResponse
    {
        try {
            $events = Event::whereIn('id', $request->ids)->restore();
            Log::info('Événements restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('event.restore.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des événements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

}
