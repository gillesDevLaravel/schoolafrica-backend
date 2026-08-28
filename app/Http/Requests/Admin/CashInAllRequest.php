<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class CashInAllRequest extends MyCustomRequest
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
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
            'date_start' => "date|nullable",
            'date_end' => "date|nullable",
            'idClient' => "integer|nullable",
            'idTypeOfRecipe' => "integer|nullable",
            'irpp' => "boolean|nullable",
        ];
    }
}
