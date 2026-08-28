<?php

namespace App\Http\Requests\Litige;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Validation\Rule;

class LitigeUpdateRequest extends MyCustomRequest
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
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'answer' => 'nullable|string',
            'user_id' => 'nullable|integer|exists:users,id',
            'is_anonymous' => 'nullable|boolean',

        ];
    }

    /**
     * Prépare les données pour validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('is_anonymous')) {
            $this->merge([
                'is_anonymous' => $this->boolean('is_anonymous'),
            ]);
        }
    }

}
