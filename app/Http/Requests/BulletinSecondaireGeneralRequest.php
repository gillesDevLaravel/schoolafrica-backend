<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulletinSecondaireGeneralRequest extends MyCustomRequest
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
            'idClasse' => "integer|required",
            'idTrimestre' => "integer|nullable|exists:trimestre,id",
            'idAssessmentType' => "integer|nullable|exists:assessment_type,id",
            'idUser' => "integer|nullable",
            "idOptionLevel" => "integer|nullable",
        ];
    }
}
