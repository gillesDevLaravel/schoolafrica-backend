<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TeacherObservationRequest extends MyCustomRequest
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
            'description' => ['required'],
            'answer' => ['nullable'],
            'idAssessment' => "integer|nullable",
            'idStudent' => "integer|nullable|required_without:idClasse",
            'idClasse'  => "integer|nullable|required_without:idStudent",
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'idTeacher' => "integer|nullable",
        ];
    }
}
