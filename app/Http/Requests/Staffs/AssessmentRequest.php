<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssessmentRequest extends MyCustomRequest
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
//            'assessments.*.idSchool' => ['integer', 'required'],
//            'assessments.*.idSection' => ['integer', 'required'],
            'assessments' => ['required','array'],
            'assessments.*.idMatter' => ['integer', 'required'],
            'assessments.*.idTeacher' => ['integer', 'nullable'],
            'assessments.*.idClasse' => ['integer', 'required'],
            'assessments.*.duration' => ['nullable', 'integer'],
            'assessments.*.notemax' => ['required'],
            'assessments.*.libelle' => ['string', 'nullable'],
            'assessments.*.hour' => ['nullable'],
            'assessments.*.day' => ['nullable'],
            'assessments.*.oral' => ['nullable'],
            'assessments.*.idCoeficient' => ['integer', 'nullable'],
            'assessments.*.orale' => ['nullable'],
            'assessments.*.ecrit' => ['nullable'],
            'assessments.*.written' => ['nullable'],
            'assessments.*.attitude' => ['nullable'],
            'assessments.*.savoir_etre' => ['nullable'],
            'assessments.*.pratical' => ['nullable'],
            'assessments.*.pratique' => ['nullable'],
            'assessments.*.percentage' => ['nullable'],
            'assessments.*.date' => ['nullable'],
            'assessments.*.is_qcm' => ['nullable', 'boolean'],
        ];
    }
}
