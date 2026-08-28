<?php

namespace App\Http\Requests\Trimestre;

use App\Http\Requests\MyCustomRequest;

class TrimestreArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:trimestre,id'],
        ];
    }
}
