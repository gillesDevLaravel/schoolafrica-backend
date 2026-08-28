<?php

namespace App\Http\Requests\SalaryAdvance;

use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SalaryAdvanceUpdateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer l'instance de Holiday en cours de mise à jour
        $salary_advance = $this->route('salary_advance');

        if (!$salary_advance) {
            return false; // Bloquer si l'objet n'existe pas
        }

        // Vérifier si l'utilisateur est le créateur ou la personne approuvant la demande
        return in_array($user->id, [$salary_advance->idUser, $salary_advance->idUserApprove]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idUserApprove' => "nullable",
            'amount' => "nullable",
            'status' => ['nullable', Rule::in(StatusEnum::values())],
            'reason' => "nullable|string",
            'comments' => "nullable|string",
        ];
    }
}
