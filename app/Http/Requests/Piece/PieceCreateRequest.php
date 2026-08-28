<?php

namespace App\Http\Requests\Piece;

use App\Http\Requests\MyCustomRequest;

class PieceCreateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
          return [
        'pieces'           => 'required|array',
        'pieces.*.name'    => 'required|string|max:255',
        'pieces.*.etage'   => 'required|string|max:50',
        'pieces.*.description' => 'nullable|string|max:500',
        'pieces.*.status'  => 'required|string|max:50',
     ];
    }
}
