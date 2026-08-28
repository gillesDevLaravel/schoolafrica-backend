<?php

namespace App\Http\Requests\ArticleMovement;

use App\Http\Requests\MyCustomRequest;

class ArticleMovementGetRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Autorise la requête (à ajuster selon ton système d'authentification)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer',
            'filter_value' => 'nullable|string',
            'article_id' => 'nullable|integer|exists:articles,id',
            'operation_type' => 'nullable|in:entry,exit',
//            'product_id' => 'nullable|integer|exists:products,id',
            //            'purchase_order_id' => 'nullable|integer|exists:purchase_orders,id',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date|after_or_equal:date_start',
        ];
    }
}
