<?php

namespace App\Http\Requests\Sanction;

use App\Http\Requests\MyCustomRequest;

class SanctionArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:sanctions,id'],
        ];
    }
}
