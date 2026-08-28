<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssessmentGetAllRequest extends MyCustomRequest
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
            'idAssessmentType' => 'integer|nullable',
            'idClasse' => 'integer|nullable',
            'idTeacher' => 'integer|nullable',
            'idMatter' => 'integer|nullable',
            'idOptionLevel' => 'integer|nullable',
            'is_qcm' => 'boolean|nullable',
            'date' => 'date|nullable',
        ];
    }
}
