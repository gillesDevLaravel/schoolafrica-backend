<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class LevelRequest extends MyCustomRequest
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
            'levels' => 'required|array',
            'levels.*.name' => ['required', 'max:120'],
            'levels.*.description' => ['required', 'max:120'],
            'levels.*.idCycle' => 'integer|required',
            'levels.*.idSchool' => 'integer|required',
            'levels.*.idSection' =>  'integer|nullable|exists:section,id',
        ];
    }
}
