<?php

namespace App\Http\Requests\SalaryComponent;

use App\Http\Requests\MyCustomRequest;

class SalaryComponentUpdateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'order' => 'nullable|integer'
        ];
    }
}
