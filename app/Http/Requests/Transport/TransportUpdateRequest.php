<?php

namespace App\Http\Requests\Transport;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TransportUpdateRequest extends MyCustomRequest
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
            'name'          => 'nullable|string|max:255',
            'remark'          => 'nullable|string',
            'description'   => 'nullable|string',
            'amount_month'  => 'nullable|numeric|min:0',
            'amount_terms1' => 'nullable|numeric|min:0',
            'amount_terms2' => 'nullable|numeric|min:0',
            'amount_terms3' => 'nullable|numeric|min:0',
            'amount'        => 'nullable|numeric|min:0',
        ];
    }
}
