<?php

namespace App\Http\Requests\AssessmentType;

use App\Http\Requests\MyCustomRequest;

class AssessmentTypeArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:assessment_type,id'],
        ];
    }
}
