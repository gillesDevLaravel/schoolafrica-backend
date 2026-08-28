<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteRequest extends MyCustomRequest
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
            'categorie' => "required|in:interne,externe",
            'description' => "required",
            'idTypeRequete' => "required|integer",
            'statut' => "in:en_cours,valide,rejected",
            'reponse' => "nullable",
            'idUser' => "integer|required|exists:users,id",
//            'idSection' => "integer|nullable|exists:section,id",
//            'idSchool' => "integer|nullable|exists:schools,id",
        ];
    }
}
