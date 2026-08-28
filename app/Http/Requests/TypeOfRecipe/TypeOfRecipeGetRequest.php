<?php

namespace App\Http\Requests\TypeOfRecipe;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TypeOfRecipeGetRequest extends MyCustomRequest
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
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer',
            'filter_value' => 'nullable|string',
            'name' => 'nullable|string',
            'category' => 'nullable|string',
            'school_id' => 'nullable|integer',
        ];
    }
}
