<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListFeeAndPensionUserPeriodRequest extends MyCustomRequest
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
            'pageItems' => ['integer', 'nullable'],
            'nbreItems' => ['integer', 'nullable'],
            'date_start' => 'required|date_format:d-m-Y',
            'date_end' => 'required|date_format:d-m-Y',
            'idSchool' => 'required|integer',
        ];
    }
}
