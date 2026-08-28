<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends MyCustomRequest
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
            'tasks' => 'required|array',
            'tasks.*.name' => ['required'],
            'tasks.*.due_date' => ['required'],
            'tasks.*.priority' => ['required'],
            'tasks.*.status' => ['required'],
            'tasks.*.duree_mise' => ['nullable', 'integer'],
            'tasks.*.estimation' => ['nullable', 'integer'],
            'tasks.*.observation' => ['nullable', 'string'],
            'tasks.*.idProject' => ['nullable', 'integer'],
            'tasks.*.idUser' => 'integer|required',
            'tasks.*.idSchool' => 'integer|required',
            'tasks.*.idSection' => 'integer|nullable'
        ];
    }
}
