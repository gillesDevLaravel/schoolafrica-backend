<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class HomeworkDoneGetAllRequest extends MyCustomRequest
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
            'idStudent' => "integer|nullable",
            'idClasse' => "integer|nullable",
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'idHomework' => "integer|nullable",
            'idTeacher' => "integer|nullable",
            'date_start' => "date|nullable|date_format:Y-m-d",
            'date_end' => "date|nullable|date_format:Y-m-d",
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
        ];
    }
}
