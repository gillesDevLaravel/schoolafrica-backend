<?php

namespace App\Http\Requests\Section;

use App\Http\Requests\MyCustomRequest;

class SectionArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:section,id'],
        ];
    }
}
