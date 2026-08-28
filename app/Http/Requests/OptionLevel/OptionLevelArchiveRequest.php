<?php

namespace App\Http\Requests\OptionLevel;

use App\Http\Requests\MyCustomRequest;

class OptionLevelArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:option_level,id'],
        ];
    }
}
