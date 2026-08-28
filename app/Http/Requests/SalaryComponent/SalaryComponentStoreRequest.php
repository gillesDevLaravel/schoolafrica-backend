<?php

namespace App\Http\Requests\SalaryComponent;

use App\Http\Requests\MyCustomRequest;

class SalaryComponentStoreRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'salary_components' => 'required|array',
            'salary_components.*.name' => 'required|string|max:255',
            'salary_components.*.code' => 'nullable|string|max:50',
            'salary_components.*.type' => 'nullable|string|max:255',
            'salary_components.*.order' => 'nullable|integer'
        ];
    }
}
