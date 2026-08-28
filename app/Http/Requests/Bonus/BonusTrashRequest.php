<?php

namespace App\Http\Requests\Bonus;

use App\Http\Requests\MyCustomRequest;

class BonusTrashRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: Accessible uniquement au Staff et fondateur
        $auth_role = auth()->user()->getRole();

        return (in_array($auth_role->id, [1,2]) || $auth_role->type === "Staffs");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idBonuses' => 'required|array',
            'idBonuses.*' => 'required|integer|exists:bonuses,id',
        ];
    }
}
