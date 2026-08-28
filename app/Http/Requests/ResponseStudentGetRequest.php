<?php

namespace App\Http\Requests;


class ResponseStudentGetRequest extends MyCustomRequest
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
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer',
            'filter_value' => 'nullable|string',

            'idAssessmentType' => 'nullable|integer|exists:assessment_type,id', // Vérifie que l'idAssessmentType existe dans la table assessment_type
            'idAssessment' => 'nullable|integer|exists:assessments,id', // Vérifie que l'idAssessment existe dans la table assessments
            'idUser' => 'nullable|integer|exists:users,id',
            "idQuestion" => 'nullable|integer|exists:questionnaires,id',
        ];
    }
}
