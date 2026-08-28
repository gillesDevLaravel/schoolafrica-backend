<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends MyCustomRequest
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
            'name' => ['required', 'unique:users,name'],
            'firstname' => ['nullable'],
            'placeofbirth' => ['nullable'],
            'situation' => ['nullable'],
            'repeater' => ['nullable'],
            'cni' => ['nullable'],
            'email' => ['nullable', 'unique:users,email'],
            'whatsapp_number' => ['nullable'],
            'profession' => ['nullable'],
            'bank_name' => ['nullable'],
            'bank_rib' => ['nullable'],
            'number_days_off' => ['nullable'],
            'password' => ['nullable'],
            'username' => ['nullable'],
            'phone' => 'nullable|unique:users,phone',
            'adresse' => ['nullable'],
            'mother' => ['nullable'],
            'tutor' => ['nullable'],
            'phone_2' => 'nullable|unique:users,phone_2', // et si dans un autre phone je met la valeur qui se trouve dans l'autre ci ? (genre phone_2 et phone_4 ont la même valeur ?)
            'phone_3' => 'nullable|unique:users,phone_3', // et si dans un autre phone je met la valeur qui se trouve dans l'autre ci ? (genre phone_2 et phone_4 ont la même valeur ?)
            'phone_4' => 'nullable|unique:users,phone_4', // et si dans un autre phone je met la valeur qui se trouve dans l'autre ci ? (genre phone_2 et phone_4 ont la même valeur ?)
            'phone_5' => 'nullable|unique:users,phone_5', // et si dans un autre phone je met la valeur qui se trouve dans l'autre ci ? (genre phone_2 et phone_4 ont la même valeur ?)
            'phone_6' => 'nullable|unique:users,phone_6', // et si dans un autre phone je met la valeur qui se trouve dans l'autre ci ? (genre phone_2 et phone_4 ont la même valeur ?)
            'observation' => 'nullable|string',
            'nationality' => ['nullable'],
            'gender' => ['required'],
            'adresse_2' => "string|nullable",
            'adresse_tutor' => "string|nullable",
            'gender_2' => "string|nullable",
            'gender_tutor' => "string|nullable",
            'role' => ['required'],
            'birthday' => ['nullable'],
            'cat' => ['nullable'],
            'ech' => ['nullable'],
            'hiring_date' => ['nullable'],
            'city' => ['nullable'],
            'fit' => ['nullable'],
            'desease' => ['nullable'],
            'matricule' => ['nullable', 'unique:users,matricule'],
            'country' => ['nullable'],
            'idCampus' => ['integer','nullable'],
            'salary' => ['nullable'],
            'hourlyPrice' => ['nullable'],
            'grade' => ['nullable'],
            'anciennete' => ['nullable'],
            'num_cnps' => ['nullable', 'string'],
            'niu' => ['nullable', 'string'],
            'agence' => ['nullable', 'string'],
            'service' => ['nullable', 'string'],
            'categorie' => ['nullable', 'string'],
            'num_dipe' => ['nullable', 'string'],
            'date_embauche' => ['nullable', 'date'],
            'idMatter' => 'integer|nullable',
            'idParent' => 'integer|nullable',
            'idLevel' => 'integer|nullable',
            'idCycle' => 'integer|nullable',
            'idClasse' => 'integer|nullable',
            'idClasse2' => 'integer|nullable',
            'old_classe' => 'string|nullable',
            'idClassePrincipal' => 'integer|nullable|exists:classes,id',
            'idOptionLevel' => 'integer|nullable',
            'idSchool' => 'integer|nullable',
            'idSection' => 'integer|nullable',
            'photo' => [
                'nullable',
//                'mimes:jpeg,png,pdf',
//                'max:2048', // 2Mo en kilo-octets
            ]
        ];
    }
}
