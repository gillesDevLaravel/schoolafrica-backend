<?php

namespace App\Http\Requests\Warning;

use App\Http\Requests\MyCustomRequest;

class WarningStoreRequest extends MyCustomRequest
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
            'warnings' => 'required|array',
            'warnings.*.idUser' => 'required|integer|exists:users,id',
            'warnings.*.reason' => 'required|string',
            'warnings.*.date' => 'required|date|date_format:Y-m-d',
        ];
    }
}
