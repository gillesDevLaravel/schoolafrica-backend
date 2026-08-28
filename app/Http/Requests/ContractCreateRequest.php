<?php

namespace App\Http\Requests;


class ContractCreateRequest extends MyCustomRequest
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
            'idUserApprove' => 'required|integer|exists:users,id',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'duration' => 'nullable|integer|min:1', //en mois
            'working_hours' => 'required|string', //au format debut-fin (heure:minutes) ex : 8:00-17:00
            'position' => 'required|string', //poste occupé
            'gross_salary' => 'required|numeric|min:0', //salaire brute
            'status' => 'nullable|string|in:pending_approval,approved,terminated',
            'service_benefits' => 'nullable|string', // Avantages de service
            'bonus' => 'nullable|string', // Prime
            'file' => 'nullable|string', // Prime
            'number_days_off' => 'nullable|integer', // Prime
        ];
    }
}
