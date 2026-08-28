<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class BookGetRequest extends MyCustomRequest
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
            'idSchool' => "integer|nullable",
            'isSection' => "integer|nullable",
            'idLevel' => "integer|nullable",
            'status' => "string|in:available,unavailable",
            'nbreItems' => "integer|nullable",
            'pageItems' => "integer|nullable|min:1",
            'filter_value' => "string|nullable",
        ];
    }
}
