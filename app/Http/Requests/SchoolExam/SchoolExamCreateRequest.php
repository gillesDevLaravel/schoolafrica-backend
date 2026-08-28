<?php

namespace App\Http\Requests\SchoolExam;

use App\Http\Requests\MyCustomRequest;

class SchoolExamCreateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'exams' => 'required|array',
            'exams.*.description' => 'nullable|string|max:255',
            'exams.*.answer' => 'nullable|string|max:255',
            'exams.*.name' => 'required|string|max:255',
            'exams.*.image' => 'nullable|string|max:255',
            'exams.*.idOptionLevel' => 'nullable|integer',
            'exams.*.idMatter' => 'required|integer',
            'exams.*.idAssessmentType' => 'required|integer',
            'exams.*.classes' => 'nullable|array',
            'exams.*.classes.*' => 'integer|exists:classes,id',
        ];
    }
}
