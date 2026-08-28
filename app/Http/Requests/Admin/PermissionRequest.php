<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends MyCustomRequest
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
            'permissions' => 'required|array|min:1',
            'permissions.*.name' => 'required|string|max:40',
            'permissions.*.ressource' => 'required|string|max:40',
            'permissions.*.description' => 'required|string',
        ];
    }
}
