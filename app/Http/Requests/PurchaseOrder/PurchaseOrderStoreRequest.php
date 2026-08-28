<?php

namespace App\Http\Requests\PurchaseOrder;

use App\Enums\PurchaseOrderPaymentMethodEnum;
use App\Enums\PurchaseOrderPaymentStatusEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PurchaseOrderStoreRequest extends MyCustomRequest
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
            'supplier_id' => 'required|int|exists:users,id',
            'responsible_id' => 'required|int|exists:users,id',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:'.implode(',', PurchaseOrderStatusEnum::values()),
            'payment_method' => 'nullable|string|in:'.implode(',', PurchaseOrderPaymentMethodEnum::values()),
            'payment_status' => 'nullable|string|in:'.implode(',', PurchaseOrderPaymentStatusEnum::values()),
            'priority' => 'required|string|in:'.implode(',', PurchaseOrderPriorityEnum::values()),
            'quotation_file' => 'nullable|string',
//            'quotation_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'articles' => 'required|array|min:1',
            'articles.*.id' => 'required|integer|exists:articles,id',
            'articles.*.unit_price' => 'nullable|integer',
            'articles.*.quantity' => 'required|integer|min:1',
        ];
    }
}
