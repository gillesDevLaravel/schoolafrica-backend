<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BourseRequest extends MyCustomRequest
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
            'bourses' => "required|array",
            'bourses.*.name' => "required|string",
            'bourses.*.description' => "required|string",
            'bourses.*.amount' => "required",
            'bourses.*.idSchool' => "integer|required|exists:schools,id",
            'bourses.*.idSection' => "integer|nullable"
        ];
    }
}
