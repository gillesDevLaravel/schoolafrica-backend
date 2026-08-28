<?php

namespace App\Http\Requests\Semestre;

use App\Http\Requests\MyCustomRequest;

class SemestreArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:semestres,id'],
        ];
    }
}
