<?php

namespace App\Http\Requests\Document;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class BulletinPaieRequest extends MyCustomRequest
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
            'idInvoice' => 'required|integer|exists:invoices,id',
            'route' => 'string|nullable'
        ];
    }

}
