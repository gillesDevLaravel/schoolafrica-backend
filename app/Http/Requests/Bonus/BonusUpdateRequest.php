<?php

namespace App\Http\Requests\Bonus;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Validation\Rule;

class BonusUpdateRequest extends MyCustomRequest
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
            'idUser' => 'nullable|integer|exists:users,id',
            'idUserApprove' => 'nullable|integer|exists:users,id',
//            'idUserApprove' => 'nullable|integer|exists:users,id|prohibited_if:idUser,request.idUser',
            'bonus_type' => ['nullable', Rule::in(['student', 'staff'])],
            'amount' => 'nullable|numeric|min:0',
            'reason' => 'nullable|string|max:255',
            'is_used' => 'nullable|boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->idUser && $this->idUserApprove && $this->idUser === $this->idUserApprove) {
                $validator->errors()->add('idUserApprove', 'Le responsable (idUserApprove) approuvant doit être différent de l\'utilisateur initial (idUser).');
            }
        });
    }
}
