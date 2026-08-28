<?php

namespace App\Http\Requests\SalaryComponent;

use App\Http\Requests\MyCustomRequest;

class SalaryComponentArchivageRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:salary_components,id',
        ];
    }
}
