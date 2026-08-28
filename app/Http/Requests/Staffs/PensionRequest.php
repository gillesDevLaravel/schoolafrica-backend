<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class PensionRequest extends MyCustomRequest
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
            'pensions' => ['required', 'array'],
            'pensions.*.name' => ['nullable', 'string'],
            'pensions.*.price' => ['required', 'integer', 'min:0'],
            'pensions.*.nbrTranche' => ['required', 'integer'],
            'pensions.*.idLevel' => ['required', 'integer', 'exists:levels,id'],
            'pensions.*.idTypeOfRecipe' => "nullable|integer|exists:type_of_recipes,id",
//            'name' => ['required'],
//            'price' => ['required'],
//            'nbrTranche' => ['required'],
//            'idLevel' => 'integer|required',
//            'idSchool' => 'integer|nullable',
//            'idSection' => 'integer|nullable'
        ];
    }
}
