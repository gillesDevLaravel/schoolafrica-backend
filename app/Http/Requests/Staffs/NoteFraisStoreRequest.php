<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class NoteFraisStoreRequest extends MyCustomRequest
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
            'note_frais' => 'required|array',
            'note_frais.*.idUser' => 'nullable|integer|exists:users,id',
            'note_frais.*.idUserApprove' => 'required|integer|exists:users,id',
            'note_frais.*.libelle' => 'required|string',
            'note_frais.*.amount' => 'required|integer',
            'note_frais.*.status' => 'nullable|string',
            'note_frais.*.description' => 'required|string',
            'note_frais.*.date' => 'required|date'
        ];
    }
}
