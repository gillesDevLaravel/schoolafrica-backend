<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hour' => ['required'],
            'duration' => ['required'],
            'day' => ['required'],
            'idMatter' => ['integer', 'required'],
            'idClasse' => ['integer', 'required'],
            'idTeacher' => ['integer', 'required'],
            'idSchool' => ['integer', 'nullable'],
            'idSection' => ['integer', 'nullable'],
            'idLevel' => ['integer', 'nullable'],
            'idPiece' => ['integer', 'nullable'],
        ];
    }
}
