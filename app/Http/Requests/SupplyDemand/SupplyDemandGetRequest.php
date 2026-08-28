<?php

namespace App\Http\Requests\SupplyDemand;

use App\Enums\SupplyDemandPriorityEnum;
use App\Enums\SupplyDemandStatusEnum;
use App\Http\Requests\MyCustomRequest;

class SupplyDemandGetRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'filter_value'   => ['nullable', 'string'],
            'responsible_id' => ['nullable', 'integer', 'exists:users,id'],
            'hotel_id' => 'integer|nullable|exists:hotels,id',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'priority'       => 'nullable|string|in:' . implode(',', SupplyDemandPriorityEnum::values()),
            'status'         => 'nullable|string|in:' . implode(',', SupplyDemandStatusEnum::values()),
            'article_ids'    => ['nullable', 'array'],
            'article_ids.*'  => ['integer', 'exists:articles,id'],
        ];
    }
}
