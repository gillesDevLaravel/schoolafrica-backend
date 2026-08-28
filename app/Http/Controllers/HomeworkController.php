<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Matter;
use App\Models\Notification;
use App\Models\School;
use App\Models\User;
use App\Traits\NotificationsTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Homework;
use App\Http\Requests\Staffs\HomeworkRequest;
use App\Http\Requests\Staffs\HomeworkGetAllRequest;
use App\Http\Resources\Staffs\HomeworkResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Homework
 */
class HomeworkController extends BaseController
{
    use NotificationsTrait;

    /**
     * Afficher la liste des Homeworks
     *
     * @param HomeworkGetAllRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(HomeworkGetAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $idSection = $request['idSection'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idMatter = $request['idMatter'] ?? null;
            $idBook = $request['idBook'] ?? null;
            $deadline = $request['deadline'] ?? null;
            $canSubmitHomework = $request['canSubmitHomework'] ?? false;
            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;

            $homeworks = Homework::query();

            if (!empty($request['idClasse'])) {

                $homeworks->where('homework.idClasse', $request['idClasse']);
            } elseif (!empty($request['idSchool'])) {

                $homeworks->where('homework.idSchool', $request['idSchool']);
            }
            if (!is_null($date_start) && !is_null($date_end)) {
                $homeworks = $homeworks->whereBetween('homework.deadline', [$date_start, $date_end]);
            }
            if(!is_null($idSection)) $homeworks = $homeworks->where('homework.idSection',$request['idSection']);
            //if(!is_null($idClasse)) $homeworks = $homeworks->where('homework.idClasse',$request['idClasse']);
            if(!is_null($idMatter)) $homeworks = $homeworks->where('homework.idMatter',$request['idMatter']);
            if(!is_null($idBook)) $homeworks = $homeworks->where('homework.idBook',$request['idBook']);
            if(!is_null($deadline)) $homeworks = $homeworks->where('homework.deadline', "LIKE", "%$deadline%");
            if($canSubmitHomework) $homeworks = $homeworks->where('homework.deadline', '>', NOW());

            if(!empty($request['idClasse']) && !empty($request['idTeacher'])){
                $homeworks = $homeworks->select('homework.id as id','homework.name as name','homework.description as description','homework.deadline as deadline','homework.idSchool as idSchool','homework.idSection as idSection','homework.idClasse as idClasse','homework.idTeacher as idTeacher',
                    'homework.answer as answer','homework.status as status','homework.idMatter as idMatter','homework.created_at as created_at')
                    ->join('classe_has_user','classe_has_user.classes_id','=','homework.idClasse')
                    ->join('users','users.id','=','classe_has_user.user_id')
                    ->where('homework.idSchool',$request['idSchool'])
//                    ->where('homework.idSection',$request['idSection'])
                    ->where('homework.idClasse',$request['idClasse'])
                    ->where('classe_has_user.user_id',$request['idTeacher']);
            }else if(!empty($request['idTeacher'])){
                $homeworks = $homeworks->select('homework.id as id','homework.name as name','homework.description as description','homework.deadline as deadline','homework.idSchool as idSchool','homework.idSection as idSection','homework.idClasse as idClasse','homework.idTeacher as idTeacher','homework.answer as answer','homework.status as status','homework.idMatter as idMatter','homework.created_at as created_at')
                    ->join('classe_has_user','classe_has_user.classes_id','=','homework.idClasse')
                    ->join('users','users.id','=','classe_has_user.user_id')
                //    ->where('homework.idSchool',$request['idSchool'])
//                    ->where('homework.idSection',$request['idSection'])
                    ->where('classe_has_user.user_id',$request['idTeacher']);
            }

            return HomeworkResource::collection(
                $homeworks
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems
                    )
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un Homework
     *
     * @param HomeworkRequest $request
     * @return HomeworkResource|JsonResponse
     */
    public function store(HomeworkRequest $request)
    {
        try {
            $homework = $request->validated();

            $homework = new Homework();
            $classe = Classes::findOrFail($request['idClasse']);

            $homework->name = $request['name'];
            $homework->deadline = $request['deadline'];
            $homework->description = $request['description'] ?? null;
            $homework->answer = $request['answer'] ?? null;
            $homework->status = $request['status'] ?? null;
            $homework->idClasse = $request['idClasse'];
            $homework->idMatter = $request['idMatter'];
            $homework->idTeacher = $request['idTeacher'] ?? null;
            $homework->idBook = $request['idBook'] ?? null;
            $homework->idSchool = $classe->idSchool;
            $homework->idSection = $classe->idSection;
            $homework->created_by = auth()->user()->id;
            $homework->save();

            // TODO: On vérifie le type d'école pour avoir le bon idUser qui recevra & verra la notif

            $matter = Matter::find($homework->idMatter);

            $school = School::find($homework->idSchool);

            $users = User::where(['idClasse' => $homework->idClasse, 'deleted' => 0]);

            // Notifier tous les élèves ou parents (dépendant du type d'école) de la classe en question
            Notification::create([
                'notificationable_type' => Homework::class,
                'notificationable_id' => $homework->id,
                'title' => __('notifs.homework_title', ['matter_name' => $matter->name, 'classe_name' => $homework->idClasse]),
                'description' => $homework->description ?? __('notifs.homework_desc', ['matter_name' => $matter->name]),
                'user_id' => null,
                'grouped_users' => (in_array($school->scholar_level, ["University", "CF"]))
                    ? json_encode($users->pluck('id')->toArray())
                    : json_encode(array_values(array_unique($users->pluck('idParent')->toArray()))),
            ]);
            return new HomeworkResource($homework);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un Homework
     *
     * @param Homework $homework
     * @param $id int
     * @return HomeworkResource|\Illuminate\Http\Response
     */
    public function show(Homework $homework,$id)
    {
        try {
            $homework = Homework::find($id);
            return new HomeworkResource($homework);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un Homework
     *
     * @param HomeworkRequest $request
     * @param Homework $homework
     * @param $id int
     * @return HomeworkResource|\Illuminate\Http\Response
     */
    public function update(HomeworkRequest $request, Homework $homework,$id)
    {
        try {
            $homework = Homework::find($id);
            $homework->name = $request['name'];
            $homework->deadline = $request['deadline'];
            $homework->description = $request['description'] ?? $homework['description'];
            $homework->answer = $request['answer'] ?? $homework['answer'];
            $homework->status = $request['status'] ?? $homework['status'];
            $homework->idClasse = $request['idClasse'];
            $homework->idMatter = $request['idMatter'];
            $homework->idTeacher = $request['idTeacher'] ?? $homework['idTeacher'];
            $homework->idBook = $request['idBook'] ?? $homework['idBook'];
            $homework->idSchool = $request['idSchool'];
            $homework->idSection = $request['idSection'];
            $homework->updated_by = auth()->user()->id;
            $homework->save();

            return new HomeworkResource($homework);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un Homework
     *
     * @param Homework $homework
     * @param $id int
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Homework $homework,$id)
    {
        try {
            $homework = Homework::find($id);

//            $homework->delete();
            $homework->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
