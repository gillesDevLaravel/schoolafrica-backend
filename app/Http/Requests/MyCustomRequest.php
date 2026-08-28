<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * My Custom Request
 *
 * J'ai crée celle ci pour modifier le retour d'erreur dpar défaut du Validator Laravel
 *
 * Celà dit, TOUTES mes Requests vont extend celle ci, en vue d'avoir ma méthode failedValitation()
 */
class MyCustomRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        // Récupérer les erreurs de validation
        $errors = $validator->errors();

        // Lever une nouvelle exception avec les erreurs personnalisées
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $this->formatErrors($errors),
        ], 422));
    }

    /**
     * Formater les erreurs comme le front l'attend
     *
     * @param $errors
     * @return string
     */
    protected static function formatErrors($errors)
    {
        return implode(" ", $errors->all());
    }
}
