<?php

namespace App\Http\Requests\PaymentTransportUser;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class PaymentTransportUserArchiveRequest extends MyCustomRequest
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
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:payment_transport_users,id'],
        ];
    }
}
