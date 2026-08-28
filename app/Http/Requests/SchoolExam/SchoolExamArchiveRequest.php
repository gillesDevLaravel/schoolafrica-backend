<?php

namespace App\Http\Requests\SchoolExam;

use App\Http\Requests\MyCustomRequest;

class SchoolExamArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:schools_exams,id'],
        ];
    }
}
