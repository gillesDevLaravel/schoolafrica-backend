<?php

namespace App\Http\Requests\Staffs;


use App\Http\Requests\MyCustomRequest;

class PermissionUserRequest extends MyCustomRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retourne les règles de validation.
     */
    public function rules(): array
    {
        return [
            "raison" => "required|string|max:255",
            "dateDepart" => "required|date",
            "dateRetour" => "nullable|date|after_or_equal:dateDepart",
            "duration" => "nullable|integer|min:1",
            "idUser" => "nullable|integer|exists:users,id",
            "idUserApprove" => "required|integer|exists:users,id",
            "status" => "nullable|string|in:pending_approval,in_progress,approved,rejected",
            "comments" => "nullable|string",
        ];
    }
}
