<?php

namespace App\Http\Requests\TransportUser;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TransportUserUpdateRequest extends MyCustomRequest
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
            'transport_id' => 'nullable|integer|exists:transports,id',
            'student_id'   => 'nullable|integer|exists:users,id',
            'type'         => 'nullable|string|max:50',
            'amount'         => 'nullable|numeric|min:0',
            'reduction'         => 'nullable|boolean',
            'reduction_amount'         => 'nullable|numeric|min:0',
            'reason'         => 'nullable|string',
        ];
    }
}
