<?php

namespace App\Http\Requests\Budget;

use App\Enums\BudgetTypeEnum;
use App\Http\Requests\MyCustomRequest;

class BudgetGetRequest extends MyCustomRequest
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
            'idSchool' => 'nullable|integer|exists:schools,id',
            'type' => 'nullable|string:in' . implode(',', BudgetTypeEnum::values()),
        ];
    }
}
