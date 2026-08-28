<?php

namespace App\Http\Requests\SupplyDemand;

use App\Enums\SupplyDemandPriorityEnum;
use App\Enums\SupplyDemandStatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class SupplyDemandCreateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Autorisation activée
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'           => ['nullable', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'responsible_id' => ['required', 'integer', 'exists:users,id'],
            'priority'       => 'nullable|string|in:' . implode(',', SupplyDemandPriorityEnum::values()),
            'status'         => 'nullable|string|in:' . implode(',', SupplyDemandStatusEnum::values()),
            'articles' => 'required|array|min:1',
            'articles.*.id' => 'required|integer|exists:articles,id',
            'articles.*.unit_price' => 'nullable|integer',
            'articles.*.quantity' => 'required|integer|min:1',
            'articles.*.supplier_id' => 'required|int|exists:users,id',
        ];
    }
}
