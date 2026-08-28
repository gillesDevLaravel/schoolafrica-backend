<?php

namespace App\Http\Requests\SupplyDemand;

use Illuminate\Foundation\Http\FormRequest;

class SupplyDemandArchiveRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        return true; // Autorisation activée
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'ids' => ['required', 'array'], // Les IDs des demandes d'approvisionnement doivent être un tableau
            'ids.*' => ['integer', 'exists:supply_demands,id'], // Chaque ID doit être un entier existant dans la table `supply_demands`
        ];
    }
}
