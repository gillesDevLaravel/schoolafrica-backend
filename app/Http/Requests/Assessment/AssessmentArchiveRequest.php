<?php

namespace App\Http\Requests\Assessment;

use App\Http\Requests\MyCustomRequest;

class AssessmentArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:assessments,id'],
        ];
    }
}
