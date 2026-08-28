<?php

namespace App\Http\Requests\Classes;

use App\Http\Requests\MyCustomRequest;

class ClassesArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:classes,id'],
        ];
    }
}
