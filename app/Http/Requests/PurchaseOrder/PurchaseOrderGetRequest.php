<?php

namespace App\Http\Requests\PurchaseOrder;

use App\Enums\PurchaseOrderPaymentStatusEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PurchaseOrderGetRequest extends MyCustomRequest
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
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer',
            'filter_value' => 'nullable|string',
            'date_start' => 'nullable|string',
            'date_end' => 'nullable|string',
            'status' => 'nullable|string|in:'.implode(',', PurchaseOrderStatusEnum::values()),
            'payment_status' => 'nullable|string|in:'.implode(',', PurchaseOrderPaymentStatusEnum::values()),
            'priority' => 'nullable|string|in:'.implode(',', PurchaseOrderPriorityEnum::values()),
            'supplier_id' => 'nullable|exists:users,id',
//            'hotel_id' => 'nullable|exists:hotels,id',
            'responsible_id' => 'nullable|exists:users,id',  // Le responsable doit exister dans la table users
            'article_ids' => 'nullable|array|min:1',
            'article_ids.*' => 'int|exists:articles,id',
        ];
    }
}
