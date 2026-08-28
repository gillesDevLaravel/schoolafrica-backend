<?php

namespace App\Traits;

trait ErrorHandlingTrait
{
    /**
     * Méthode pour envoyer une réponse d'erreur.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Méthode pour envoyer une réponse de succès avec des données.
     *
     * @param mixed $result
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Méthode pour envoyer une réponse de succès sans données.
     *
     * @param mixed $result
     * @return \Illuminate\Http\Response
     */
    public function sendResponses($result)
    {
        $response['data'] = $result;

        return response()->json($response, 200);
    }
}
