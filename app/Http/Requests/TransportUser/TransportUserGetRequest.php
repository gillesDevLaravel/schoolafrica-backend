<?php

namespace App\Http\Requests\TransportUser;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TransportUserGetRequest extends MyCustomRequest
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
            'nbreItems'  => 'nullable|integer|min:1|max:1000000',
            'pageItems'  => 'nullable|integer|min:1',
            'type'       => 'nullable|string|max:50',
            'student_id' => 'nullable|integer|exists:users,id',
        ];
    }
}
