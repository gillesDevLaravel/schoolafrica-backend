<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'access_token' => ['required'],
            'expires_in' => ['required'],
            'order_id' => "nullable",
            'amount' => "nullable",
            'reference' => "nullable",
            'status' => "nullable",
            'message' => "nullable",
            'pay_token' => "nullable",
            'payment_url' => "nullable",
            'notif_token' => "nullable",
            'payment_mode' => "nullable",
            'payment_date' => "nullable",
            'tnxid' => "nullable",
            'idFee' => "integer|nullable",
            'idLevel' => "integer|nullable",
            'idStudent' => "integer|nullable",
            'idInvoice' => "integer|nullable",
            'type' => "nullable",
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'idInscription' => "integer|nullable",
            'idPension' => "integer|nullable",
            'idTranche' => "integer|nullable",
            'idEnseignant' => "integer|nullable",
            'compteEmeteur' => "nullable",
            'compteRecepteur' => "nullable",
        ];
    }
}
