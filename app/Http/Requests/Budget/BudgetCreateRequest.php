<?php

namespace App\Http\Requests\Budget;

use App\Enums\BudgetTypeEnum;
use App\Http\Requests\MyCustomRequest;

class BudgetCreateRequest extends MyCustomRequest
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
        // On récupère la valeur du champ "type"
        $type = $this->input('type');

        // On déduit la table cible pour la validation 'exists'
        $table = $type === 'INVOICE' ? 'type_invoices' : ($type === 'RECIPE' ? 'type_of_recipes' : null);

        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', BudgetTypeEnum::values()),
            'description' => 'nullable|string',
            'realisation' => 'nullable|numeric|min:0|max:100',
            'idSchool' => 'nullable|integer|exists:schools,id',

            'type_invoice_or_type_recipe_items' => 'required|array|min:1',

            'type_invoice_or_type_recipe_items.*.item_id' => array_filter([
                'required',
                'integer',
                $table ? 'exists:' . $table . ',id' : null, // null sera ignoré
            ]),

            'type_invoice_or_type_recipe_items.*.quantity' => 'nullable|integer|min:1',
            'type_invoice_or_type_recipe_items.*.number'   => 'nullable|numeric|min:1',
            'type_invoice_or_type_recipe_items.*.amount'   => 'nullable|numeric|min:0',
        ];
    }
}
