<?php

namespace App\Http\Requests\TypeEvaluation;

use App\Http\Requests\MyCustomRequest;

class TypeEvaluationArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:type_evaluation,id'],
        ];
    }
}
