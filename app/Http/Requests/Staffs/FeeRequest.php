<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends MyCustomRequest
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
            'name' => ['required'],
            'description' => ['nullable'],
            'price' => ['required'],
            'deadline' => ['required'],
            'order' => 'nullable|integer',
            'required' => 'nullable|boolean',
            'idSchool' => 'integer|required',
            'idSection' => 'integer|nullable',
            'idTypeOfRecipe' => 'integer|nullable|exists:type_of_recipes,id'
        ];
    }
}
