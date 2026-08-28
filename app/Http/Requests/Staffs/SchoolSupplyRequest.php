<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SchoolSupplyRequest extends MyCustomRequest
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
            'supply' => ['required'],
            'idLevel' => ['required'],
            'idSchool' => ['required'],
            'idSection' => ['required'],
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'idsClasses' => 'nullable|array|min:1',
            'idsClasses.*' => 'integer|exists:classes,id'
        ];
    }
}
