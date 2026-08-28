<?php

namespace App\Http\Resources;

use App\Models\Absence;
use App\Models\Event;
use App\Models\FeeUser;
use App\Models\PensionUser;
use App\Models\Task;
use App\Models\TeacherObservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->notificationable_type==Absence::class){
            $typeNotification = "absences";
        }elseif ($this->notificationable_type==Transaction::class){
            $typeNotification = "paiements";
        }elseif ($this->notificationable_type==TeacherObservation::class){
            $typeNotification = "observations";
        }elseif ($this->notificationable_type==Task::class){
            $typeNotification = "tasks";
        }elseif ($this->notificationable_type==Event::class){
            $typeNotification = "events";
        }elseif ($this->notificationable_type==FeeUser::class){
            $typeNotification = "FeeUser";
        }elseif ($this->notificationable_type==PensionUser::class){
            $typeNotification = "PensionUser";
        }else{
            $typeNotification = "N/A";
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
//            'user' => UserResource::make(User::find($this->user_id)),
//            'grouped_users' => !is_null($this->grouped_users) ? UserResource::collection(User::whereIn('id', json_decode($this->grouped_users, true))->get()) : null,
//            'notificationable_id' => $this->notificationable_id,
//            'notificationable_type' => $this->notificationable_type,
            'type' => $typeNotification,
//            'notificationable' => $this->notificationable,
            'created_at' => $this->created_at
        ];
    }
}
