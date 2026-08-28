<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PvPrimaireTrimestreRequest extends MyCustomRequest
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

            // Champs facultatifs, mais au moins un des deux est requis
            'idTrimestre' => 'nullable|integer|exists:trimestre,id',
            'idAssessmentType' => 'nullable|integer|exists:assessment_type,id',

            'idUser' => 'nullable|integer|exists:users,id',
            'idOptionLevel' => 'nullable|integer', // important pour l'école Juniors (Avec des classes bilingues)
            'styleMaternelle' => 'nullable|boolean',
            'sortUsers' => "nullable|string|in:merit,alphabetical",
        ];
    }
}
