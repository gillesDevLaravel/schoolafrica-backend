<?php

namespace App\Http\Requests\SalaryAdvance;

use App\Http\Requests\MyCustomRequest;

class SalaryAdvanceStoreRequest extends MyCustomRequest
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
            "salary_advances" => "required|array",
            "salary_advances.*.idUserApprove" => "required|integer|exists:users,id",
            "salary_advances.*.amount" => "required",
            "salary_advances.*.reason" => "required|string",
        ];
    }
}
