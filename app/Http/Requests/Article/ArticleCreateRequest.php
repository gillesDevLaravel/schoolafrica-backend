<?php

namespace App\Http\Requests\Article;

use App\Enums\ArticleTypeEnum;
use App\Http\Requests\MyCustomRequest;

class ArticleCreateRequest extends MyCustomRequest
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
            'articles' => 'required|array|min:1',
            'articles.*.idSchool' => 'required|integer',
            'articles.*.idSection' => 'nullable|integer',
            'articles.*.name' => 'required|string',
            'articles.*.type' => 'required|string|in:'.implode(',', ArticleTypeEnum::values()),
            'articles.*.image' => 'nullable|string',
            //            'articles.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'articles.*.price' => 'required|numeric',
            'articles.*.description' => 'nullable|string',
            'articles.*.unit_of_measurement' => 'nullable|string',
            'articles.*.alert_quantity' => 'nullable|integer',
            'articles.*.expiry_date' => 'nullable|date',

            'articles.*.container' => 'nullable|string',
            'articles.*.container_unit' => 'nullable|string|max:50',
            'articles.*.container_quantity' => 'nullable|integer|min:0',
            'articles.*.detail' => 'nullable|string',

//            'articles.*.service_id' => 'required|integer|exists:services,id',

            'articles.*.suppliers' => 'nullable|array|min:1',
            'articles.*.suppliers.*' => 'required|integer',
        ];
    }
}
