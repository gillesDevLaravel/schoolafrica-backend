<?php

namespace App\Http\Requests\SalaryAdvance;

use App\Http\Requests\MyCustomRequest;

class SalaryAdvanceRestoreRequest extends MyCustomRequest
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
            'ids' => "required|array",
            'ids.*' => "required|integer|exists:salary_advances,id"
        ];
    }
}
