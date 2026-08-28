<?php

namespace App\Http\Requests\TypeRequete;

use App\Http\Requests\MyCustomRequest;

class TypeRequeteArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:type_requetes,id'],
        ];
    }
}
