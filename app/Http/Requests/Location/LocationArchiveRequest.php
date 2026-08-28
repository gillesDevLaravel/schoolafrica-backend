<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\MyCustomRequest;

class LocationArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:locations,id'],
        ];
    }
}
