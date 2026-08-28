<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractGetRequest extends MyCustomRequest
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
            'pageItems' => 'nullable|integer',
            'nbreItems' => 'nullable|integer',
            'filter_value' => 'nullable|string',
            'position' => 'nullable|string', //poste occupé
            'status' => 'nullable|string',  // Statut du contrat (ex : "Active", "Terminated") et null si pas encore signé ou annulé
            'trashed' => 'nullable|boolean'
        ];
    }
}
