<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ExamStudentAllRequest extends MyCustomRequest
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
            'pageItems' => "integer|nullable|min:1",
            'nbreItems' => "integer|nullable",
            'idAssessment' => 'nullable|integer',
            'idAssessmentType' => 'nullable|integer',
            'idUser' => 'nullable|integer',
        ];
    }
}
