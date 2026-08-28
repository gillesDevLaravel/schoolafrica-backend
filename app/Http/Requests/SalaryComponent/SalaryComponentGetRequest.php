<?php

namespace App\Http\Requests\SalaryComponent;

use App\Http\Requests\MyCustomRequest;

class SalaryComponentGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter_value' => 'nullable|string',
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer|min:1',
            
        ];
    }
}
