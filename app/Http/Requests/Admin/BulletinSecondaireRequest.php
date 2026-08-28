<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class BulletinSecondaireRequest extends MyCustomRequest
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
            'idClasse' => "integer|required|exists:classes,id",

            // Champs facultatifs, mais au moins un des deux est requis
            'idSemestre'       => 'nullable|integer|exists:semestres,id',
            'idTrimestre' => 'nullable|integer|exists:trimestre,id',
            'idAssessmentType' => 'nullable|integer|exists:assessment_type,id',

            'idUser' => "integer|nullable",
            "idOptionLevel" => "integer|nullable",
        ];
    }
}
