<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class CashInStoreRequest extends MyCustomRequest
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
            'idClient' => "required|integer|exists:users,id",
            'amount_to_receive' => 'nullable|numeric',
            'amount_received' => 'nullable|numeric',
            'reason' => "required|string",
            'payment_method' => "required|string",
            'irpp' => "required|boolean",
            'payment_date' => "required|date|date_format:Y-m-d",
            'receipt_number' => "nullable|string",
            'operator' => "nullable|string",
            'idTypeOfRecipe' => "nullable|integer|exists:type_of_recipes,id",
        ];
    }
}
