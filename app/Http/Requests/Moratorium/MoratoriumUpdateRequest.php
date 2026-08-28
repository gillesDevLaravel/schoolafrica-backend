<?php

namespace App\Http\Requests\Moratorium;

use App\Enums\MoratoriumStatusEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class MoratoriumUpdateRequest extends MyCustomRequest
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
            'startDate' => 'nullable|date|before_or_equal:endDate',
            'endDate' => 'nullable|date|after_or_equal:startDate',
            'reason' => 'nullable|string|max:1000',
            'note_comptable' => 'nullable|string|max:1000',
            'note_fondatrice' => 'nullable|string|max:1000',
            'status' => 'nullable|in:' . implode(',', MoratoriumStatusEnum::values()),
            'idUserApprove' => 'nullable|integer|exists:users,id',
        ];
    }
}
