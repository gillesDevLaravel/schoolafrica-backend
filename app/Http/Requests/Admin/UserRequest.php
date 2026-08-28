<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends MyCustomRequest
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
            'name'=>['required'],
            'username' =>['required', 'max:50'],
            'password' =>['required', 'min:6'],
            'phone' =>['sometimes','digits_between:9,20'],
            'adresse'=>['required'],
            'gender'=>['required'],
            'old_classe'=>['nullable', 'string'],
        ];
    }
}
