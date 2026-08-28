<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class NoteFraisUpdateRequest extends MyCustomRequest
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
            'idUser' => 'nullable|integer|exists:users,id',
            'idUserApprove' => 'nullable|integer|exists:users,id',
            'libelle' => 'nullable|string',
            'amount' => 'nullable|integer',
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'date' => 'nullable|date'
        ];
    }
}
