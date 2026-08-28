<?php

namespace App\Http\Requests\SchoolExam;

use App\Http\Requests\MyCustomRequest;

class SchoolExamUpdateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'answer' => 'nullable|string|max:255',
            'idOptionLevel' => 'nullable|integer',
            'idMatter' => 'nullable|integer',
            'idAssessmentType' => 'nullable|integer',
            'classes' => 'nullable|array',
            'classes.*' => 'integer|exists:classes,id',
        ];
    }
}
