<?php

namespace App\Http\Requests\ExplanationRequest;

use App\Http\Requests\MyCustomRequest;

class ExplanationRequestGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'date' => 'nullable|string',
            'idUser' => 'nullable|integer',
            'idResponsable' => 'nullable|integer',
            'date_start' => 'nullable|string',
            'date_end' => 'nullable|string',
            'pageItems' => 'nullable|integer',
            'nbreItems' => 'nullable|integer'
        ];
    }
}