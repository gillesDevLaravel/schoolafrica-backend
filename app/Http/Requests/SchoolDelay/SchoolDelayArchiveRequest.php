<?php

namespace App\Http\Requests\SchoolDelay;

use App\Http\Requests\MyCustomRequest;

class SchoolDelayArchiveRequest extends MyCustomRequest
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
     * Règles de validation pour l’archivage/restauration des retards scolaires.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:school_delays,id'],
        ];
    }
}
