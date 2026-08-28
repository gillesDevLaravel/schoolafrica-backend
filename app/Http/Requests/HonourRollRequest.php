<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HonourRollRequest extends MyCustomRequest
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
            "idUser" => 'nullable|integer|exists:users,id',
            'idClasse' => 'nullable|integer|exists:classes,id',
            "idTrimestre" => 'nullable|integer|exists:trimestre,id',
            "idOptionLevel" => 'nullable|integer|exists:option_level,id',

            'moyenne' => 'nullable|numeric',
            'route' => 'nullable|string',
        ];
    }
}
