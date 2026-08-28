<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends MyCustomRequest
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
            'phone' => ['required'],
            'adresse' => ['required'],
            'city' => ['required'],
            'section' => ['required'],
            'scholar_level' => ['required'],
            'idEstablishment' => ['required'],
            'idAdjoint' => ['nullable'],
            'idSecretary' => ['nullable'],
            'idAssistant' => ['nullable'],
            'matricule_code' => 'string|required',
            'land_title' => ['nullable', 'string'],
            'building_permit' => ['nullable', 'string'],
            'creation_authorization' => ['nullable', 'string'],
            'opening_authorization' => ['nullable', 'string'],
            'nui' => ['nullable', 'string'],
            'cnps' => ['nullable', 'string'],
            'location_plan' => ['nullable', 'string'],
            'information_sheets' => ['nullable', 'string'],
        ];
    }
}
