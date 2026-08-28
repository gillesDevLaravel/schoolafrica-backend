<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;

class SanctionGetRequest extends MyCustomRequest
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
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'idUser' => "integer|nullable",
            'type' => "integer|nullable",
            'typeUser' => "string|nullable|in:staff,student",
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
            'idClasse' => "integer|nullable",
            'date'     => "date|nullable",
            'date_start' => "date|nullable",
            'date_end' => "date|nullable",
        ];
    }
}
