<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SolvableRequest extends MyCustomRequest
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
            'idSchool' => ['integer', 'required'],
            'idSection' => ['integer', 'nullable'],
            'nameTranche' => ['string', 'nullable'],
            'idClasse' => ['integer', 'nullable'],

//            'nbreItems' => ['integer', 'nullable'],
//            'pageItems' => ['integer', 'nullable'],
        ];
    }
}
