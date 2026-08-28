<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait SMSTrait {

    protected $url;
    protected $login;
    protected $password;
    protected $sender;

    public function selectAccount($account_name){
        $this->url = env('NEXAH_API_BASE_URL')."/sendsms";

        if (env('NEXAH_API_NAME') === $account_name){
            $this->login = env('REMBOURSEMENT_NEXAH_API_LOGIN');
            $this->password = env('REMBOURSEMENT_NEXAH_API_PASSWORD');
            $this->sender = env('REMBOURSEMENT_NEXAH_API_SENDER_ID');
        }
        else{
            $this->login = env('NEXAH_API_LOGIN');
            $this->password = env('NEXAH_API_PASSWORD');
            $this->sender = env('NEXAH_API_SENDER_ID');
        }
    }

    /**
     * Envoyer des SMS via l'API de nexah
     *
     * @param array $mobiles
     * @param $message
     * @return array|mixed
     */
    public function sendSMS(array $mobiles, $message, $accountName = null)
    {
        $this->selectAccount($accountName);

        if(is_null($this->login) || is_null($this->password) || is_null($this->sender)){
            throw new Exception("SMS params not found in .env file");
        }

        try {

            // Convertir le tableau de numéros en une chaîne séparée par des virgules
            $mobilesString = implode(',', $mobiles);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->url, [
                'user' => $this->login, // Remplacez par votre nom d'utilisateur
                'password' => $this->password, // Remplacez par votre mot de passe
                'senderid' => $this->sender, // Remplacez par votre sender ID
                'sms' => $message,
                'mobiles' => $mobilesString,
                // 'scheduletime' => '2020-10-13 12:05:00' // Optionnel, si vous voulez programmer l'envoi
            ]);

            $responseData = $response->json();

            if ($responseData['responsecode'] == 1) {
                // Succès
                Log::info('SMS envoyé avec succès', [
                    'response' => $responseData,
                    'mobiles' => $mobiles,
                    'message' => $message
                ]);
            } else {
                // Erreur
                Log::error('Échec de l\'envoi du SMS', [
                    'response' => $responseData,
                    'mobiles' => $mobiles,
                    'message' => $message
                ]);
            }

            return $responseData;

//            // Gestion des réponses et journalisation
//            if ($responseData && isset($responseData['responsecode'])) {
//                if ($responseData['responsecode'] == 1) {
//                    // Succès
//                    Log::info('SMS envoyé avec succès', [
//                        'response' => $responseData,
//                        'mobiles' => $mobiles,
//                        'message' => $message
//                    ]);
//                } else {
//                    // Erreur
//                    Log::error('Échec de l\'envoi du SMS', [
//                        'response' => $responseData,
//                        'mobiles' => $mobiles,
//                        'message' => $message
//                    ]);
//                }
//
//                // Journalisation des détails pour chaque numéro de mobile
//                if (isset($responseData['sms']) && is_array($responseData['sms'])) {
//                    foreach ($responseData['sms'] as $smsDetail) {
//                        if ($smsDetail['status'] == 'success') {
//                            Log::info('SMS envoyé avec succès à un numéro', [
//                                'messageld' => $smsDetail['messageld'],
//                                'smsclientid' => $smsDetail['smsclientid'],
//                                'mobileno' => $smsDetail['mobileno'],
//                                'message' => $message
//                            ]);
//                        } else {
//                            Log::error('Échec de l\'envoi du SMS à un numéro', [
//                                'messageld' => $smsDetail['messageld'],
//                                'smsclientid' => $smsDetail['smsclientid'],
//                                'mobileno' => $smsDetail['mobileno'],
//                                'errorcode' => $smsDetail['errorcode'],
//                                'errordescription' => $smsDetail['errordescription'],
//                                'message' => $message
//                            ]);
//                        }
//                    }
//                }
//            } else {
//                // Réponse invalide ou erreur de connexion
//                Log::error('Réponse invalide ou erreur de connexion à l\'API SMS', [
//                    'response' => $responseData,
//                    'mobiles' => $mobiles,
//                    'message' => $message
//                ]);
//            }
//
//            return $responseData;
        } catch (Exception $e) {
            // Journalisation de l'exception
            Log::error('Exception lors de l\'envoi du SMS', [
                'error' => $e->getMessage(),
                'mobiles' => $mobiles,
                'message' => $message
            ]);

            // Retourner une réponse d'erreur
            return [
                'responsecode' => 0,
                'responsedescription' => 'error',
                'responsemessage' => 'Une exception s\'est produite lors de l\'envoi du SMS.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifier le solde SMS du compte personnel
     *
     * @return array|mixed
     */
    function getSMSBalance()
    {
        if(is_null(env('NEXAH_API_LOGIN')) || is_null(env('NEXAH_API_PASSWORD')) || is_null(env('NEXAH_API_SENDER_ID'))){
            throw new Exception("SMS params not found in .env file");
        }

        $url = env('NEXAH_API_BASE_URL')."/smscredit";

        $user = env('NEXAH_API_LOGIN'); // Remplacez par votre nom d'utilisateur
        $password = env('NEXAH_API_PASSWORD'); // Remplacez par votre mot de passe

        try {

            // Envoyer une requête POST
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($url, [
                'user' => $user,
                'password' => $password
            ]);

            // Ou envoyer une requête GET (décommentez la ligne suivante si vous préférez GET)
            // $response = Http::get($url, [
            //     'user' => $user,
            //     'password' => $password
            // ]);

            $responseData = $response->json();

            // Gestion des réponses et journalisation
            if ($responseData && isset($responseData['credit'])) {
                // Succès
                Log::info('Solde SMS récupéré avec succès', [
                    'response' => $responseData,
                    'user' => $user
                ]);

                return $responseData;
            } else {
                // Erreur
                Log::error('Échec de la récupération du solde SMS', [
                    'response' => $responseData,
                    'user' => $user
                ]);

                return [
                    'error' => 'Échec de la récupération du solde SMS',
                    'response' => $responseData
                ];
            }
        } catch (Exception $e) {
            // Journalisation de l'exception
            Log::error('Exception lors de la récupération du solde SMS', [
                'error' => $e->getMessage(),
//                'user' => $user
            ]);

            // Retourner une réponse d'erreur
            return [
                'error' => 'Une exception s\'est produite lors de la récupération du solde SMS.',
                'exception' => $e->getMessage()
            ];
        }
    }
}
