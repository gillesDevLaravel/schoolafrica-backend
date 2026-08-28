<?php

namespace App\Http\Requests\TransportUser;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TransportUserCreateRequest extends MyCustomRequest
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
            'transport_id' => 'required|integer|exists:transports,id',
            'student_id'   => 'required|integer|exists:users,id',
            'type'         => 'required|string|max:50',
            'amount'         => 'required|numeric|min:0',
            'reduction'         => 'nullable|boolean',
            'reduction_amount'         => 'nullable|numeric|min:0',
            'reason'         => 'nullable|string',
        ];
    }
}
