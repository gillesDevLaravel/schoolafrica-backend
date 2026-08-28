<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUserFindRequest extends MyCustomRequest
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
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer|min:1|max:10000',
            'filterValue' => 'nullable|string|max:255',
            "dateDepart" => "nullable|date",
            "dateRetour" => "nullable|date|after:dateDepart",
            "duration" => "nullable|integer|min:1",
            "status" => "nullable|string",
            "idUser" => "nullable|integer|exists:users,id",
            "idUserApprove" => "nullable|integer|exists:users,id",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date|after_or_equal:start_date",
            "trashed" => "nullable|string|in:withTrashed,onlyTrashed",
//            "duree" => "nullable|array",
//            "duree.jour" => "nullable|integer|min:0",
//            "duree.mois" => "nullable|integer|min:0",
//            "duree.annee" => "nullable|integer|min:0",
//            "duree.heure" => "nullable|integer|min:0|max:23",
//            "duree.minute" => "nullable|integer|min:0|max:59",
        ];
    }

}
