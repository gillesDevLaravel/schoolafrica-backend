<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class GenererBulletinMaternelleClassiqueRequest extends MyCustomRequest
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
            'idClasse' => 'required|integer|exists:classes,id',
            'route' => 'nullable|string',
            'idUser' => 'nullable|integer|exists:users,id',
            'idAssessmentType' => 'nullable|integer|exists:assessment_type,id',
            'idOptionLevel' => 'nullable|integer',
            'idTrimestre' => 'nullable|integer|exists:assessment_type,id',
        ];
    }
}
