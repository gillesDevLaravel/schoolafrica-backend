<?php

namespace App\Http\Requests\SalaryAdvance;

use App\Http\Requests\MyCustomRequest;

class SalaryAdvanceDestroyRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id_role = auth()->user()->getRole()->id;

        return in_array($user_id_role, [1,2]);
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
