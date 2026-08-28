<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireAllRequest extends MyCustomRequest
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
            'idSchool' => 'nullable|integer|exists:schools,id',
            'idSection' => 'nullable|integer|exists:section,id',
            'idAssessment' => 'nullable|integer|exists:assessments,id',
            'idAssessmentType' => 'nullable|integer|exists:assessment_type,id',
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
            'order' => "boolean|nullable", // si on veut récupérer les questions dans un ordre complétement aléatoire
        ];
    }
}
