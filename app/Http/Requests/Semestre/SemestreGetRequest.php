<?php

namespace App\Http\Requests\Semestre;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SemestreGetRequest extends MyCustomRequest
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
            'filter_value' => 'nullable|string|max:255',
            'nbreItems'    => 'nullable|integer|min:1|max:1000000',
            'pageItems'    => 'nullable|integer|min:1',
        ];
    }
}
