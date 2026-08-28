<?php

namespace App\Http\Requests\ExplanationRequest;

use Illuminate\Foundation\Http\FormRequest;

class ExplanationRequestUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
            'date' => 'nullable|string',
            'idUser' => 'sometimes|required|integer|exists:users,id',
            'idResponsable' => 'sometimes|required|integer|exists:users,id',
            'image' => 'nullable|string|max:255',
            'comments' => 'nullable|string|max:2000',
        ];
    }
}
