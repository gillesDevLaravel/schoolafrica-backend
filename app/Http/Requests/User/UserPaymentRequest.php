<?php

namespace App\Http\Requests\User;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserPaymentRequest extends MyCustomRequest
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
            'pageItems'  => ['nullable', 'integer', 'min:1'],   // numéro de page
            'nbreItems'  => ['nullable', 'integer', 'min:1'],   // items par page
            'idSchool' => ['nullable', 'integer'], // ou 'integer' selon ton modèle
            'idSection' => ['nullable', 'integer'],
            'idClasse' => ['nullable', 'integer'],
            'payment' => ['required', 'numeric', 'min:0'],
            'hasPaid'    => ['nullable', 'boolean'],
        ];
    }
}
