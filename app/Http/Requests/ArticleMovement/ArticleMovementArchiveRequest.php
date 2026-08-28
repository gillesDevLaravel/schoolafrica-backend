<?php

namespace App\Http\Requests\ArticleMovement;

use Illuminate\Foundation\Http\FormRequest;

class ArticleMovementArchiveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:article_movements,id',
        ];
    }
}
