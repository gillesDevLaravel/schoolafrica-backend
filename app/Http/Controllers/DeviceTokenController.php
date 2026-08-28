<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDeviceTokenRequest;
use App\Http\Resources\Admin\UserAllResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group DeviceToken
 */
class DeviceTokenController extends BaseController
{
    /**
     * Update device token
     *
     * @param UpdateDeviceTokenRequest $request
     * @return UserAllResource|\Illuminate\Http\Response
     */
    public function update(UpdateDeviceTokenRequest $request)
    {
        try {
            $user = User::find(auth()->user()->id);

            // on va récupérer ce qui est là, unserialize, ajouter le nouveau device_key et serialize pour save en BD
            //TODO: Il faudra aussi modifier l'endroit où cette donnée est récupérée pour l'envoi de notifications
            // ainsi que la méthode permettant de supprimer un device_key

            $user_devices = $user->device_key!=""
                ? explode(";;;", $user->device_key)
                : [];

            array_push($user_devices, $request->token);

            $user->device_key = implode(";;;", array_unique($user_devices));
            $user->updated_by = auth()->user()->id;
            $user->save();

            return new UserAllResource($user);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
