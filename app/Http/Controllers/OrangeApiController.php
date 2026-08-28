<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staffs\MakeWebPaymentRequest;
use App\Jobs\SendMailJob;
use App\Jobs\SendSMSJob;
use App\Mail\PaymentInitiatedMail;
use App\Mail\RemboursementMail;
use App\Models\Establishment;
use App\Models\FeeUser;
use App\Models\PensionUser;
use App\Models\School;
use App\Models\Transaction;
use App\Services\PaymentTransportUserService;
use App\Traits\CheckIfRegistrationFeeIsPaidTrait;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Services\PensionUserService;
use App\Services\FeeUserService;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Log;

/**
 * @group OrangeMoney
 */
class OrangeApiController extends BaseController
{
    use CheckIfRegistrationFeeIsPaidTrait;

    protected $globalTransactionData = [];
    protected const TOKEN_URL = 'https://api.orange.com/oauth/v3/token';
    protected const PAYMENT_INIT_URL = 'https://api.orange.com/orange-money-webpay/cm/v1/webpayment';
    protected const STATUS_CHECK_URL = 'https://api.orange.com/orange-money-webpay/cm/v1/transactionstatus';


    protected $pensionUserService, $feeUserService;

    public function __construct(PensionUserService $pensionUserService, FeeUserService $feeUserService)
    {
        $this->pensionUserService = $pensionUserService;
        $this->feeUserService = $feeUserService;
    }


    public function getToken()
    {
        try {
            $client = new Client();

            $authorizationHeader = 'Basic SlJqdGR6dk5mSkpBVnpNUmRKUlJ6SFJRWEZQaXlzVW06MHZodWlvZVdDbHcyV2JhNA==';
            $response = $client->post(self::TOKEN_URL, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $authorizationHeader
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'verify' => false,
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return $data;
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
            //throw $th;
        }
    }

    public function makeWebPayment(MakeWebPaymentRequest $request)
    {
        try {
            $tokenData = $this->getToken();
            $tabTransac = array();

            if(isset($tokenData['access_token'])) {


                if (empty($request['idStudent']) || empty($request['idSchool']) || empty($request['idSection']) || empty($request['amount']) || empty($request['payment_mode'])) {
                    return $this->sendError('Certaines valeurs de transaction sont manquantes.');
                }

                $erreurBalance = $this->checkBalanceBeforePayment($request);
                if ($erreurBalance != null) {
                    return $erreurBalance;
                }

                try {
                    $transaction = Transaction::create([
                        'access_token' => $tokenData['access_token'],
                        'expires_in' => time() + $tokenData['expires_in'],
                        'idSchool' => $request['idSchool'],
                        'idSection' => $request['idSection'],
                        'idFee' => $request['idFee'] ?? null,
                        'idLevel' => $request['idLevel'] ?? null,
                        'idStudent' => $request['idStudent'],
                        'idPension' => $request['idPension'] ?? null,
                        'payment_mode' => $request['payment_mode'],
                        'created_by' => auth()->user()->id
                    ]);
                } catch (\Throwable $th) {

                    return $this->sendError('Une erreur est survenue lors de la création de la transaction.'. $th->getMessage());
                }


                if ($transaction['expires_in'] > time()) {

                    $client = new Client();
                    $orderId = uniqid();

                    $response = $client->post('https://api.orange.com/orange-money-webpay/cm/v1/webpayment', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $transaction['access_token'],
                            'Content-Type' => 'application/json'
                        ],
                        'json' => [
                            "merchant_key" => "56c75016",
                            "currency" => "XAF",
                            "order_id" => $orderId,
                            "amount" => $request['amount'],
                            "reference" => $request['reference'],
                            "lang" => "fr",
                            "return_url" => "http://app.ms-school.net/return",
                            "cancel_url" => "http://app.ms-school.net/cancel",
                            "notif_url" => "http://app.ms-school.net/notification"
                        ],
                        'verify' => false,
                    ]);

                    $body = $response->getBody();
                    $responseData = json_decode($body, true);

                    if (!empty($responseData)) {

                        if($responseData['status'] == 201) {

                            $transaction->update([
                                'order_id' => $orderId,
                                'amount' => $request['amount'],
                                'reference' => $request['reference'],
                                'pay_token' => $responseData['pay_token'],
                                'status' => "INITIATED",
                                'payment_url' => $responseData['payment_url'],
                                'notif_token' => $responseData['notif_token'],
                                'message' => $responseData['message'],
                            ]);

                            if ($responseData['payment_url']) {
                                $tabTransac["idTransaction"] = $transaction->id;
                                $tabTransac["payment_url"] = $responseData['payment_url'];
                                return $this->sendResponses($tabTransac);
                            } else {
                                return $this->sendError("Impossible de rediriger l'utilisateur sur la page de paiement");
                            }
                        }
                        else{
                            return $this->sendError(__('transaction.paiement_service.error'), [], $response->getStatusCode());
                        }
                    }  else {

                        return $this->sendError('Web payment failed', [], 400);
                    }
                }
                else {
                    return $this->sendError('La session a expiré', [], 401);
                }
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('transaction.create.error'), null, 404, $th->getMessage());
        }


