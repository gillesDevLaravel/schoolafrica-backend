<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class MarkOnlineExamGetStudentResponsesRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->getRole()->id !== 8;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idUser' => 'required|integer|exists:users,id',
            'idAssessment' => 'required|integer|exists:assessments,id',
            'idAssessmentType' => 'required|integer|exists:assessment_type,id',
        ];
    }
}
