<?php

namespace App\Http\Requests\Memo;

use App\Http\Requests\MyCustomRequest;

class MemoGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'type' => 'nullable|string',
            'date' => 'nullable|date',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'filter_value' => 'nullable|string',
            'pageItems' => 'nullable|integer',
            'nbreItems' => 'nullable|integer'
        ];
    }
}
