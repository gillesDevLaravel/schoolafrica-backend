<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProgressionRequest extends MyCustomRequest
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
            'idClasse' => 'integer|required',
            'name' => 'string|required',
            'description' => 'string|required',
//            'idSchool' => 'integer|nullable',
//            'idSection' => 'integer|nullable'
        ];
    }
}
