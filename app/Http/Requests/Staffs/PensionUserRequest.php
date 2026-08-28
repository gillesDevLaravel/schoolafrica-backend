<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class PensionUserRequest extends MyCustomRequest
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
//            'idSchool' => 'integer|nullable',
//            'idSection' => 'integer|nullable',
            'idTransaction' => 'integer|nullable',
            'idStudent' => 'integer|required',
            'idPension' => 'integer|nullable', // useless (18/09/2024) vu qu'on va prendre idLevel du Student et remonter jusqu'à la pension
            'scanReceipt' => 'string|nullable', // useless (18/09/2024) vu qu'on va prendre idLevel du Student et remonter jusqu'à la pension
            'advancePayment' => 'integer|required|min:0',
            'payment_mode' => ['required'],
            'receiptNumber' => 'string|nullable',
            'operator' => 'string|nullable',
            'paymentDate' => 'string|nullable',
            'telephone' => 'string|nullable',
//            'photo' => "nullable|image|mimes:jpeg,png,jpg,pdf|max:2048",
//            'photo' => [
//                'mimes:jpeg,png,jpg,pdf',
//                'max:2048', // 4Mo en kilo-octets
//            ],
            'idBourse' => [
                "nullable",
                "integer",
                "exists:bourses,id",
//                function ($attribute, $value, $fail) {
//                    $user = User::find(request()->idStudent);
//                    if ($value && $value != $user->idBourse) {
//                        $fail("L'`idBourse` envoyé ne correspond pas à la bourse de cet utilisateur.");
//                    }
//                }
            ],
        ];
    }
}
