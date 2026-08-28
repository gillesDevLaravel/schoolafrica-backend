<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class CertificatTransfertRequest extends MyCustomRequest
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
            'idStudent' => "integer|required",
            'country' => "string|required",
            'route' => "string|required",
            'academic_year' => "string|required",
            'reason' => "string|required",
            'date' => "date|nullable",
        ];
    }
}
