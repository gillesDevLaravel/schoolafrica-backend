<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class BulletinSecondaireTrimestreRequest extends MyCustomRequest
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
            'idTrimestre' => "integer|required|exists:trimestre,id",
            'idUser' => "integer|nullable",
            'idAssessmentType' => "integer|nullable",
            "idOptionLevel" => "integer|nullable",
        ];
    }
}
