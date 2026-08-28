<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Traits\PvUtilitaires;

class BaseController extends Controller
{
    use PvUtilitaires;

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * success response method 2.
     *
     * @param $result
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponses($result)
    {
        $response['data'] = $result;

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param $errorMessages
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404, $message_error = null)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'message_error' => $message_error
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
