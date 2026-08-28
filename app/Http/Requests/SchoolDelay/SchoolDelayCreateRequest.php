<?php

namespace App\Http\Requests\SchoolDelay;

use App\Http\Requests\MyCustomRequest;

class SchoolDelayCreateRequest extends MyCustomRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation pour la création d’un retard scolaire.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hour'        => 'required|date_format:H:i',
            'date'        => 'required|date',
            'description' => 'nullable|string|max:500',
            'type'        => 'nullable|string|max:255',
            'idStudents'   => 'required|array|min:1',
            'idStudents.*'   => 'required|integer|exists:users,id',
            'idCourse'    => 'nullable|integer|exists:courses,id',
        ];
    }
}
