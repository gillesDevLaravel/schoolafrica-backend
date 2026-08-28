<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class GenererBulletinPrimaireSequenceRequest extends MyCustomRequest
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
            'idClasse' => 'required|integer|exists:classes,id',
            'route' => 'required|string', // le client (établissement) qui appelle cette route. Ex: juniors/cfa/abiscom/kingdom/...
            'idUser' => 'nullable|integer|exists:users,id',
            'idAssessmentType' => 'required|integer|exists:assessment_type,id', // séquence
            'idOptionLevel' => 'nullable|integer', // important pour l'école Juniors
            'forSolvables' => 'nullable|boolean', // si on souhaite telecharger uniquement pour les solvables
        ];
    }
}
