<?php

namespace App\Http\Requests\Tutorial;

use App\Http\Requests\MyCustomRequest;

class TutorialGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category'     => 'nullable|string',
            'target_role'  => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'filter_value' => 'nullable|string',
            'pageItems'    => 'nullable|integer',
            'nbreItems'    => 'nullable|integer',
        ];
    }
}
