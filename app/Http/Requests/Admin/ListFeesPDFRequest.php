<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ListFeesPDFRequest extends MyCustomRequest
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
            'idSchool' => 'integer|required',
            'idSection' => 'integer|nullable',
            'idFee' => 'integer|nullable',
            'date_start' => 'date|nullable',
            'date_end' => 'date|nullable',
            'filter_value' => 'string|nullable',
            'payment_mode' => 'string|nullable'
        ];
    }
}
