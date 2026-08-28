<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class FeeUserSolvableRequest extends MyCustomRequest
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
            'idSchool' => "required|exists:schools,id",
            'idFee' => "required|exists:fees,id",
            'idSection' => "nullable|exists:section,id",
            'idLevel' => "nullable|exists:levels,id",
            'idClasse' => "nullable|exists:classes,id",
            'idStudent' => "nullable|exists:users,id",
        ];
    }
}
