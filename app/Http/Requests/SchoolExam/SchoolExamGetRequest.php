<?php

namespace App\Http\Requests\SchoolExam;

use App\Http\Requests\MyCustomRequest;

class SchoolExamGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter_value' => 'nullable|string|max:255',
            'idMatter' => 'nullable|integer',
            'idOptionLevel' => 'nullable|integer',
            'idAssessmentType' => 'nullable|integer',
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer|min:1|max:1000000',
        ];
    }
}
