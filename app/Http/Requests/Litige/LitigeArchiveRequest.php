<?php

namespace App\Http\Requests\Litige;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Validation\Rule;

class LitigeArchiveRequest extends MyCustomRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Récupère les règles de validation qui s'appliquent à la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => [
                'integer',
                Rule::exists('litiges', 'id')
            ],
        ];
    }
    
    
}
