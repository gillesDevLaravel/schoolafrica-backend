<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResponseStudentRequest extends MyCustomRequest
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
            'idAssessment' => 'required|integer|exists:assessments,id', // Vérifie que l'idAssessment existe dans la table assessments
            'idAssessmentType' => 'required|integer|exists:assessment_type,id', // Vérifie que l'idAssessmentType existe dans la table assessment_type
            "responses" => 'nullable|array',
            "responses.*.idQuestion" => 'required|integer|exists:questionnaires,id',
            "responses.*.response" => 'nullable|string',
        ];
    }
}
