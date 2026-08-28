<?php

namespace App\Http\Requests\Moratorium;

use App\Enums\StatusEnum;
use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class MoratoriumGetRequest extends MyCustomRequest
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
            'pageItems' => 'integer|nullable',
            'nbreItems' => 'integer|nullable',
            'filter_value' => 'string|nullable',
            'idUser' => 'integer|exists:users,id',
            'idUserApprove' => 'integer|exists:users,id',
            'status' => 'in:'. implode(',', StatusEnum::values()),
            'start_date_from' => 'date|nullable',
            'start_date_to' => 'date|nullable',
            'end_date_from' => 'date|nullable',
            'end_date_to' => 'date|nullable',
        ];
    }
}
