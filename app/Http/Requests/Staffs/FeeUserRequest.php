<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class FeeUserRequest extends MyCustomRequest
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
            'advancePayment' => ['required'],
            'idTransaction' => 'integer|nullable',
            'idStudent' => 'integer|required',
            'payment_mode' => ['required'],
//            'idLevel' => 'integer|required',
//            'idSchool' => 'integer|nullable',
//            'idSection' => 'integer|nullable',
            'idFee' => 'integer|required',
            'scanReceipt' => 'string|nullable',
            'receiptNumber' => 'string|nullable',
            'operator' => 'string|nullable',
            'paymentDate' => 'string|nullable',
            'telephone' => 'string|nullable',
//            'photo' => "nullable|image|mimes:jpeg,png,jpg,pdf|max:2048",
        ];
    }
}
