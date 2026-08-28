<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsenceGetRequest extends MyCustomRequest
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
            'idTeacher' => "integer|nullable",
            'idStudent' => "integer|nullable",
            'idUser' => "integer|nullable",
            'type' => "nullable",
            'idClasse' => "integer|nullable",
            'date' => "nullable",
            'start_date' => "date|nullable",
            'end_date' => "date|nullable|after_or_equal:start_date",
            'filter_value' => "nullable",
            'is_justified' => "boolean|nullable",
        ];
    }
}
