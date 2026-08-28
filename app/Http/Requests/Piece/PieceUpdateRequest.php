<?php

namespace App\Http\Requests\Piece;

use Illuminate\Foundation\Http\FormRequest;

class PieceUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'sometimes|required|string|max:255',
            'etage'       => 'sometimes|required|string|max:50',
            'description' => 'nullable|string|max:500',
            'status'      => 'sometimes|required|string|max:50',
        ];
    }
}
