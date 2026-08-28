<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceGetAllRequest extends MyCustomRequest
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
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'statut' => "nullable|in:paid,unpaid",
            'mode' => "nullable|string",
            'idTypeInvoice' => "integer|nullable",
            'idProduct' => "integer|nullable|exists:products,id",
            'idUser' => "integer|nullable",
            'purchase_order_id' => "integer|nullable|exists:purchase_orders,id",
            'date_start' => "date|nullable",
            'date_end' => "date|nullable",
            'type' => "nullable|string",
            'typeUser' => "string|nullable",
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
        ];
    }
}
