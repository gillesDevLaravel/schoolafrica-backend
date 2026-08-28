<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TypeInvoiceStoreRequest extends MyCustomRequest
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
               'name' => 'sometimes|required|string',
               'code' => 'nullable|string',
               'type' => 'nullable|string|max:50',
               'category' => 'sometimes|required|string',
               'idSchool' => 'nullable|integer'
         ];
    }
}
