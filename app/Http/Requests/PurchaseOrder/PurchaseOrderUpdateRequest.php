<?php

namespace App\Http\Requests\PurchaseOrder;

use App\Enums\DisbursementPaymentMethodEnum;
use App\Enums\PurchaseOrderPaymentMethodEnum;
use App\Enums\PurchaseOrderPaymentStatusEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PurchaseOrderUpdateRequest extends MyCustomRequest
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
            'supplier_id' => 'nullable|int|exists:users,id',
            'responsible_id' => 'nullable|int|exists:users,id',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:'.implode(',', PurchaseOrderStatusEnum::values()),
            'payment_method' => 'nullable|string|in:'.implode(',', PurchaseOrderPaymentMethodEnum::values()),
            'payment_status' => 'nullable|string|in:'.implode(',', PurchaseOrderPaymentStatusEnum::values()),
            'priority' => 'nullable|string|in:'.implode(',', PurchaseOrderPriorityEnum::values()),
            'quotation_file' => 'nullable|string',
//            'quotation_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'articles' => 'nullable|array|min:1',
            'articles.*.id' => 'nullable|int|exists:articles,id',
            'articles.*.unit_price' => 'nullable|int',
            'articles.*.quantity' => 'nullable|int|min:1',

//            'payment_method' => 'nullable|string|in:' . implode(',', DisbursementPaymentMethodEnum::values()),
        ];
    }
}
