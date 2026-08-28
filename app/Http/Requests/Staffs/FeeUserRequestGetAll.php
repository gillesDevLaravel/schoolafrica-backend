<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class FeeUserRequestGetAll extends MyCustomRequest
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
            'idSchool' => 'integer|nullable',
            'idSection' => 'integer|nullable',
            'idFee' => 'integer|nullable',
            'idStudent' => 'integer|nullable',
            'idClasse' => 'integer|nullable',
            'date' => ['nullable'],
            'date_start' => ['nullable'],
            'date_end' => ['nullable'],
            'payment_mode' => ['nullable'],
            'pageItems' => ['integer', 'nullable'],
            'nbreItems' => ['integer', 'nullable'],
            'filter_value' => ['nullable'],
            'telephone' => ['nullable'],
            'reference' => ['nullable'],
            'operator' => ['nullable'],
            'group_by' => 'nullable|string|in:day,week,month',
        ];
    }
}
