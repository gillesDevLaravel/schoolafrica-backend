<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class EstablishmentRequest extends MyCustomRequest
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
            'name' => ['required', 'max:255'],
            'ministry' => 'nullable|string',
            'region' => 'nullable|string',
            'department' => 'nullable|string',
            'phone' => ['required'],
            'mobile_money_number' => ['nullable'],
            'cnps' => ['nullable'],
            'country' => ['required'],
            'email' => ['required'],
            'idPackage' => ['required'],
            'pay_om_fees' => ['required', 'boolean'],
        ];
    }
}
