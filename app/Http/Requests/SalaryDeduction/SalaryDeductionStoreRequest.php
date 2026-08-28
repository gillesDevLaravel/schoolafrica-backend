<?php

namespace App\Http\Requests\SalaryDeduction;

use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SalaryDeductionStoreRequest extends MyCustomRequest
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
            'salary_deductions' =>  'required|array',
            'salary_deductions.*.idUser' => 'required|exists:users,id',
            'salary_deductions.*.idUserApprove' => 'required|integer|exists:users,id',
            'salary_deductions.*.amount' => 'required|numeric|min:0',
            'salary_deductions.*.date' => 'required|date',
            'salary_deductions.*.status' =>  'nullable|string|in:' . implode(',', StatusEnum::values()), //Nullable car valeur par défaut défini en bd
            'salary_deductions.*.reason' => 'required|string',
        ];
    }
}
