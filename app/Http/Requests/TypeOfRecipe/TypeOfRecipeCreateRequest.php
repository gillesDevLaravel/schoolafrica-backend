<?php

namespace App\Http\Requests\TypeOfRecipe;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TypeOfRecipeCreateRequest extends MyCustomRequest
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
            'type_of_recipes' => 'required|array|min:1',
            'type_of_recipes.*.name' => 'required|string',
            'type_of_recipes.*.code' => 'nullable|string',
            'type_of_recipes.*.category' => 'required|string',
            'type_of_recipes.*.idSchool' => 'nullable|integer',
        ];
    }
}
