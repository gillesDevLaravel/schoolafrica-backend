<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class LocationAllRequest extends MyCustomRequest
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
            'idSection' => "integer|nullable",
            'status' => "string|in:in_progress,finished",
            'idUser' => "integer|nullable",
            'pageItems' => "integer|nullable|min:1",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
        ];
    }
}
