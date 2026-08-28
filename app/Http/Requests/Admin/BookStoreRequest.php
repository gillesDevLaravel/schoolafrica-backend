<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends MyCustomRequest
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
            'name' => "required|string",
            'photo' => "nullable",
            'status' => "nullable|in:available,unavailable",
            'auteur' => "string|nullable",
            'editeur' => "string|nullable",
            'date_publication' => "date|nullable",
            'idSchool' => "integer|nullable",
            'idSection' => "integer|nullable",
            'idLevel' => "integer|nullable",
        ];
    }
}
