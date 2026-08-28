<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProjectBulkStoreRequest extends MyCustomRequest
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
            'projects' => 'required|array',
            'projects.*.name' => 'required|string|max:120',
            'projects.*.description' => 'required|string|max:250',
            'projects.*.start_date' => 'required|date',
            'projects.*.end_date' => 'required|date',
            'projects.*.users' => 'required|array', // liste des users qui participent au projet
        ];
    }
}
