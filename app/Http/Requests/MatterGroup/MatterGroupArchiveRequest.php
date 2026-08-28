<?php

namespace App\Http\Requests\MatterGroup;

use App\Http\Requests\MyCustomRequest;

class MatterGroupArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:matter_group,id'],
        ];
    }
}
