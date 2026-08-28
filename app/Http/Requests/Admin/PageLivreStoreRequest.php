<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class PageLivreStoreRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idBook' => 'required|integer|exists:books,id',
            'pages' => 'required|array',
            'pages.*.titre' => 'required|string|max:100',
            'pages.*.sous_titre' => 'nullable|string|max:100',
            'pages.*.description' => 'required|string',
        ];
    }
}
