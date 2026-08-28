<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\MyCustomRequest;

class BookArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:books,id'],
        ];
    }
}
