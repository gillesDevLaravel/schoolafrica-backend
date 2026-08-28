<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class PageLivreAllRequest extends MyCustomRequest
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
            'pageItems' => "integer|nullable|min:1",
            'nbreItems' => "integer|nullable",
            'idBook' => 'required', //|exists:books,id',
            'filter_value' => 'nullable|string',
            'titre' => 'nullable|string',
        ];
    }
}
