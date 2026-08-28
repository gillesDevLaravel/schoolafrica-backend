<?php

namespace App\Http\Requests\Memo;

use App\Http\Requests\MyCustomRequest;

class MemoCreateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'memos' => 'required|array',
            'memos.*.name' => 'required|string|max:255',
            'memos.*.description' => 'required|string|max:1000',
            'memos.*.type' => 'nullable|string|max:100',
            'memos.*.date' => 'nullable|date',
            'memos.*.image' => 'nullable|string|max:255',
        ];
    }
}
