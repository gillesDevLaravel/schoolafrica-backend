<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class DuplicateAssessmentRequest extends MyCustomRequest
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
            'assessments_id' => 'required|array',
            'assessments_id.*' => 'integer',
            'idClasse' => 'required|integer|exists:classes,id',
            'idTeacher' => 'required|integer|exists:users,id',
            'idAssessmentTypes' => 'nullable|array',
            'idAssessmentTypes.*' => 'integer',
            'date' => 'nullable|date'
        ];
    }
}
