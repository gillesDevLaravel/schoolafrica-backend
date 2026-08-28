<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class MatterGetAllRequest extends MyCustomRequest
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
            'idSchool' => 'required|integer',
            'idSection' => 'nullable|integer',
            'idLevel' => 'nullable|integer',
            'idOptionLevel' => 'nullable|integer',
            'assessment' => 'nullable',
            'pageItems' => 'nullable|integer',
            'nbreItems' => 'nullable|integer',
        ];
    }
}
