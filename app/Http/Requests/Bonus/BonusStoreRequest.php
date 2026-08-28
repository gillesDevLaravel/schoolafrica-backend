<?php

namespace App\Http\Requests\Bonus;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Validation\Rule;

class BonusStoreRequest extends MyCustomRequest
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
            'bonuses' => 'required|array',
            'bonuses.*.idUser' => 'required|integer|exists:users,id',
            'bonuses.*.idUserApprove' => 'required|integer|exists:users,id',
            'bonuses.*.bonus_type' => ['required', Rule::in(['student', 'staff'])],
            'bonuses.*.amount' => 'required|numeric|min:0',
            'bonuses.*.reason' => 'required|string|max:255',
            'bonuses.*.is_used' => 'nullable|boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(isset($this->bonuses)){
                foreach ($this->bonuses as $index => $bonus) {
                    if (isset($bonus['idUser'], $bonus['idUserApprove']) && $bonus['idUser'] === $bonus['idUserApprove']) {
                        $validator->errors()->add("bonuses.$index.idUserApprove", "Le responsable bonuses.$index.idUserApprove doit être différent de l'utilisateur initial.");
                    }
                }
            }
        });
    }
}
