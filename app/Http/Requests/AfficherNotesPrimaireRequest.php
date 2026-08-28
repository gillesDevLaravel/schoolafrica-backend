<?php

namespace App\Http\Requests;

class AfficherNotesPrimaireRequest extends MyCustomRequest
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
            'idUser' => 'required|integer|exists:users,id',
            'idOptionLevel' => 'nullable|integer|exists:option_level,id',
        ];
    }
}
