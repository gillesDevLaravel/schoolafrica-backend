<?php

namespace App\Http\Requests\Litige;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Validation\Rule;

class LitigeGetRequest extends MyCustomRequest
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
            'filter_value' => 'nullable|string|max:255',
            'nbreItems' => 'nullable|integer|min:1|max:1000000',
            'pageItems' => 'nullable|integer|min:1',
            'isAnonymous' => 'nullable|boolean',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'user_id' => 'nullable|integer|exists:users,id',
           
        ];
    }
    
    /**
     * Prépare les données pour validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('isAnonymous')) {
            $this->merge([
                'is_anonymous' => $this->boolean('isAnonymous'),
            ]);
        }
    }
}
