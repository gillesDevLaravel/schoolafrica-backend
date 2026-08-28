<?php

namespace App\Http\Requests\Progression;

use App\Http\Requests\MyCustomRequest;

class ProgressionArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:progressions,id'],
        ];
    }
}
