<?php

namespace App\Http\Requests\ExplanationRequest;

use App\Http\Requests\MyCustomRequest;

class ExplanationRequestArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:explanation_requests,id'],
        ];
    }
}
