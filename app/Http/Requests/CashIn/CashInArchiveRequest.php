<?php

namespace App\Http\Requests\CashIn;

use App\Http\Requests\MyCustomRequest;

class CashInArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:cash_ins,id'],
        ];
    }
}
