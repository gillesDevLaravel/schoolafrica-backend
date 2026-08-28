<?php

namespace App\Http\Requests\Campus;

use App\Http\Requests\MyCustomRequest;

class CampusArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:campus,id'],
        ];
    }
}
