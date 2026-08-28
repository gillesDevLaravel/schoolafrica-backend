<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\MyCustomRequest;

class ArticleArchiveRequest extends MyCustomRequest
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
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ];
    }
}
