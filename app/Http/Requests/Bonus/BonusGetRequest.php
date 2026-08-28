<?php

namespace App\Http\Requests\Bonus;

use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Validation\Rule;

class BonusGetRequest extends MyCustomRequest
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
            'bonus_type' => ['nullable', Rule::in(['student', 'staff'])],
            'status' => ['nullable', Rule::in(StatusEnum::values())],
            'is_used' => 'nullable|boolean',
            'trashed' => 'nullable|boolean',
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
        ];
    }
}
