<?php

namespace App\Http\Requests\Holiday;

use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HolidayUpdateRequest extends MyCustomRequest
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
        $holiday = $this->route('holiday');

        if (!$holiday) {
            return false; // Bloquer si l'objet n'existe pas
        }

        // Vérifier si l'utilisateur est le créateur ou la personne approuvant la demande
        return in_array($user->id, [$holiday->idUser, $holiday->idUserApprove]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'nullable|string',
            'start_date' => 'nullable|date|after_or_equal:today|date_format:Y-m-d',
            'end_date' => 'nullable|date|after_or_equal:start_date|date_format:Y-m-d',
            'days_taken' => 'nullable|integer',
            'reason' => 'nullable|string|max:255',
            'status' => ['nullable', Rule::in(StatusEnum::values())],
        ];
    }
}
