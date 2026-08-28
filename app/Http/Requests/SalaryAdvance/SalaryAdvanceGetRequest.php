<?php

namespace App\Http\Requests\SalaryAdvance;

use App\Http\Requests\MyCustomRequest;

class SalaryAdvanceGetRequest extends MyCustomRequest
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
            'trashed' => 'nullable|boolean',
            'idUser' => 'nullable|integer|exists:users,id',
            'idUserApprove' => 'nullable|integer|exists:users,id',
            'date' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
