<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class CourseGetAllRequest extends MyCustomRequest
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
            'idSchool' => ['integer', 'nullable'],
            'idSection' => ['integer', 'nullable'],
            'idLevel' => ['integer', 'nullable'],
            'idPiece' => ['integer', 'nullable'],
            'idClasse' => ['integer', 'nullable'],
            'idTeacher' => ['integer', 'nullable'],
            'date_start' => ['nullable'],
            'date' => ['nullable'],
            'date_end' => ['nullable'],
            'filter_value' => ['nullable'],
            'pageItems' => ['integer', 'nullable'],
            'nbreItems' => ['integer', 'nullable'],
            'jour' => ['string', 'nullable'],
            'filterUniqueCourses' => ['boolean', 'nullable'],
        ];
    }
}
