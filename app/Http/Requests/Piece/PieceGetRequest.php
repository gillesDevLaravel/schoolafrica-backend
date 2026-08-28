<?php

namespace App\Http\Requests\Piece;

use App\Http\Requests\MyCustomRequest;

class PieceGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'   => 'nullable|string',
            'etage'  => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
}
