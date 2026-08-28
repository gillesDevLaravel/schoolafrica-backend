<?php

namespace App\Http\Controllers;

use App\Http\Requests\MtnPayment\MtnPaymentInitiateRequest;
use App\Http\Requests\MtnPayment\MtnPaymentStatisticRequest;
use App\Http\Requests\MtnPayment\MtnPaymentWebhookRequest;
use App\Jobs\SendMailJob;
use App\Jobs\SendSMSJob;
use App\Mail\PaymentInitiatedMail;
use App\Models\Establishment;
use App\Models\FeeUser;
use App\Models\PensionUser;
use App\Models\School;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Services\FeeUserService;
use App\Services\PaymentTransportUserService;
use App\Services\PensionUserService;
use App\Traits\CheckIfRegistrationFeeIsPaidTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MtnPaymentController extends BaseController
{
    use CheckIfRegistrationFeeIsPaidTrait;

    protected $pensionUserService, $feeUserService;

    public function __construct(PensionUserService $pensionUserService, FeeUserService $feeUserService)
    {
        $this->pensionUserService = $pensionUserService;
        $this->feeUserService = $feeUserService;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getToken()
    {
        $clientId = "1d52b435-bcaf-4862-8ba5-88d63d8c6ac9";
        $clientSecret = "DJHIvuK7N0JXFjD1Nh9omBINbZ4LD0Az";
        $tokenUrl = "https://omapi-token.ynote.africa/oauth2/token";

        $client = new Client();

        try {
            $response = $client->post($tokenUrl, [
                'auth' => [$clientId, $clientSecret],  // Basic Auth
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['access_token'])) {
                throw new \Exception('Token non reçu dans la réponse');
            }

            return $data;

        } catch (RequestException $e) {
            Log::critical($e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine());
            throw new \Exception('Erreur lors de la récupération du token : ' . $e->getMessage());
        }
    }


    public function initiate(MtnPaymentInitiateRequest $request)
    {
        try {
            $request['reference'] = mb_substr($request['reference'], 0, 30);
            $token = $this->getToken();
            $tabTransac = [];

            // Vérification des champs requis
            if (empty($request['idStudent']) || empty($request['idSchool']) || empty($request['idSection']) ||
                empty($request['amount']) || empty($request['payment_mode'])) {
                return $this->sendError('Certaines valeurs de transaction sont manquantes.');
            }

            // Vérification du solde avant paiement
            $balanceError = $this->checkBalanceBeforePayment($request);
            if ($balanceError != null) {
                return $balanceError;
            }


            // Création de la transaction
            $transaction = Transaction::create([
                'access_token' => $token['access_token'],
                'expires_in' => time() + $token['expires_in'],
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

            // Envoi de notification
            $mailable = new PaymentInitiatedMail(
                $request['idSchool'],
                $request['idStudent'],
                $request['idClasse'] ?? null,
                $request['phonePayeur'],
                $request['amount'],
                $transaction->id
            );
            $recipients = [
                'mobilemoney@ms-school.net',
                'houbadesire@gmail.com',
                'b.djoulde@mh-technologie.com'
            ];
            SendMailJob::dispatch($mailable, $recipients, 'smtp2');

            $orderId = uniqid();
            $client = new Client();

            // Initiation du paiement MTN
            $response = $client->post("https://omapi.ynote.africa/prod/webpayment", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token['access_token'],
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "API_MUT" => [
                        "notifUrl"        => "http://app.ms-school.net/notification",
                        "subscriberMsisdn" => $request['phonePayeur'],  // numéro payeur sans indicatif +237
                        "description"     => $request['reference'],     // description ou note
                        "amount"          => (string) $request['amount'], // montant en string, sans virgule
                        "order_id"        => $orderId,                   // identifiant unique (sans espace)
                        "customersecret"  => "c851ebd43bd26df9da6f988428c2b5b7be0c4ac1d1e90953cf21d5504745c04f",
                        "customerkey"     => "b54cf61e-06f7-50d2-8259-068528cf748a",
                        "PaiementMethod"  => "MTN_CMR",
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $parameters = $data['parameters'];


            if ($response->getStatusCode() == 200) {
                $transaction->update([
                    'order_id' => $parameters['MessageId'],
                    'amount' => intval($request['amount']),
                    'reference' => $request['reference'],
                    'status' => "PENDING",
                    'pay_token' => $orderId, // On utilise orderId comme référence pour MTN
                    'message' => 'Paiement initié',
                    'compteEmeteur' => $request['phonePayeur'],
                ]);

                $tabTransac["idTransaction"] = $transaction->id;
                return $this->sendResponses($tabTransac);
            } else {
                return $this->sendError(__('transaction.paiement_service.error'), [], $response->getStatusCode());
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('transaction.create.error'), null, 404, $th->getMessage());
        }
    }

    public function webhook(MtnPaymentWebhookRequest $request)
    {
        try {
            $transactionId = $request->input('financialTransactionId');
            $status = $request->input('status');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $externalId = $request->input('externalId');

            // Trouver la transaction par order_id (externalId dans MTN)
            $transaction = Transaction::where('order_id', $externalId)->first();

            if (!$transaction) {
                Log::error("Transaction non trouvée pour externalId: " . $externalId);
                return response()->json(['message' => 'Transaction non trouvée'], 404);
            }

            // Mettre à jour le statut de la transaction
            $transaction->update([
                'status' => strtoupper($status),
                'message' => $request->input('reason') ?? 'Statut mis à jour via webhook'
            ]);

            // Si le paiement est réussi, traiter le paiement
            if (strtoupper($status) === 'SUCCESSFUL') {
                $this->processSuccessfulPayment($transaction);
            }

            return response()->json(['message' => 'Webhook traité avec succès']);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return response()->json(['message' => 'Erreur interne du serveur'], 500);
        }
    }

    public function status(Transaction $transaction)
    {
        try {
            $responseData = null;
            $tabResponse = [];

            $retryCount = 3;
            $currentRetry = 0;
            $retryDelay = 30;

            if (PensionUser::where('idTransaction', $transaction['id'])->exists()) {
                return $this->sendError("La transaction a déjà été enregistrée pour une pension");
            } elseif (FeeUser::where('idTransaction', $transaction['id'])->exists()) {
                return $this->sendError("La transaction a déjà été enregistrée pour un frais");
            }

            while ($currentRetry < $retryCount) {
                try {
                    if ($transaction['expires_in'] > time()) {
                        do {
                            $responseData = $this->checkTransactionStatus($transaction);
                        } while ($responseData['status'] == 'INITIATED' || $responseData['status'] == 'PENDING');
                        sleep(10);
                    } else {
                        $token = $this->getToken();
                        $transaction->update([
                            'access_token' => $token['access_token'],
                            'expires_in' => time() + $token['expires_in'],
                        ]);


                        do {
                            $responseData = $this->checkTransactionStatus($transaction);
                        } while ($responseData['status'] == 'INITIATED' || $responseData['status'] == 'PENDING');
                        sleep(30);
                    }

                    if (!empty($responseData)) {
                        $status = strtoupper($responseData['status'] ?? 'PENDING');

                        if ($status === 'SUCCESSFUL' && $transaction['idPension'] != null) {
                            return $this->processPensionPayment($transaction);
                        } elseif ($status === 'SUCCESSFUL' && $transaction['idFee'] != null && $transaction['idLevel'] != null) {
                            return $this->processFeePayment($transaction);
                        }elseif ($status === 'SUCCESSFUL' && $transaction['transport_user_id'] != null) {
                            return $this->processTransportUserPayment($transaction);
                        } else {
                            $tabResponse["txnid"] = $transaction->order_id;
                            $tabResponse["status"] = $status;
                            return $this->sendResponses($tabResponse);
                        }
                    }
                } catch (RequestException $e) {
                    $currentRetry++;
                    if ($currentRetry < $retryCount) {
                        usleep($retryDelay * 1000000);
                        continue;
                    } else {
                        Log::error('HTTP Error: ' . $e->getResponse()->getStatusCode());
                        $this->dispatch(new SendSMSJob(["237698358935"], "Une transaction(id=".$transaction->id.") a mis trop long du côté de la base ".env('APP_NAME')."."));
                        return $this->sendError('Failed to retrieve transaction status after multiple attempts.');
                    }
                }
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//            return $this->sendError(__('app.error_occured'));
        }
    }

    private function checkTransactionStatus($transaction)
    {
        $client = new Client();

        $response = $client->post("https://omapi.ynote.africa/prod/webpaymentmtn/status", [
            'headers' => [
                'Authorization' => 'Bearer ' . $transaction['access_token'],
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "customersecret"  => "c851ebd43bd26df9da6f988428c2b5b7be0c4ac1d1e90953cf21d5504745c04f",
                "customerkey"     => "b54cf61e-06f7-50d2-8259-068528cf748a",
                "message_id" => $transaction->order_id,
                "payment_method" => "MTN_CMR"
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        $body = $response->getBody();
        $responseData = json_decode($body, true);

        if (!empty($responseData)) {
            $transaction->update([
                'status' => strtoupper($responseData['status'] ?? 'PENDING'),
                'updated_by' => auth()->user()->id,
            ]);
        }

        return $responseData;
    }

    private function processSuccessfulPayment($transaction)
    {
        $establishment = Establishment::find(School::find($transaction['idSchool'])->idEstablishment);
        $amount = $transaction['amount'] * 100 / 102; // Retrait des 2% de frais

        if ($transaction['idPension'] != null) {
            $requestData = [
                'idStudent' => $transaction['idStudent'],
                'idPension' => $transaction['idPension'],
                'idSchool' => $transaction['idSchool'],
                'idSection' => $transaction['idSection'],
                'advancePayment' => $amount,
                'payment_mode' => $transaction['payment_mode'],
            ];
            return $this->pensionUserService->storePensionUser($requestData);
        } elseif ($transaction['idFee'] != null && $transaction['idLevel'] != null) {
            $requestData = [
                'idStudent' => $transaction['idStudent'],
                'idFee' => $transaction['idFee'],
                'idLevel' => $transaction['idLevel'],
                'idSchool' => $transaction['idSchool'],
                'idSection' => $transaction['idSection'],
                'advancePayment' => $amount,
                'payment_mode' => $transaction['payment_mode'],
            ];
            return $this->feeUserService->storeFeeUser($requestData);
        }
    }

    private function processPensionPayment($transaction)
    {
        $establishment = Establishment::find(School::find($transaction['idSchool'])->idEstablishment);
        $amount = $transaction['amount'] * 100 / 102;

        try {
            $requestData = [
                'idTransaction' => $transaction['idTransaction'],
                'idStudent' => $transaction['idStudent'],
                'idPension' => $transaction['idPension'],
                'idSchool' => $transaction['idSchool'],
                'idSection' => $transaction['idSection'],
                'advancePayment' => $amount,
                'payment_mode' => $transaction['payment_mode'],
            ];
            $result = $this->pensionUserService->storePensionUser($requestData);

            return [
                'data' => [
                    'txnid' => $transaction->order_id,
                    'status' => 'SUCCESSFUL',
                ],
                'result' => $result
            ];

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->sendError('Erreur lors du traitement du paiement de pension');
        }
    }

    private function processFeePayment($transaction)
    {
        $establishment = Establishment::find(School::find($transaction['idSchool'])->idEstablishment);
        $amount = $transaction['amount'] * 100 / 102;

        try {
            $requestData = [
                'idTransaction' => $transaction['idTransaction'],
                'idStudent' => $transaction['idStudent'],
                'idFee' => $transaction['idFee'],
                'idLevel' => $transaction['idLevel'],
                'idSchool' => $transaction['idSchool'],
                'idSection' => $transaction['idSection'],
                'advancePayment' => $amount,
                'payment_mode' => $transaction['payment_mode'],
            ];
            $result = $this->feeUserService->storeFeeUser($requestData);

            return [

                'data' => [
                    'txnid' => $transaction->order_id,
                    'status' => 'SUCCESSFUL',
                    'registrationPaid' => $this->isRegistrationPaid($transaction['idStudent'])
                ],
                'result' => $result
            ];

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->sendError('Erreur lors du traitement du paiement de frais');
        }
    }

    private function processTransportUserPayment($transaction)
    {
        $establishment = Establishment::find(School::find($transaction['idSchool'])->idEstablishment);
        $amount = $transaction['amount'] * 100 / 102;

        try {
            $requestData = [
                'transport_user_id' => $transaction['transport_user_id'], // ⚠️ assure-toi que c’est bien le bon champ
                'advance_payment'   => $amount,
                'payment_mode'      => $transaction['payment_mode'],
                'payment_date'      => $transaction['payment_date'] ?? now(),
            ];

            // Appel du service
            [$success, $data] = app(PaymentTransportUserService::class)->createPayment($requestData);

            if (!$success) {
                return $this->sendError($data, null, 500);
            }

            return [
                'data' => [
                    'txnid' => $transaction->order_id,
                    'status' => 'SUCCESSFUL',
                    'registrationPaid' => $this->isRegistrationPaid($transaction['idStudent'])
                ],
                'result' => $data
            ];

        } catch (\Throwable $th) {
            Log::error('Erreur processTransportUserPayment : ' . $th->getMessage());
            return $this->sendError('Erreur lors du traitement du paiement transport');
        }
    }

    private function checkBalanceBeforePayment(Request $request)
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
                $requestedAmount = floatval($request['amount']);

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

                if (($requestedAmount / 1.02) > $balance) {
                    return $this->sendResponses('Le montant est supérieur au reste à payer');
                } elseif ($balance == 0) {
                    return $this->sendResponses('Le frais scolaire a été complètement payé');
                }
            }

            return null;
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    public function statistics(MtnPaymentStatisticRequest $request){
        try {
            $tab = array();
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $query_schoolName = School::select('id', 'name', 'scholar_level', 'idEstablishment')->get();
            $query_withdrawal = Withdrawal::select('montant_retrait_brut', 'mode_retrait', 'idUser', 'numero_retrait', 'rib', 'idSchool', 'idSection')
                ->whereIn('status', ['pending', 'success', 'completed']) // uniquement les retraits qui ont déjà été validés
                ->whereIn('type', ['Mobile Money', 'MOMO'])
                ->get();
            if ($idSchool != null) {
                switch ($idSection) {
                    case null:
                        $withdrawal = $query_withdrawal->where('idSchool', $request['idSchool'])
                            ->sum('montant_retrait_brut');

                        $schoolName = $query_schoolName->where('id', $request['idSchool'])->first();

                        $pensionUsersAmount = PensionUser::where('idSchool', $request['idSchool'])
                            ->whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                            ->sum('advancePayment');

                        $feeUsersAmount = FeeUser::where('idSchool', $request['idSchool'])
                            ->whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                            ->sum('advancePayment');

                        $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                        $tab['schoolName'] = $schoolName->name;
                        $tab['schoolLevel'] = $schoolName->scholar_level;
                        $tab['sommeSchool'] = $totalAmount;
                        $tab['sommeSchoolRetire'] = $withdrawal;
                        $tab['sommeSchoolEnCaisse'] = $totalAmount - $withdrawal;
                        $tab['sommeSchoolDispo'] = ($totalAmount - $withdrawal); // * 0.98;
                        $tab['sommeTotal_1'] = $totalAmount; // * 0.98;
                        $tab['sommeRetire_1'] = $withdrawal; // * 0.98;

                        return $this->sendResponses($tab);
                        break;

                    default:
                        $withdrawal = $query_withdrawal->where('idSchool', $request['idSchool'])
                            ->where('idSection', $request['idSection'])
                            ->sum('amount');

                        $schoolName = $query_schoolName->where('id', $request['idSchool'])->first();

                        $pensionUsersAmount = PensionUser::where('idSchool', $request['idSchool'])
                            ->where('idSection', $request['idSection'])
                            ->whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                            ->sum('advancePayment');

                        $feeUsersAmount = FeeUser::where('idSchool', $request['idSchool'])
                            ->where('idSection', $request['idSection'])
                            ->whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                            ->sum('advancePayment');

                        $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                        $tab['schoolName'] = $schoolName->name;
                        $tab['schoolLevel'] = $schoolName->scholar_level;
                        $tab['sommeSchoolSection'] = $totalAmount;
                        $tab['sommeSchoolSectionRetire'] = $withdrawal;
                        $tab['sommeSchoolSectionEnCaisse'] = $totalAmount - $withdrawal;
                        $tab['sommeSchoolSectionDispo'] = ($totalAmount - $withdrawal); //* 0.98;
                        $tab['sommeTotal_1'] = $totalAmount; //* 0.98;
                        $tab['sommeRetire_1'] = $withdrawal; //* 0.98;

                        return $this->sendResponses($tab);
                        break;
                }
            } else {
                $withdrawal = $query_withdrawal->sum('montant_retrait_brut');
                $pensionUsersAmount = PensionUser::whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                    ->sum('advancePayment');

                $feeUsersAmount = FeeUser::whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                    ->sum('advancePayment');

                $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                $tab['sommeTotal'] = $totalAmount;
                $tab['sommeRetire'] = $withdrawal;
                $tab['sommeEnCaisse'] = $totalAmount - $withdrawal;
                $tab['sommeTotalDisponible'] = ($totalAmount - $withdrawal); //* 0.98;
                $tab['sommeTotal_1'] = $totalAmount; //* 0.98;
                $tab['sommeRetire_1'] = $withdrawal; //* 0.98;

                $schools = School::select('id', 'name', 'scholar_level', 'idEstablishment')->get();
                $tab['schools'] = $schools;

                if ($schools->isNotEmpty()) {
                    for ($i = 0; $i < count($schools); $i++) {
                        $withdrawal = $query_withdrawal->where('idSchool', $schools[$i]['id'])
                            ->sum('montant_retrait_brut');

                        $schoolName = $query_schoolName->where('id', $schools[$i]['id'])->first();

                        $pensionUsersAmount = PensionUser::where('idSchool', $schools[$i]['id'])
                            ->whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                            ->sum('advancePayment');

                        $feeUsersAmount = FeeUser::where('idSchool', $schools[$i]['id'])
                            ->whereIn('payment_mode', ['Mobile Money', 'MOMO'])
                            ->sum('advancePayment');

                        $totalAmount = $pensionUsersAmount + $feeUsersAmount;

                        $tab['schools'][$i]['etablissment'] = $schoolName->establishment->name;
                        $tab['schools'][$i]['rib'] = $schoolName->establishment->rib;
                        $tab['schools'][$i]['banque'] = $schoolName->establishment->banque;
                        $tab['schools'][$i]['numero_retrait'] = $schoolName->establishment->om;
                        $tab['schools'][$i]['idSchool'] = $schoolName->id;
                        $tab['schools'][$i]['schoolName'] = $schoolName->name;
                        $tab['schools'][$i]['schoolLevel'] = $schoolName->scholar_level;
                        $tab['schools'][$i]['sommeTotal'] = $totalAmount;
                        $tab['schools'][$i]['sommeRetire'] = $withdrawal;
                        $tab['schools'][$i]['sommeEnCaisse'] = $totalAmount - $withdrawal;
                        $tab['schools'][$i]['sommeTotalDisponible'] = ($totalAmount - $withdrawal); //* 0.98;
                        $tab['schools'][$i]['sommeTotal_1'] = $totalAmount; //* 0.98;
                        $tab['schools'][$i]['sommeRetire_1'] = $withdrawal; //* 0.98;

                    }
                }


                return $this->sendResponses($tab);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

}
