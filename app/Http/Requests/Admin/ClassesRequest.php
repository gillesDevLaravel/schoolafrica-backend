<?php

namespace App\Http\Requests\Admin;

use App\Enums\ClassStyleEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClassesRequest extends MyCustomRequest
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
            'classes' => 'required|array',
            'classes.*.name' => 'required|max:120',
            'classes.*.idLevel' => 'integer|required|exists:levels,id',
            'classes.*.idTeacher' => 'integer|nullable',
            'classes.*.idOptionLevel' => 'integer|nullable',
            'classes.*.description' => 'string|nullable',
            'classes.*.style' => 'nullable|in:' . implode(',', ClassStyleEnum::values()),
            'classes.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'classes.*.nextClasses' => 'nullable|array|min:1',
            'classes.*.nextClasses.*' => 'required|integer|exists:classes,id',
        ];
    }
}
