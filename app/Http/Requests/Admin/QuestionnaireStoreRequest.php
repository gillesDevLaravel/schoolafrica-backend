<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireStoreRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // le student ne doit pas créer/modifier de questions
        return auth()->user()->getRole()->id !== 8;
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
            'intitule' => "required|string",
            'reponse' => "nullable|string",
            'notemax' => "nullable|integer",
        ];
    }
}
