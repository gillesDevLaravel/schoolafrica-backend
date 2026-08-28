<?php

namespace App\Http\Requests\Warning;

use App\Http\Requests\MyCustomRequest;

class WarningTrashRequest extends MyCustomRequest
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
            'idWarnings' => 'required|array',
            'idWarnings.*' => 'required|integer|exists:warnings,id'
        ];
    }
}
