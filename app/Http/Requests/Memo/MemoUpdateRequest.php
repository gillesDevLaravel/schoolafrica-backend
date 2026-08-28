<?php

namespace App\Http\Requests\Memo;

use Illuminate\Foundation\Http\FormRequest;

class MemoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'nullable|string|max:100',
            'date' => 'nullable|date',
            'image' => 'nullable|string|max:255',
        ];
    }
}
