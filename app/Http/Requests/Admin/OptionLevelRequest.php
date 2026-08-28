<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class OptionLevelRequest extends MyCustomRequest
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
            'optionlevels' => 'required|array',
            'optionlevels.*.name' => ['required', 'max:120'],
            'optionlevels.*.idSchool' => 'integer|required',
            'optionlevels.*.idSection' => 'integer|nullable',
            'optionlevels.*.idFiliere' => 'integer|nullable',
            'optionlevels.*.description' => 'string|nullable',
            'optionlevels.*.lang' => 'string|nullable',
        ];
    }
}
