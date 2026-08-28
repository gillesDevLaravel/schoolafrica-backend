<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends MyCustomRequest
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
            'customers' => "required|array",
            'customers.*.name' => "required|string",
            'customers.*.adresse' => "nullable|string",
            'customers.*.image' => "nullable|string",
            'customers.*.website' => "nullable|string",
            'customers.*.niu' => "nullable|string",
            'customers.*.type' => 'required|in:entreprise,personnel',
            'customers.*.rc' => "nullable|string",
            'customers.*.phone' => "required|string",
            'customers.*.mobile' => "required|string",
            'customers.*.email' => "required|string|email",
            'customers.*.country' => "nullable|string|email",
            'customers.*.city' => "nullable|string|email",
            'customers.*.cni' => "nullable|string|email",
//            ]
//                'max:4096', // 4Mo en kilo-octets
//                'mimes:jpeg,png,pdf',
//            'image' => [
        ];
    }
}
