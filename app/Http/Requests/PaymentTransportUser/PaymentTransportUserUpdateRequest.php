<?php

namespace App\Http\Requests\PaymentTransportUser;

use App\Http\Requests\MyCustomRequest;

class PaymentTransportUserUpdateRequest extends MyCustomRequest
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
            'transport_user_id'      => 'nullable|integer|exists:transport_users,id',
            'advance_payment'        => 'nullable|numeric|min:0',
            'balance_payment'        => 'nullable|numeric|min:0',
            'payment_date'           => 'nullable|date',
            'payment_mode'           => 'nullable|string|max:50',
            'solvable'               => 'nullable|string|max:125',
            'scan_receipt'           => 'nullable|string|max:125',
            'photo'                  => 'nullable|string|max:125',
            'reason'                 => 'nullable|string|max:125',
            'receipt_number'         => 'nullable|string|max:125',
            'telephone'              => 'nullable|string|max:125',
            'reference'              => 'nullable|string|max:7',
        ];
    }
}
