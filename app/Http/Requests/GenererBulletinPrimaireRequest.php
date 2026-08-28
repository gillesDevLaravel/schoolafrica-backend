<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenererBulletinPrimaireRequest extends MyCustomRequest
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
            'styleMaternelle' => 'nullable|boolean',
            'idClasse' => 'nullable|integer|exists:classes,id',
            'idAssessmentType' => 'nullable|integer|exists:assessment_type,id', // séquence
            'idTrimestre' => 'nullable|integer|exists:trimestre,id', // séquence
            'route' => 'required|string', // le client (établissement) qui appelle cette route. Ex: juniors/cfa/abiscom/kingdom/...
            'idUser' => 'nullable|integer|exists:users,id',
            'idOptionLevel' => 'nullable|integer', // important pour l'école Juniors
            'idAcademicYear' => "integer|nullable",
        ];
    }
}
