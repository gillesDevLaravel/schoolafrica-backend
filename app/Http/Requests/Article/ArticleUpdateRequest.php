<?php

namespace App\Http\Requests\Article;

use App\Enums\ArticleTypeEnum;
use App\Http\Requests\MyCustomRequest;

class ArticleUpdateRequest extends MyCustomRequest
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
            'idSchool' => 'nullable|integer',
            'idSection' => 'nullable|integer',
            'name' => 'nullable|string',
            'type' => 'nullable|string|in:'.implode(',', ArticleTypeEnum::values()),
            'image' => 'nullable|string',
            //            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'unit_of_measurement' => 'nullable|string',
            'alert_quantity' => 'nullable|integer',
            'expiry_date' => 'nullable|date',

            'container' => 'nullable|string',
            'container_unit' => 'nullable|string|max:50',
            'container_quantity' => 'nullable|integer|min:0',
            'detail' => 'nullable|string',

//            'service_id' => 'nullable|integer|exists:services,id',
        ];
    }
}
