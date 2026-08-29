<?php

namespace App\Http\Requests\Tutorial;

use App\Http\Requests\MyCustomRequest;

class TutorialArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'required|integer|exists:tutorials,id',
        ];
    }
}
