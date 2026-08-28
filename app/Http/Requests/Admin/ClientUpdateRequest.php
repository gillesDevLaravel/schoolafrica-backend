<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'name' => "nullable|string",
            'adresse' => "nullable|string",
            'image' => "nullable|string",
            'website' => "nullable|string",
            'niu' => "nullable|string",
            'type' => 'nullable|in:entreprise,personnel',
            'rc' => "nullable|string",
            'phone' => "nullable|string",
            'mobile' => "nullable|string",
            'email' => "nullable|string|email",
            'country' => "nullable|string|email",
            'city' => "nullable|string|email",
            'cni' => "nullable|string|email",
        ];
    }
}
