<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\MyCustomRequest;

class InvoiceArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:invoices,id'],
        ];
    }
}
