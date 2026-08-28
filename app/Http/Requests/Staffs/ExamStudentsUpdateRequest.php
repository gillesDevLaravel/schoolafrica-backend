<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;

class ExamStudentsUpdateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return auth()->user() && in_array(auth()->user()->getRole()->id, [2]); //N'importe quel dev peut comprendre ça
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            // 'idAssessment' => 'required|integer',
            // 'idAssessmentType' => 'required|integer',
            // 'idUser' => 'required|integer',
        ];
    }
}
