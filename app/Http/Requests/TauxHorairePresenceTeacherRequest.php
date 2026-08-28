<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TauxHorairePresenceTeacherRequest extends MyCustomRequest
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
            'date_debut' => "required|date",
            'date_fin' => "required|date",
            'idTeacher' => "integer|required|exists:users,id",
        ];
    }
}
