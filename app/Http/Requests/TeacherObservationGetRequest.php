<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherObservationGetRequest extends MyCustomRequest
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
            'idSchool' => "integer|required",
            'idSection' => "integer|nullable",
            'idAssessment' => "integer|nullable",
            'idStudent' => "integer|nullable",
            'idClasse' => "integer|nullable",
            'idTeacher' => "integer|nullable",
            'date_start' => "date|nullable",
            'date_end' => "date|nullable",
            'nbreItems' => "integer|nullable",
            'pageItems' => "integer|nullable",
            'filter_value' => "nullable",
        ];
    }
}
