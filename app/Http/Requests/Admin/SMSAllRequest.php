<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SMSAllRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !in_array(auth()->user()->getRole()->id, [5,6,7,8]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'nullable|in:success,failed',
            'idSchool' => 'nullable|integer|exists:schools,id',
            'idSection' => 'nullable|integer|exists:section,id',
            'pageItems' => "integer|nullable|min:1",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
            'date' => "nullable|date|date_format:Y-m-d",
        ];
    }
}
