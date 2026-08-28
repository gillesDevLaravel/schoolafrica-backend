<?php

namespace App\Http\Requests\Staffs;


use App\Http\Requests\MyCustomRequest;

class PermissionUserUpdateRequest extends MyCustomRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        //Il me faut le role de l'utilisateur qui pourra accorder des permissions
        return true;
    }

    /**
     * Retourne les règles de validation.
     */
    public function rules(): array
    {
        return [
            "raison" => "nullable|string|max:255",
            "dateDepart" => "nullable|date",
            "dateRetour" => "nullable|date",
            "duration" => "nullable|integer|min:1",
            "status" => "nullable|string",
            "comments" => "nullable|string",
        ];
    }
}