        return $this->sendError('La session a expiré', [], 401);
    }

    public function getStatusPayment(Request $request, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $responseDataSecond = null;

            $retryCount = 3; // Nombre de tentatives de réessai
            $currentRetry = 0;

            while ($currentRetry < $retryCount) {
                try {
                    if ($transaction['expires_in'] > time()) {
                        do {
                            $responseDataSecond = $this->checkTransactionStatus($transaction);
                        } while ($responseDataSecond['status'] == 'INITIATED' || $responseDataSecond['status'] == 'PENDING');
                        sleep(10);
                    } else {
                        $tokenData = $this->getToken();
                        $transaction->update([
                            'access_token' => $tokenData['access_token'],
                            'expires_in' => time() + $tokenData['expires_in'],
                        ]);

                        do {
                            $responseDataSecond = $this->checkTransactionStatus($transaction);
                        } while ($responseDataSecond['status'] == 'INITIATED' || $responseDataSecond['status'] == 'PENDING');
                        sleep(30);
                    }

                    if (!empty($responseDataSecond)) {
                        if($responseDataSecond['status'] == 'SUCCESS' && $transaction['idPension'] != null){
                            try {
                                $requestData = [
                                    'idStudent' => $transaction['idStudent'],
                                    'idPension' => $transaction['idPension'],
                                    'idSchool' => $transaction['idSchool'],
                                    'idSection' => $transaction['idSection'],
                                    'advancePayment' => $transaction['amount'],
                                    'payment_mode' => $transaction['payment_mode'],
                                ];
                                $result = $this->pensionUserService->storePensionUser($requestData);
                                return [
                                    'data' => $responseDataSecond,
                                    'result' => $result,
                                ];
                            } catch (ServiceException $se) {
                                return $this->sendError('Service Error', $se->getMessage());
                            } catch (\Throwable $th) {
                                return $this->sendError('Error', $th->getMessage());
                            }
                        }
                        elseif($responseDataSecond['status'] == 'SUCCESS' && $transaction['idFee'] != null && $transaction['idLevel'] != null){
                            try {
                                $requestData = [
                                    'idStudent' => $transaction['idStudent'],
                                    'idFee' => $transaction['idFee'],
                                    'idLevel' => $transaction['idLevel'],
                                    'idSchool' => $transaction['idSchool'],
                                    'idSection' => $transaction['idSection'],
                                    'advancePayment' => $transaction['amount'],
                                    'payment_mode' => $transaction['payment_mode'],
                                ];
                                $result = $this->feeUserService->storeFeeUser($requestData);
                                return [
                                    'data' => $responseDataSecond,
                                    'result' => $result,
                                ];
                            } catch (ServiceException $se) {
                                return $this->sendError('Service Error', $se->getMessage());
                            } catch (\Throwable $th) {
                                return $this->sendError('Error', $th->getMessage());
                            }
                        }
                        else{
                            return $this->sendResponse($responseDataSecond, 'Statut de la transaction récupéré avec succès');
                        }
                    }
                } catch (RequestException $e) {
                    // Gérer les erreurs de requête HTTP (503, 500, etc.)
                    if ($e->getResponse() !== null && ($e->getResponse()->getStatusCode() == 503 || $e->getResponse()->getStatusCode() == 500)) {
                        // Journaliser l'erreur si nécessaire
                        Log::error('Erreur HTTP: ' . $e->getResponse()->getStatusCode() . ' - ' . $e->getResponse()->getReasonPhrase());

                        // Incrémenter le compteur de réessai
                        $currentRetry++;

                        // Attendre un court laps de temps avant de réessayer
                        usleep(500000); // Attendre 500 millisecondes (0.5 seconde) avant de réessayer
                        continue; // Réessayer la requête
                    } else {
                        // Si une autre erreur se produit, la relancer
                        throw $e;
                    }
                }
            }

            // Si aucune réponse n'est reçue après plusieurs tentatives, renvoyer une erreur
            return $this->sendError('Impossible de récupérer le statut de la transaction après plusieurs tentatives.');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    private function checkTransactionStatus($transaction)
    {
        ini_set('max_execution_time', 300);
        $client = new Client();
        $responseSecond = $client->post('https://api.orange.com/orange-money-webpay/cm/v1/transactionstatus', [
            'headers' => [
                'Authorization' => 'Bearer ' . $transaction['access_token'],
                'Content-Type' => 'application/json'
            ],
            'json' => [
                "order_id" => $transaction['order_id'],
                "amount" => $transaction['amount'],
                "pay_token" => $transaction['pay_token']
            ]
        ]);

        $bodySecond = $responseSecond->getBody();
        $responseDataSecond = json_decode($bodySecond, true);

        if (!empty($responseDataSecond)) {
            $transaction->update([
                'status' => $responseDataSecond['status'],
                'updated_by' => auth()->user()->id,
            ]);
        }

        return $responseDataSecond;
    }


    /*************************************************** MOBILE ***************************************************************/


    public function getMobileToken()
    {
        try {
            $client = new Client();

            $username = 'puDfbZSIm2utLf50zVP2_jlVGCoa';
            $password = 'dtPR05bQZT3c2QEFjeXJTqyJEKEa';
            $authorizationHeader = 'Basic ' . base64_encode($username . ':' . $password);

            $response = $client->post('https://api-s1.orange.cm/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $authorizationHeader
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                //'verify' => false,
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return $data;
        } catch (\Throwable $th) {
            //Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
            throw $th;
        }
    }


    public function makeMerchantRequest(Request $request)
    {
        try {
            $tokenData = $this->getMobileToken();

            if (isset($tokenData['access_token'])) {

                if (empty($request['idStudent']) || empty($request['idSchool']) || empty($request['idSection']) || empty($request['amount']) || empty($request['payment_mode'])) {
                    return $this->sendError('Certaines valeurs de transaction sont manquantes.');
                }

                try {

                    $transaction = Transaction::create([
                        'access_token' => $tokenData['access_token'],
                        'expires_in' => time() + $tokenData['expires_in'],
                        'idSchool' => $request['idSchool'],
                        'idSection' => $request['idSection'],
                        'idFee' => $request['idFee'] ?? null,
                        'idLevel' => $request['idLevel'] ?? null,
                        'idStudent' => $request['idStudent'],
                        'idPension' => $request['idPension'] ?? null,
                        'transport_user_id' => $request['transport_user_id'] ?? null,
                        'payment_mode' => $request['payment_mode'],
                        'created_by' => auth()->user()->id
                    ]);

                    // TODO: Notifier MS-School qu'une tranasction a été lancée... pour que l'admin puisse checker si nécessaire
                    $mailable = new PaymentInitiatedMail(
                        $request['idSchool'],
                        $request['idStudent'],
                        $request['idClasse'],
                        $request['phonePayeur'],
                        $request['amount'],
                        $transaction->id
                    );
                    $recipients = ['orangemoney@ms-school.net', 'houbadesire@gmail.com', 'b.djoulde@mh-technologie.com'];

                    SendMailJob::dispatch($mailable, $recipients, 'smtp2');
                } catch (\Throwable $th) {
                    Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//                    return $this->sendError('Une erreur est survenue lors de la création de la transaction.'. $th->getMessage());
                }


                $client = new Client();
                $tab = [
                    'transactionId' => $transaction->id,
                    'access_token' => $tokenData['access_token']
                ];

                $response = $client->post('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/init', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $tokenData['access_token'],
                        'Content-Type' => 'application/json',
                        'X-AUTH-TOKEN' => 'WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk='
                    ],
                ]);

                $body = $response->getBody();
                $responseData = json_decode($body, true);

                if (empty($responseData) || $response->getStatusCode() !== 200 || !isset($responseData['data']['payToken'])) {
                    return $this->sendError('Erreur lors de l\'initialisation de la demande de paiement', [], $response->getStatusCode());
                }

                $transaction->update(['pay_token' => $responseData['data']['payToken']]);
                $tab['payToken'] = $responseData['data']['payToken'];
                return $tab;
            } else {
                return $this->sendError('Impossible d\'obtenir le jeton d\'accès', [], 401);
            }
        } catch (\Throwable $th) {
            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function makeMerchantPayRequest(Request $request)
    {
        try {
            $request['reference'] = mb_substr($request['reference'], 0, 30);

            // Vérifier le solde avant de lancer le paiement
            $erreurBalance = $this->checkBalanceBeforePayment($request);
            if ($erreurBalance != null) {
                return $erreurBalance;
            }

            // Créer la transaction et obtenir le payToken
            $data = $this->makeMerchantRequest($request);
            if (!isset($data['access_token']) || !isset($data['transactionId']) || !isset($data['payToken'])) {
                return $this->sendError('Impossible d\'obtenir le jeton d\'accès ou la transaction', [], 401);
            }

            $transaction = Transaction::find($data['transactionId']);
            if (!$transaction) {
                return $this->sendError('Transaction introuvable', [], 404);
            }

            $orderId = uniqid();

            $payRequestData = [
//                "notifUrl" => "http://app.ms-school.net/notification",
                "notifUrl" => route('om.callback'),
                "channelUserMsisdn" => "659924750", // peut être dynamique
                "amount" => $request['amount'],
                "subscriberMsisdn" =>  $request['phonePayeur'],
                "pin" => "3915", // sécuriser cette valeur
                "orderId" => $orderId,
                "description" => $request['reference'],
                "payToken" => $data['payToken']
            ];

            $client = new Client();
            try {
                $response = $client->post('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/pay', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $data['access_token'],
                        'Content-Type' => 'application/json',
                        'X-AUTH-TOKEN' => 'WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk='
                    ],
                    'json' => $payRequestData
                ]);

                $body = $response->getBody();
                $responseData = json_decode($body, true);

                if (!empty($responseData) && ($response->getStatusCode() == 201 || $response->getStatusCode() == 200)) {

                    // Paiement initié avec succès
                    $transaction->update([
                        'order_id' => $orderId,
                        'amount' => intval($request['amount']),
                        'reference' => $request['reference'],
                        'status' => "PENDING",
                        'message' => $responseData['message'] ?? 'En attente',
                        'compteEmeteur' => $request['phonePayeur'],
                    ]);

                    return $this->sendResponses([
                        "idTransaction" => $transaction->id,
                        "status" => "PENDING",
                        "message" => $responseData['message'] ?? 'En attente'
                    ]);

                } else {
                    // Gérer les erreurs spécifiques
                    if (!empty($responseData['message'])) {
                        if (str_contains($responseData['message'], 'Beneficiaire introuvable')) {
                            return $this->sendError('Le numéro du bénéficiaire est incorrect', [], $response->getStatusCode());
                        }
                        if (str_contains($responseData['message'], 'Le solde du compte du payeur est insuffisant')) {
                            return $this->sendError('Le solde du compte du payeur est insuffisant', [], $response->getStatusCode());
                        }
                    }
                    // Autres erreurs
                    $errorMessage = $responseData['message'] ?? 'Erreur lors du paiement';
                    return $this->sendError($errorMessage, [], $response->getStatusCode());
                }

            } catch (RequestException $e) {
                // Gérer les erreurs HTTP
                $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
                $responseBody = $e->getResponse() ? (string)$e->getResponse()->getBody() : '';

                // Identifier les erreurs connues
                if (str_contains($responseBody, 'Beneficiaire introuvable')) {
                    return $this->sendError('Le numéro du bénéficiaire est incorrect', [], $statusCode);
                }
                if (str_contains($responseBody, 'Le solde du compte du payeur est insuffisant')) {
                    return $this->sendError('Le solde du compte du payeur est insuffisant', [], $statusCode);
                }

                Log::error('Erreur paiement Orange Money: ' . $e->getMessage() . ' - ' . $responseBody);
                return $this->sendError('Erreur lors du paiement', [], $statusCode);
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError('Une erreur est survenue lors de la création de la transaction');
        }
    }


    public function getPaymentStatusMob($id)
    {
        try {
            $transaction = Transaction::find($id);
            $responseDataSecond = null;
            $tabResponse = array();

            $retryCount = 3; // Nombre de tentatives de réessai
            $currentRetry = 0;
            $retryDelay = 30; // Délai initial de réessai en secondes

            if (PensionUser::where('idTransaction', $transaction['id'])->exists()) {
                return $this->sendError("La transaction a déjà été enregistrée pour une pension");
            } elseif (FeeUser::where('idTransaction', $transaction['id'])->exists()) {
                return $this->sendError("La transaction a déjà été enregistrée pour un frais");
            }

            while ($currentRetry < $retryCount) {
                try {
                    if ($transaction['expires_in'] > time()) {
                        do {
                            $responseDataSecond = $this->checkTransactionStatusMob($transaction);
                        } while ($responseDataSecond['data']['status'] == 'INITIATED' || $responseDataSecond['data']['status'] == 'PENDING');
                    } else {
                        $tokenData = $this->getMobileToken();
                        $transaction->update([
                            'access_token' => $tokenData['access_token'],
                            'expires_in' => time() + $tokenData['expires_in'],
                        ]);
                        do {
                            $responseDataSecond = $this->checkTransactionStatusMob($transaction);
                        } while ($responseDataSecond['data']['status'] == 'INITIATED' || $responseDataSecond['data']['status'] == 'PENDING');
                    }

                    // Avant d'envoyer le montant pour enregistrement, on va vérifier comment l'établissement gère les frais om
                    // Si c'est l'utilisateur qui paie, on va retirer 2% sur le montant qu'il a versé avant d'enregistrer
                    $establishment = Establishment::find(School::find($transaction['idSchool'])->idEstablishment);
                    $amount = $transaction['amount'] * 100 / 102;
//                    $amount = ($establishment->pay_om_fees) ? ($transaction['amount'] * 100 / 102) : $transaction['amount'];

                    if (!empty($responseDataSecond)) {
                        if($responseDataSecond["data"]['status'] == 'SUCCESSFULL' && $transaction['idPension'] != null){

                            try {
                                $requestData = [
                                    'idTransaction' => $transaction['id'],
                                    'idStudent' => $transaction['idStudent'],
                                    'idPension' => $transaction['idPension'],
                                    'idSchool' => $transaction['idSchool'],
                                    'idSection' => $transaction['idSection'],
                                    'advancePayment' => $amount, // voir ligne 499
                                    'payment_mode' => $transaction['payment_mode'],
                                ];

                                $result = $this->pensionUserService->storePensionUser($requestData);

                                $tabResponse["txnid"] = $responseDataSecond["data"]["txnid"];
                                $tabResponse["inittxnmessage"] = $responseDataSecond["data"]["inittxnmessage"];
                                $tabResponse["inittxnstatus"] = $responseDataSecond["data"]["inittxnstatus"];
                                $tabResponse["status"] = $responseDataSecond["data"]["status"];
                                return [
                                    'data' => $tabResponse,
                                    'result' => $result,
                                ];
                            } catch (ServiceException $se) {
                                return $this->sendError('Service Error', $se->getMessage());
                            } catch (\Throwable $th) {
                                return $this->sendError('Error', $th->getMessage());
                            }
                        }
                        elseif($responseDataSecond["data"]['status'] == 'SUCCESSFULL' && $transaction['idFee'] != null && $transaction['idLevel'] != null){
                            try {
                                $requestData = [
                                    'idStudent' => $transaction['idStudent'],
                                    'idFee' => $transaction['idFee'],
                                    'idLevel' => $transaction['idLevel'],
                                    'idSchool' => $transaction['idSchool'],
                                    'idSection' => $transaction['idSection'],
                                    'advancePayment' => $amount, // voir ligne 499
                                    'payment_mode' => $transaction['payment_mode'],
                                ];
                                $result = $this->feeUserService->storeFeeUser($requestData);

                                $tabResponse["txnid"] = $responseDataSecond["data"]["txnid"];
                                $tabResponse["inittxnmessage"] = $responseDataSecond["data"]["inittxnmessage"];
                                $tabResponse["inittxnstatus"] = $responseDataSecond["data"]["inittxnstatus"];
                                $tabResponse["status"] = $responseDataSecond["data"]["status"];
                                return [
                                    'data' => $tabResponse,
                                    'result' => $result,
                                    'registrationPaid' => $this->isRegistrationPaid($transaction['idStudent'])
//                                    'registrationPaid' => $this->isRegistrationPaid($transaction['idSchool'], $transaction['idStudent'], $user->role, $transaction['idLevel'])
                                ];
                            } catch (ServiceException $se) {
                                return $this->sendError('Service Error', $se->getMessage());
                            } catch (\Throwable $th) {
                                return $this->sendError('Error', $th->getMessage());
                            }
                        }elseif ($responseDataSecond["data"]['status'] === 'SUCCESSFULL' && $transaction['transport_user_id'] != null) {
                            try {
                                $requestData = [
                                    'transport_user_id' => $transaction['transport_user_id'],
                                    'advance_payment'   => $amount,
                                    'payment_mode'      => $transaction['payment_mode'],
                                    'payment_date'      => $transaction['payment_date'] ?? now(),
                                ];

                                [$success, $data] = app(PaymentTransportUserService::class)->createPayment($requestData);

                                if (!$success) {
                                    return $this->sendError($data, null, 500);
                                }

                                return [
                                    'data' => [
                                        'txnid' => $transaction->order_id,
                                        'status' => 'SUCCESSFUL',
                                        'registrationPaid' => $this->isRegistrationPaid($transaction['idStudent']),
                                    ],
                                    'result' => $data,
                                ];
                            } catch (\Throwable $th) {
                                Log::error('Erreur Paiement Transport : ' . $th->getMessage());
                                return $this->sendError('Erreur lors du traitement du paiement transport');
                            }
                        }else{
                            $tabResponse["txnid"] = $responseDataSecond["data"]["txnid"];
                            $tabResponse["inittxnmessage"] = $responseDataSecond["data"]["inittxnmessage"];
                            $tabResponse["inittxnstatus"] = $responseDataSecond["data"]["inittxnstatus"];
                            $tabResponse["status"] = $responseDataSecond["data"]["status"];
                            return $this->sendResponses($tabResponse);
                        }

                    }
                } catch (RequestException $e) {
                    $currentRetry++;
                    if ($currentRetry < $retryCount) {
                        $retryDelay *= 1.5; // Backoff exponentiel
                        usleep($retryDelay * 1000000); // Convertir le délai en microsecondes
                        continue; // Réessayer
                    } else {
                        if ($e->getResponse() !== null && ($e->getResponse()->getStatusCode() == 503 || $e->getResponse()->getStatusCode() == 500)) {
                            Log::error('HTTP Error: ' . $e->getResponse()->getStatusCode() . ' - ' . $e->getResponse()->getReasonPhrase());
                            // Vous pouvez ajouter d'autres stratégies de gestion d'erreur ici si nécessaire
                        } else {
                            throw $e; // Lancer l'exception si ce n'est pas une erreur 503 ou 500
                        }
                    }
                }
            }

            // Si aucune réponse n'est reçue après plusieurs tentatives, renvoyer une erreur
            $this->dispatch(new SendSMSJob(["237691773680"], "Une transaction(id=".$id.") a mis trop long du côté de la base ".env('APP_NAME')."."));
            return $this->sendError('Failed to retrieve transaction status after multiple attempts.');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    private function checkTransactionStatusMob($transaction) {
        $client = new Client();
        $response = $client->get('https://api-s1.orange.cm/omcoreapis/1.0.2/mp/paymentstatus/' . $transaction['pay_token'], [
            'headers' => [
                'Authorization' => 'Bearer ' . $transaction['access_token'],
                'Content-Type' => 'application/json',
                'X-AUTH-TOKEN' => 'WU5PVEVIRUFEMjpAWU5vVGVIRUBEMlBST0RBUEk='
            ],
        ]);

        $bodySecond = $response->getBody();
        $responseData = json_decode($bodySecond, true);

        if (!empty($responseData)) {
            $transaction->update([
                'status' => $responseData['data']['status'],
                'updated_by' => auth()->user()->id,
            ]);
        }

        return $responseData;
    }

    public function checkBalanceBeforePayment(Request $request)
    {
        try {
            if (!empty($request['idPension'])) {
                $requestData = [
                    'idPension' => $request['idPension'],
                    'idSchool' => $request['idSchool'],
                    'idSection' => $request['idSection'],
                    'idStudent' => $request['idStudent']
                ];
                $balance = $this->pensionUserService->balancePensionUser($requestData);
                $balanceResponseData = json_decode($balance, true);
                if (isset($balanceResponseData['message'])) {
                    $balance = $balanceResponseData['message'];
                }
                $requestedAmount = 0;
                if (is_numeric($request['amount'])) {
                    $requestedAmount = $request['amount'];
                } else {
                    $requestedAmount = floatval($request['amount']);
                }

                // on compare avec le montant initial ... donc après avoir retiré les 2% de frais sur la transaction
                if (($requestedAmount / 1.02) > $balance) {
                    return $this->sendResponses('Le montant est supérieur au reste à payer');
                } elseif ($balance == 0) {
                    return $this->sendResponses('Toute la pension a été payée');
                }
            }

            if (!empty($request['idFee']) && !empty($request['idLevel'])) {
                $requestData = [
                    'idFee' => $request['idFee'],
                    'idSchool' => $request['idSchool'],
                    'idSection' => $request['idSection'],
                    'idStudent' => $request['idStudent'],
                    'idLevel' => $request['idLevel']
                ];
                $balance = $this->feeUserService->calculateBalanceFeeUser($requestData);
                $balanceResponseData = $balance;
                if (isset($balanceResponseData['montantRestant'])) {
                    $balance = $balanceResponseData['montantRestant'];
                }
                $requestedAmount = floatval($request['amount']);
//                if ($requestedAmount > $balance) {

                // on compare avec le montant initial ... donc après avoir retiré les 2% de frais sur la transaction
                if (($requestedAmount / 1.02) > $balance) {
                    return $this->sendResponses('Le montant est supérieur au reste à payer');
                } elseif ($balance == 0) {
                    return $this->sendResponses('Le frais scolaire a été complètement payé');
                }
            }

            return null;
        } catch (\Throwable $th) {
            return $this->sendError('Une erreur est survenue lors de la vérification du solde avant le paiement');
        }
    }


    public function handleCallback(Request $request)
    {
        try {
            $payToken = $request->input('payToken');
            Log::info("Callback reçu pour payToken: {$payToken}", ['data' => $request->all()]);

            return DB::transaction(function () use ($payToken, $request) {

                // 🔒 On verrouille la transaction dès le début pour éviter le double traitement
                $transaction = Transaction::where('pay_token', $payToken)
                    ->lockForUpdate()
                    ->first();

                if (!$transaction) {
                    Log::warning("Transaction introuvable pour payToken: {$payToken}");
                    return $this->sendError('Transaction introuvable', [], 404);
                }

                Log::info("Transaction verrouillée et trouvée", [
                    'transaction_id' => $transaction->id,
                    'current_status' => $transaction->status
                ]);

                // 🔍 Vérification des doublons
                if (PensionUser::where('idTransaction', $transaction->id)->exists()) {
                    Log::warning("Transaction déjà utilisée pour une pension", ['transaction_id' => $transaction->id]);
                    return $this->sendError("La transaction a déjà été enregistrée pour une pension");
                } elseif (FeeUser::where('idTransaction', $transaction->id)->exists()) {
                    Log::warning("Transaction déjà utilisée pour un frais", ['transaction_id' => $transaction->id]);
                    return $this->sendError("La transaction a déjà été enregistrée pour un frais");
                }

                // Mise à jour du statut
                $status = $request->input('status', $transaction->status);
                $transaction->update([
                    'status' => $status,
                    'message' => $request->input('message', $transaction->message),
                    'updated_by' => 0,
                ]);

                Log::info("Statut transaction mis à jour", [
                    'transaction_id' => $transaction->id,
                    'new_status' => $status
                ]);

                // Traitement principal des paiements finalisés
                if (in_array($status, ['SUCCESSFULL', 'FAILED'])) {
                    $amount = $transaction->amount;

                    // Ajustement frais
                    $establishment = Establishment::find(School::find($transaction->idSchool)->idEstablishment);
                    $amount = $amount * 100 / 102;

                    if ($status === 'SUCCESSFULL') {
                        if ($transaction->idPension) {
                            $result = $this->pensionUserService->storePensionUser([
                                'idTransaction' => $transaction->id,
                                'idStudent' => $transaction->idStudent,
                                'idPension' => $transaction->idPension,
                                'idSchool' => $transaction->idSchool,
                                'idSection' => $transaction->idSection,
                                'advancePayment' => $amount,
                                'payment_mode' => $transaction->payment_mode,
                            ]);

                            return [
                                'data' => ['status' => $status, 'txnid' => $transaction->order_id],
                                'result' => $result,
                            ];

                        } elseif ($transaction->idFee && $transaction->idLevel) {
                            $result = $this->feeUserService->storeFeeUser([
                                'idStudent' => $transaction->idStudent,
                                'idFee' => $transaction->idFee,
                                'idLevel' => $transaction->idLevel,
                                'idSchool' => $transaction->idSchool,
                                'idSection' => $transaction->idSection,
                                'advancePayment' => $amount,
                                'payment_mode' => $transaction->payment_mode,
                            ]);

                            return [
                                'data' => ['status' => $status, 'txnid' => $transaction->order_id],
                                'result' => $result,
                                'registrationPaid' => $this->isRegistrationPaid($transaction->idStudent),
                            ];

                        } elseif ($transaction->transport_user_id) {
                            [$success, $data] = app(PaymentTransportUserService::class)->createPayment([
                                'transport_user_id' => $transaction->transport_user_id,
                                'advance_payment' => $amount,
                                'payment_mode' => $transaction->payment_mode,
                                'payment_date' => $transaction->payment_date ?? now(),
                            ]);

                            if (!$success) {
                                return $this->sendError($data, null, 500);
                            }

                            return [
                                'data' => [
                                    'status' => $status,
                                    'txnid' => $transaction->order_id,
                                    'registrationPaid' => $this->isRegistrationPaid($transaction->idStudent)
                                ],
                                'result' => $data,
                            ];
                        }
                    }
                }

                return $this->sendResponses([
                    'txnid' => $transaction->order_id,
                    'status' => $transaction->status,
                    'message' => $transaction->message,
                ]);
            });
        } catch (\Throwable $th) {
            Log::critical("Erreur critique lors du traitement du callback: " . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'payToken' => $payToken ?? 'non défini'
            ]);
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
