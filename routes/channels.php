<?php

use App\Models\Key;
use App\Models\PresenceTeacher;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Broadcast::channel('QRCode.SCANNED.{id}', function ($user, $id) {
//
//    if((int) $user->id !== (int) $id){
//        \broadcast(\App\Events\QRCodeKOEvent::broadcast());
//        Log::info("Erreur d'utilisateur sur le qr code");
//        die;
//    }
//
//    Log::info("euhhh"); die;
//    return (int) $user->id === (int) $id;
//});

//Broadcast::channel('presence.{secret}.{route}', function ($user, $secret, $route) {
Broadcast::channel('presence', function ($user) {
    die('channel pesence contacté');

    try {
        $secret = request()->secret;
        $route = request()->route;

        Log::info("$secret");
        Log::info("$route");
        $cle = Key::where('route', $route)->first(); // je récupère la bonne clé pour décrypter le secret

        if(is_null($cle)){
            return $this->sendError("Clé invalide");
        }

        $decryptedDataWithSalt = Crypt::decryptString($secret);

        $qr_idSchool = str_replace($cle->qr_key, '', $decryptedDataWithSalt); // idSchool qui se trouve dans le qr code

        $user_idSchool = auth()->user()->idSchool;  // idSchool qui se trouve dans le compte utilisateur

        if($qr_idSchool != $user_idSchool){
            return $this->sendError("Code QR invalide");
        }

        // Arrivé ici signifie qu'il est bon
        $presenceteacher = PresenceTeacher::where([
            'date' => date("Y-m-d", time()),
            'idTeacher' => auth()->user()->id
        ])->first();

        if(is_null($presenceteacher)){
            $presenceteacher = PresenceTeacher::create([
                'idTeacher' => auth()->user()->id,
                'date' => date("Y-m-d", time()),
                'hour' => date("H:i", time()),
                'arrivalTime' => date("H:i", time()),
                'idSchool' => auth()->user()->idSchool ?? $request['idSchool'],
                'idSection' => auth()->user()->idSection ?? $request['idSection'],
                'created_by' => auth()->user()->id
            ]);

            $msg_log = "arrivée";
        }else if(is_null($presenceteacher->departureTime)){
            $presenceteacher->update([
                'departureTime' => date("H:i", time())
            ]);
            $presenceteacher->save();

            $msg_log = "départ";
        }else{
            throw new \Exception("Impossible de scanner une autre fois pour cette journée. Pour toute erreur, veuillez vous rapprocher de votre administrateur");
        }

        if(isset($msg_log)){
            Log::info("Enregistrement de présence enseignant #$msg_log", ['auteur' => auth()->user()->id, 'presenceteacher' => $presenceteacher->id]);
        }

        return $this->sendResponses("Présence enregistrée avec succès!");
    } catch (\Throwable $th) {
        return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
    }

    Log::info("euhhh"); die;
    return (int) $user->id === (int) $id;
});
