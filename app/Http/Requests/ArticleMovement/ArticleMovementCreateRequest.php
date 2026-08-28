<?php

namespace App\Http\Requests\ArticleMovement;

use App\Enums\ArticleMovementOperationTypeEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ArticleMovementCreateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'article_movements.*.quantity' => 'required|integer',
            'article_movements.*.reason' => 'nullable|string',
            'article_movements.*.date' => 'nullable|date',
            'article_movements.*.description' => 'nullable|string',
            'article_movements.*.operation_type' => 'required|string|in:' . implode(',', ArticleMovementOperationTypeEnum::values()),
            'article_movements.*.idUser' => 'nullable|integer|exists:users,id',
            'article_movements.*.article_id' => 'required|integer|exists:articles,id',
            'article_movements.*.purchase_order_id' => 'nullable|integer|exists:purchase_orders,id',
        ];
    }
}
