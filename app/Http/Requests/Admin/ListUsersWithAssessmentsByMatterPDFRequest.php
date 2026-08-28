<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ListUsersWithAssessmentsByMatterPDFRequest extends MyCustomRequest
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
            'idAcademicYear' => "integer|nullable",
            'idClasse' => 'required|integer|exists:classes,id',
            'idTrimestre' => 'required|integer|exists:trimestre,id',
            'idAssessment' => 'required|integer|exists:assessments,id',
//            'idMatter' => 'required|integer|exists:matter,id',
        ];
    }
}
