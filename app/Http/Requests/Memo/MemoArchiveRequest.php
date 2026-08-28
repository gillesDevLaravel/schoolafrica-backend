<?php

namespace App\Http\Requests\Memo;

use App\Http\Requests\MyCustomRequest;

class MemoArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:memos,id',
        ];
    }
}
