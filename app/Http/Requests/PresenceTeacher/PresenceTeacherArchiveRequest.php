<?php

namespace App\Http\Requests\PresenceTeacher;

use Illuminate\Foundation\Http\FormRequest;

class PresenceTeacherArchiveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:presence_teacher,id',
        ];
    }
}
