<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class CyclesRequest extends MyCustomRequest
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
            'cycles' => ['required', 'array'],
            'cycles.*.name' => ['required', 'max:120'],
            'cycles.*.idSchool' => 'integer|required',
            'cycles.*.idCampus' => 'integer|nullable',
            'cycles.*.idSection' => 'integer|nullable',
            'cycles.*.description' => 'string|nullable',
        ];
    }
}
