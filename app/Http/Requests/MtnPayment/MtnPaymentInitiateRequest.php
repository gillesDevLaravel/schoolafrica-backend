<?php

namespace App\Http\Requests\MtnPayment;

use App\Http\Requests\MyCustomRequest;

class MtnPaymentInitiateRequest extends MyCustomRequest
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
            'idStudent' => 'required|integer|exists:users,id',
            'idSchool' => 'required|integer|exists:schools,id',
            'idSection' => 'required|integer|exists:section,id',
            'amount' => 'required|integer|min:100', // Minimum 100 FCFA
            'payment_mode' => 'required|string',
            'phonePayeur' => 'required|string|regex:/^6[0-9]{8}$/', // Numéro MTN Cameroun
            'reference' => 'required|string|max:255',

            // Champs conditionnels (au moins un des trois requis)
            'idPension' => 'nullable|required_without_all:idFee,transport_user_id|integer|exists:pensions,id',
            'idFee' => 'nullable|required_without_all:idPension,transport_user_id|integer|exists:fees,id',
            'transport_user_id' => 'nullable|required_without_all:idPension,idFee|integer|exists:transport_users,id',


            'idLevel' => 'nullable|required_with:idFee|integer|exists:levels,id',

            // Champ optionnel pour la classe (si disponible)
            'idClasse' => 'nullable|integer|exists:classes,id'
        ];
    }
}
