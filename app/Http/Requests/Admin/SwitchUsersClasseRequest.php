<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SwitchUsersClasseRequest extends MyCustomRequest
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
            'idUsers' => 'required|array',
            'idUsers.*' => 'required|integer|exists:users,id',
            'idClasse' => 'required|integer|exists:classes,id',
//            'idClasse' => 'required|integer',
        ];
    }
}
