<?php

namespace App\Http\Requests\Article;

use App\Enums\ArticleTypeEnum;
use App\Http\Requests\MyCustomRequest;

class ArticleGetRequest extends MyCustomRequest
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
//            'service_id' => 'integer|nullable|exists:services,id',
            'idSchool' => 'nullable|integer',
            'idSection' => 'nullable|integer',
            'type' => 'nullable|string|in:'.implode(',', ArticleTypeEnum::values()),
            'expired' => 'nullable|boolean',
        ];
    }
}
