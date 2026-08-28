<?php

namespace App\Http\Requests\SalaryDeduction;

use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SalaryDeductionUpdateRequest extends MyCustomRequest
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
            'idUser' => 'nullable|integer|exists:users,id',
            'idUserApprove' => 'nullable|integer|exists:users,id',
            'amount' => 'nullable',
            'reason' => 'nullable|string',
            'date' => 'nullable|date|date_format:Y-m-d',
            'status' =>  'nullable|string|in:' . implode(',', StatusEnum::values()), //Nullable car valeur par défaut défini en bd
        ];
    }
}
