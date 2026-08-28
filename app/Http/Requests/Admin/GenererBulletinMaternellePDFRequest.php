<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class GenererBulletinMaternellePDFRequest extends MyCustomRequest
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
            'idSchool' => 'required|integer',
            'idSection' => 'required|integer',
            'idClasse' => 'required|integer',
            'idStudent' => 'nullable|integer',
        ];
    }
}
