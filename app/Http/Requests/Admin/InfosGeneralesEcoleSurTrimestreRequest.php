<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class InfosGeneralesEcoleSurTrimestreRequest extends MyCustomRequest
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
            'idSchool' => 'required|exists:schools,id',
            'idSection' => 'required|exists:section,id',
//            'nameTrimestre' => 'required|string',
            'idTrimestre' => 'required|exists:trimestre,id',
            'route' => 'required|string',
        ];
    }
}
