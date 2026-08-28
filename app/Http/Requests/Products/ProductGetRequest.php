<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\MyCustomRequest;

class ProductGetRequest extends MyCustomRequest
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
            'type' =>  'nullable|string',
            'trashed' =>  'nullable|boolean',
        ];
    }
}
