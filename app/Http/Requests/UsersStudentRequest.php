<?php

namespace App\Http\Requests;

use App\Http\Requests\MyCustomRequest;

class UsersStudentRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idStudent' => ['required', 'integer'],
            'idSchool' => ['nullable', 'integer'],
            'idSection' => ['nullable', 'integer'],
        ];
    }
}
