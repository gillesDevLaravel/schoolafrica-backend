<?php

namespace App\Http\Requests\TypeInvoice;

use App\Http\Requests\MyCustomRequest;

class TypeInvoiceArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:type_invoices,id'],
        ];
    }
}
