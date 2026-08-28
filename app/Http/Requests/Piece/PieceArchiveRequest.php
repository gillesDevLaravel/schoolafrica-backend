<?php

namespace App\Http\Requests\Piece;

use App\Http\Requests\MyCustomRequest;

class PieceArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:pieces,id'],
        ];
    }
}
