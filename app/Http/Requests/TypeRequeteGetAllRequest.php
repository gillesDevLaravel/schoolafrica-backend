<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequeteGetAllRequest extends MyCustomRequest
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
            'idTypeRequete' => "nullable|integer",
            'statut' => "nullable|in:en_cours,valide,rejected",
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'idUser' => "integer|nullable",
            'categorie' => "nullable|in:interne,externe",
            'filter_value' => "nullable",
            'date_start' => "date|nullable",
            'date_end' => "date|nullable",
        ];
    }
}
