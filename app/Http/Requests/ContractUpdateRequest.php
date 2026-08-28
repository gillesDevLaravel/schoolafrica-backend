<?php

namespace App\Http\Requests;

class ContractUpdateRequest extends MyCustomRequest
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
            'type' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:1', //en mois
            'working_hours' => 'nullable|string', //au format debut-fin (heures:minutes) ex : 8:00-17:00
            'position' => 'nullable|string', //poste occupé
            'gross_salary' => 'nullable|numeric|min:0', //salaire brute
            'status' => 'nullable|string|in:pending_approval,approved,terminated',
            'service_benefits' => 'nullable|string', // Avantages de service
            'bonus' => 'nullable|string', // Prime
            'number_days_off' => 'nullable|integer', // Prime
        ];
    }
}
