<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PDFListStudentAnswersOnAssessmentRequest extends MyCustomRequest
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
            'idStudent' => 'nullable|integer|exists:users,id',
            'idAssessmentType' => 'required|integer|exists:assessment_type,id',
            'idAssessment' => 'nullable|integer|exists:assessments,id',
            'route' => "nullable|string",
        ];
    }
}
