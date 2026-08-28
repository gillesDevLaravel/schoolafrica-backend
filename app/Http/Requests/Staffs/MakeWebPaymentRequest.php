<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class MakeWebPaymentRequest extends MyCustomRequest
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
            'idSchool' => "required|integer",
            'idSection' => "required|integer",
            'idFee' => "integer",
            'idLevel' => "integer",
            'idStudent' => "required|integer",
            'amount' => "required",
            'payment_mode' => "required",
            'idPension' => "integer",
        ];
    }
}
