<?php

namespace App\Traits;

use App\Models\Absence;
use App\Models\Event;
use App\Models\Homework;
use App\Models\Notification;
use App\Models\School;
use App\Models\Task;
use App\Models\TeacherObservation;
use App\Models\User;
use Google\Auth\ApplicationDefaultCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

trait NotificationsTrait
{
    public function sendMobileNotificationViaNotificationsTrait($single_user = true): ?\Illuminate\Http\Response
    {
        return $this->sendWebOrMobileNotification('mobile', (!is_null($this->user_id)));
        //return $this->sendWebOrMobileNotification('mobile', ($this->user_id) ?? $single_user);
    }
    public function sendWebNotificationViaNotificationsTrait($single_user = true): ?\Illuminate\Http\Response
    {
        return $this->sendWebOrMobileNotification('web', $single_user);
    }

    public function sendWebOrMobileNotification($type, $single_user = true)
    {
        try {
            $device_keys = self::getDeviceKeysForNotification($this);

            //get notification type
            $notificationType = $this->notificationable_type;
            $notificationType = class_basename($notificationType);
            $notificationType = strtolower($notificationType);

            return $this->sendNotification($device_keys, $this->title, $this->description, $notificationType);
        }
        catch (\Throwable $th) {
            return Log::warning($th->getMessage());
        }

    }

    /**
     * Récupérer le(s) device_key(s) de celui/ceux qui recevra(ont) la(es) notification(s)
     *
     * @param Notification $notification
     *
     * @return array
     */
    public static function getDeviceKeysForNotification(Notification $notification)
    {
        try {
            if(!is_null($notification->user_id)){
                $devices_list = explode(";;;", User::find($notification->user_id)->device_key);
//                return [User::find($notification->user_id)->device_key];
            }else{
                $devices = User::whereIn('id', json_decode($notification->grouped_users))->pluck('device_key')->toArray();

                $devices_list = [];

                // '$device' ici représente les devices d'un compte
                foreach ($devices as $device) {
                    foreach (array_filter(explode(";;;", $device)) as $item) {
                        $devices_list[] = $item;
                    }
                }
            }

            return array_unique($devices_list);
        }
        catch (\Exception $e){
            Log::critical("Erreur lors de la récupération de device_key pour notifications. Description: " . $e->getMessage());
            die;
        }
    }

    /**
     * Envoyer les notifications aux devices via leur device_key
     *
     * @param array $device_tokens
     * @param $title
     * @param $message
     * @return mixed[]|void
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     */
    private function sendNotification(array $device_tokens, $title, $message, $notificationType = null) {
        foreach ($device_tokens as $token){
            try {
                $firebaseCredentials = json_decode(env('FIREBASE_CREDENTIALS'), true);

                if(is_null($firebaseCredentials)){
                    Log::warning("env FIREBASE_CREDENTIALS not found.");
                    return null;
                }

                $factory = (new Factory)->withServiceAccount($firebaseCredentials);

                $messaging = $factory->createMessaging();

                $notif = $messaging->send([
                    'token' => $token,
                    "content_available" => true,
                    'notification' => [
                        'title' => $title,
                        'body' => $message,
                        //'type' => $notificationType,
                    ],
                    'data' => [
                        'type' => $notificationType, 
                    ]
                ]);

                Log::info("Notification sent {$notificationType}: " . json_encode($notif));
            } catch (\Exception $e) {
                Log::warning('Error sending message:'. $e->getMessage());
            }
        }

        return null;
    }
}
