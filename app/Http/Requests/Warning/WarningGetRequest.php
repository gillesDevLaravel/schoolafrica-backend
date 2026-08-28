<?php

namespace App\Http\Requests\Warning;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class WarningGetRequest extends MyCustomRequest
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
            'idUser' => 'nullable|integer|exists:users,id',
            'trashed' => 'nullable|boolean',
            'date' =>  'nullable|date|date_format:Y-m-d',
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
        ];
    }
}
