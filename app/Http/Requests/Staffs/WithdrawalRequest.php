<?php

namespace App\Http\Requests\Staffs;

use App\Enums\WithdrawalTypeEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends MyCustomRequest
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
            'idSchool' => ['required'],
            'idSection' => ['nullable'],
            'montant_retrait_brut' => ['required'],
            'montant_retrait_net' => ['required'],
            'frais_bancaire' => ['nullable'],
            'status' => ['nullable'],
            'mode_retrait' => ['required'],
            'rib' => ['nullable'],
            'idUser' => ['required'],
            'numero_retrait' => ['nullable'],
            'date' => ['nullable'],
            'created_by' => ['nullable'],
            'updated_by' => ['nullable'],
            'type' => 'required|string|in:' . implode(',', WithdrawalTypeEnum::values()),
        ];
    }
}
