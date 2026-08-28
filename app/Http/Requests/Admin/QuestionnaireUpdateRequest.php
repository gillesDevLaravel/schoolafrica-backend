<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireUpdateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idAssessment' => "required|integer|exists:assessments,id",
            'idAssessmentType' => "required|integer|exists:assessment_type,id",
            'intitule' => "required|string|max:200",
            'reponse' => "nullable|string|max:200",
            'notemax' => "nullable|integer",
        ];
    }
}
