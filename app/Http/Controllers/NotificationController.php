<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Absence;
use App\Models\Event;
use App\Models\FeeUser;
use App\Models\Notification;
use App\Models\PensionUser;
use App\Models\Task;
use App\Models\TeacherObservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @group Notification
 */
class NotificationController extends BaseController
{
    /**
     * Afficher les notifications de l'utilisateur connecté
     *
     * @param NotificationRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(NotificationRequest $request)
    {
        try {

//            return auth()->user()->id;
            $filter_value = $request->filter_value;
            $type = $request->type;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $user_id = Auth::user()->id; // Je récupère les notifications qui concernent l'utilisateur authentifié

            $notifications = Notification::forUser($user_id);

            if(!is_null($type)){
                if($type=="absences"){
                    $typeNotification = Absence::class;
                }elseif ($type=="paiements"){
                    $typeNotification = Transaction::class;
                }elseif ($type=="observations"){
                    $typeNotification = TeacherObservation::class;
                }elseif ($type=="tasks"){
                    $typeNotification = Task::class;
                }elseif ($type=="events"){
                    $typeNotification = Event::class;
                }elseif ($type=="FeeUser"){
                    $typeNotification = FeeUser::class;
                }elseif ($type=="PensionUser"){
                    $typeNotification = PensionUser::class;
                }else{
                    throw new \Exception("Notification type not handled");
                }

                $notifications->where(function($query) use ($typeNotification) {
                    $query->where('notificationable_type', $typeNotification);
                });
            }
            if(!is_null($filter_value)){
                $notifications->where(function($query) use ($filter_value) {
                    $query->where('title', 'like', "%$filter_value%")
                        ->orWhere('description', 'like', "%$filter_value%");
                });
            }

            return NotificationResource::collection(
                $notifications
                    ->orderBy('id','desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
