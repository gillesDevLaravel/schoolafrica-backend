<?php

namespace App\Http\Requests\Establishment;

use App\Http\Requests\MyCustomRequest;

class EstablishmentArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:establishments,id'],
        ];
    }
}
