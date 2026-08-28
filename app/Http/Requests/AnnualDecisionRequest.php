<?php

namespace App\Http\Requests;

class AnnualDecisionRequest extends MyCustomRequest
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
            'annualDecisions' => 'nullable|array|min:1', //si on souhaite personnaliser la decision annuelle (inscrire un texte precis)
            'annualDecisions.*.idStudent' => 'required|integer|exists:users,id',
            'annualDecisions.*.decision' => 'required|string',
            'idOptionLevel' => 'nullable|integer|exists:option_level,id',

            'idClasse' => 'nullable|integer|exists:classes,id', //Si on souhaite remplir automatiquement pour une classe precise

            'idSchool' => 'nullable|integer|exists:schools,id', //si on souhaite remplir automatiquement pour toute une ecole

            'successValue' => 'nullable|numeric',

            'automatic' => 'required|boolean', //Preciser s'il s'agit du primaire + maternelle (true) ou du secondaire (false ou null)

            'admissionText' => 'nullable|string',

            'repeatText' => 'nullable|string'
        ];
    }
}
