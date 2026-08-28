<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends MyCustomRequest
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
            'clients' => "required|array",
            'clients.*.name' => "required|string",
            'clients.*.adresse' => "nullable|string",
            'clients.*.image' => "nullable|string",
            'clients.*.website' => "nullable|string",
            'clients.*.niu' => "nullable|string",
            'clients.*.type' => 'required|in:entreprise,personnel',
            'clients.*.rc' => "nullable|string",
            'clients.*.phone' => "required|string",
            'clients.*.mobile' => "required|string",
            'clients.*.email' => "required|string|email",
            'clients.*.country' => "nullable|string|email",
            'clients.*.city' => "nullable|string|email",
            'clients.*.cni' => "nullable|string|email",
//            ]
//                'max:4096', // 4Mo en kilo-octets
//                'mimes:jpeg,png,pdf',
//            'image' => [
        ];
    }
}
