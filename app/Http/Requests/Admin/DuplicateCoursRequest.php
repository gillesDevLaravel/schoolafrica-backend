<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DuplicateCoursRequest extends FormRequest
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
            'cours_id' => 'required|array',
            'cours_id.*' => 'integer',
            'idClasse' => 'required|integer|exists:classes,id',
            'idTeacher' => 'required|integer|exists:users,id'
        ];
    }
}
