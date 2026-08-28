<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\GetSMSBalanceRequest;
use App\Http\Requests\Admin\SendSMSRequest;
use App\Http\Requests\Admin\SendSMSToRequest;
use App\Http\Requests\Admin\SMSAllRequest;
use App\Http\Resources\Admin\ReglementInterieurResource;
use App\Http\Resources\Admin\SmsResource;
use App\Models\ReglementInterieur;
use App\Models\Sms;
use App\Models\User;
use App\Traits\SMSTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendSMSController extends BaseController
{
    use SMSTrait;

    /**
     * Envoyer un message à un ou plusieurs utisateurs connaissant leurs IDs
     *
     * @param SendSMSRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(SendSMSRequest $request)
    {
        try {
            $idsSuccess = [];
            $idsFailed = [];
            $data = [];

            // 1️⃣ Récupérer le premier user pour l'idSchool / idSection
            $firstUser = User::select('id', 'idSchool', 'idSection')
                ->whereId($request->idUsers[0])
                ->first();

            // 2️⃣ Charger tous les utilisateurs concernés
            $users = User::whereIn('id', $request->idUsers)
                ->get(['id', 'phone', 'phone_2']);

            // 3️⃣ Construire un mapping phone+phone_2 → idUser
            //    (car un user peut avoir 2 numéros)
            $phoneToUser = [];

            foreach ($users as $user) {
                if (!empty($user->phone)) {
                    $phoneToUser[$user->phone] = $user->id;
                }
                if (!empty($user->phone_2)) {
                    $phoneToUser[$user->phone_2] = $user->id;
                }
            }

            // 4️⃣ Extraire la liste des numéros
            $mobiles = array_keys($phoneToUser);

            // 5️⃣ Appel réel à l'API d'envoi de SMS
            $sendSMS = $this->sendSMS($mobiles, $request->message);

            // 6️⃣ Associer chaque retour à un utilisateur via le numéro
            foreach ($sendSMS['sms'] as $sms) {

                // numéro envoyé
                $phone = $sms['phone'] ?? null;

                // vérifier si on connaît ce numéro
                $userId = $phoneToUser[$phone] ?? null;

                if ($userId === null) {
                    // numéro inconnu => on le met en failed
                    $idsFailed[] = null;
                    continue;
                }

                if ($sms['status'] === 'success') {
                    $idsSuccess[] = $userId;
                } else {
                    $idsFailed[] = $userId;
                }
            }

            $uuid = Str::uuid();

            // 7️⃣ Construction des entrées à insérer en BD
            if (count($idsSuccess) > 0) {
                $data[] = [
                    'uuid'       => $uuid,
                    'idUsers'    => implode(',', $idsSuccess),
                    'message'    => $request->message,
                    'status'     => 'success',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => auth()->user()->id,
                    'idSchool'   => $firstUser->idSchool,
                    'idSection'  => $firstUser->idSection,
                ];
            }

            if (count($idsFailed) > 0) {
                $data[] = [
                    'uuid'       => $uuid,
                    'idUsers'    => implode(',', $idsFailed),
                    'message'    => $request->message,
                    'status'     => 'failed',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => auth()->user()->id,
                    'idSchool'   => $firstUser->idSchool,
                    'idSection'  => $firstUser->idSection,
                ];
            }

            // 8️⃣ Insert de l’historique
            if (!empty($data)) {
                Sms::insert($data);
            }

            // 9️⃣ Vérification du retour API
            if ($sendSMS['responsecode']) {
                return $this->sendResponse($sendSMS, "Message successfully sent");
            } else {
                throw new \Exception($sendSMS['responsedescription']);
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Envoyer un message à un ou plusieurs utisateurs numero de telephone
     *
     * @param SendSMSRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendTo(SendSMSToRequest $request)
    {
        try {
            $firstUser = User::select('id', 'idSchool', 'idSection')
                ->whereId(auth()->id())
                ->first();

            // Récupérer les numéros de téléphones des users associés
            $mobiles = $request['numbers'];

            $sendSMS = $this->sendSMS($mobiles, $request->message);

            $idsSuccess = $idsFailed = array();

            foreach ($sendSMS['sms'] as $key => $sm) {
                if($sm['status'] == 'success'){
                    $idsSuccess[] = $sm['mobileno'];
                } else {
                    $idsFailed[] = $sm['mobileno'];
                }
            }

            $uuid = Str::uuid();

            // Préparer les données pour les utilisateurs qui ont échoué
            (count($idsSuccess) > 0) ? $data[] = [
                'uuid' => $uuid,
                'idUsers' => implode(',', $idsSuccess),
                'message' => $request->message,
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => auth()->user()->id,
                'idSchool' => $firstUser->idSchool,
                'idSection' => $firstUser->idSection,
            ] : null;

            (count($idsFailed) > 0) ? $data[] = [
                'uuid' => $uuid,
                'idUsers' => implode(',', $idsFailed),
                'message' => $request->message,
                'status' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => auth()->user()->id,
                'idSchool' => $firstUser->idSchool,
                'idSection' => $firstUser->idSection,
            ] : null;

            Sms::insert($data);

            if ($sendSMS['responsecode']) {
                return $this->sendResponse($sendSMS, "Message successfully sent");
            }else{
                throw new \Exception($sendSMS['responsedescription']);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Récupérer le solde SMS du compte
     *
     * @param GetSMSBalanceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBalance(GetSMSBalanceRequest $request)
    {
        try {
            $balance = $this->getSMSBalance();

            if ($balance['responsecode']) {
                return $this->sendResponse([
                    'credit' => $balance['credit'],
                    'balance' => $balance['balance'],
                ], "Balance account");
            }else{
                throw new \Exception($balance['responsedescription']);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Lister les SMS envoyés
     *
     * @param SMSAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAll(SMSAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $status = $request->status ?? null;
            $idSchool = $request->idSchool ?? null;
            $idSection = $request->idSection ?? null;
            $date = $request->date ?? null;

            $sms = Sms::query();

            if(!is_null($status)) $sms->whereStatus($status);
            if(!is_null($idSchool)) $sms->where('idSchool', $idSchool);
            if(!is_null($idSection)) $sms->where('idSection', $idSection);

            if(!is_null($date)){
                // Vérifier si la date est déjà au format Y-m-d
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    // Si ce n'est pas le bon format, formater la date
                    $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                } else {
                    // Si c'est déjà au bon format, on garde la date telle quelle
                    $formattedDate = $date;
                }

                $sms = $sms->where('sms.created_at', "like", "%$formattedDate%");
            }

            if(!is_null($filter_value)){
                $sms->where(function($query) use ($filter_value) {
                    $query->where('message', 'like', "%$filter_value%");
                });
            }

            return SmsResource::collection($sms
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
