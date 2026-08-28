<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends MyCustomRequest
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
            'invoices' => 'required|array',
            'invoices.*.amount' => 'required',
            'invoices.*.reasons' => 'required',
            'invoices.*.purchase_order_id' => 'nullable|integer',
            'invoices.*.image' => 'nullable|string',
            'invoices.*.payment_deadline' => 'nullable',
            'invoices.*.date' => ['required', 'date'],
            'invoices.*.idSchool' => 'required|integer',
            'invoices.*.idSection' => 'nullable|integer',
            'invoices.*.statut' => 'required|in:unpaid,paid',
            'invoices.*.mode' => 'required|string',
            'invoices.*.typeUser' => 'required|in:customer,user',
            'invoices.*.idUser' => 'integer|required',
            'invoices.*.idTypeInvoice' => 'integer|required|exists:type_invoices,id',
            'invoices.*.idProduct' => 'integer|nullable|exists:products,id',
            'invoices.*.type_produit' => 'string|nullable',
            'invoices.*.quantite' => 'integer|nullable',
            'invoices.*.prix_unitaire' => 'integer|nullable',
            'invoices.*.salary_components' => 'nullable|array',
            'invoices.*.salary_components.*.salary_component_id' => 'nullable|integer|exists:salary_components,id',
            'invoices.*.salary_components.*.coef' => 'nullable|numeric',
            'invoices.*.salary_components.*.base_amount' => 'nullable|numeric',
            'invoices.*.salary_components.*.base_patronal' => 'nullable|numeric',
            'invoices.*.salary_components.*.coef_patronal' => 'nullable|numeric',
        ];
    }

    public function updateRules()
    {
        return [
            'amount' => 'nullable|numeric',
            'reasons' => 'nullable|string',
            'purchase_order_id' => 'nullable|integer',
            'image' => 'nullable|string',
            'payment_deadline' => 'nullable|date',
            'date' => 'nullable|date',
            'idSchool' => 'nullable|integer',
            'idSection' => 'nullable|integer',
            'statut' => 'nullable|in:unpaid,paid',
            'mode' => 'nullable|string',
            'type' => 'nullable|in:customer,user',
            'idUser' => 'nullable|integer',
            'idTypeInvoice' => 'nullable|integer|exists:type_invoices,id',
            'idProduct' => 'nullable|integer|exists:products,id',
            'type_produit' => 'nullable|string',
            'quantite' => 'nullable|integer',
            'prix_unitaire' => 'nullable|numeric',
            'salary_components' => 'nullable|array',
            'salary_components.*.salary_component_id' => 'nullable|integer|exists:salary_components,id',
            'salary_components.*.coef' => 'nullable|numeric',
            'salary_components.*.base_amount' => 'nullable|numeric',
            'salary_components.*.base_patronal' => 'nullable|numeric',
            'salary_components.*.coef_patronal' => 'nullable|numeric',
        ];
    }
}
