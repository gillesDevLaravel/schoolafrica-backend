<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TaskGetAllRequest extends MyCustomRequest
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
            'idSchool' => 'integer|nullable',
            'idSection' => 'integer|nullable',
            'idUser' => 'integer|nullable',
            'pageItems' => 'integer|nullable',
            'nbreItems' => 'integer|nullable',
            'filter_value' => "nullable",
            'filter_status' => "nullable",
            'filter_priority' => "nullable",
        ];
    }
}
