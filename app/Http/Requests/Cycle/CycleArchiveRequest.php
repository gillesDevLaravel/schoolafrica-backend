<?php

namespace App\Http\Requests\Cycle;

use App\Http\Requests\MyCustomRequest;

class CycleArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:cycles,id'],
        ];
    }
}
