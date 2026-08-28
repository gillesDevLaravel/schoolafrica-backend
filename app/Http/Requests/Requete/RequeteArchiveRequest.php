<?php

namespace App\Http\Requests\Requete;

use Illuminate\Foundation\Http\FormRequest;

class RequeteArchiveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:requetes,id',
        ];
    }
}
