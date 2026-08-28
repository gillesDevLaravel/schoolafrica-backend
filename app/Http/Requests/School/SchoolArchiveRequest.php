<?php

namespace App\Http\Requests\School;

use App\Http\Requests\MyCustomRequest;

class SchoolArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:schools,id'],
        ];
    }
}
