<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends MyCustomRequest
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
            'idUser' => 'required|integer',
            'idBook' => 'required|integer',
            'date_sortie' => 'required|date',
            'date_retour' => 'nullable|date',
            'reason' => 'required|string|max:120',
            'observation' => 'string|max:120',
            'status' => 'in:in_progress,finished'
        ];
    }
}
