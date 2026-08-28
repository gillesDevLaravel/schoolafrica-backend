<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class RatingGetAllRequest extends MyCustomRequest
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
            'idSchool' => 'integer|required',
            'idSection' => 'integer|nullable',
            'idClasse' => "integer|nullable",
            'idMatter' => "integer|nullable",
            'idStudent' => "integer|nullable",
            'idTeacher' => "integer|nullable",
            'idAssessmentType' => "integer|nullable",
            'idTypeEvaluation' => "integer|nullable",
            'idAssessment' => "integer|nullable",
            'idOptionLevel' => "integer|nullable",
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
        ];
    }
}
