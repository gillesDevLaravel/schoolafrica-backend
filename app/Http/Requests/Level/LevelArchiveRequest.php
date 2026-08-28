<?php

namespace App\Http\Requests\Level;

use App\Http\Requests\MyCustomRequest;

class LevelArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:levels,id'],
        ];
    }
}
