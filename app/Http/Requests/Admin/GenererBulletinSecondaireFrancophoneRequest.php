<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class GenererBulletinSecondaireFrancophoneRequest extends MyCustomRequest
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
            'idSchool' => "required|integer",
            'idSection' => "required|integer",
            'idStudent' => "required|integer",
            'idClasse' => "required|integer",
            'route' => "required|string",
            'idTrimestre' => "nullable|integer",
            'idAssessmentType' => "nullable|integer",
        ];
    }
}
