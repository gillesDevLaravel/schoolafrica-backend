<?php

namespace App\Http\Requests\SalaryDeduction;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SalaryDeductionRestoreRequest extends MyCustomRequest
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
            'idSalaryDeductions' => 'required|array',
            'idSalaryDeductions.*' => 'required|integer|exists:salary_deductions,id'
        ];
    }
}
