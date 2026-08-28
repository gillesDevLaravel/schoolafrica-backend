<?php

namespace App\Http\Requests\Matter;

use App\Http\Requests\MyCustomRequest;

class MatterArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:matter,id'],
        ];
    }
}
