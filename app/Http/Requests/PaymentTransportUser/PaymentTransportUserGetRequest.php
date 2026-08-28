<?php

namespace App\Http\Requests\PaymentTransportUser;

use App\Http\Requests\MyCustomRequest;

class PaymentTransportUserGetRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nbreItems'        => 'nullable|integer|min:1|max:1000000',
            'pageItems'        => 'nullable|integer|min:1',

            'transport_user_id'=> 'nullable|integer|exists:transport_users,id',

            'payment_date'     => 'nullable|date',
            'payment_mode'     => 'nullable|string|max:50',

            'solvable'         => 'nullable|string|max:125', // si tu veux le traiter comme bool : "nullable|boolean"
            'receipt_number'   => 'nullable|string|max:125',
            'telephone'        => 'nullable|string|max:125',
            'reference'        => 'nullable|string|max:7',

            'created_by'       => 'nullable|integer|exists:users,id',
            'updated_by'       => 'nullable|integer|exists:users,id',
            'deleted_by'       => 'nullable|integer|exists:users,id',
        ];
    }
}
