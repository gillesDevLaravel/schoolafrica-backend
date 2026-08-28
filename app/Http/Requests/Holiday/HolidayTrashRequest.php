<?php

namespace App\Http\Requests\Holiday;

use App\Http\Requests\MyCustomRequest;

class  HolidayTrashRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id_role = auth()->user()->getRole()->id;

        return in_array($user_id_role, [1,2]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idHolidays' => "required|array",
            'idHolidays.*' => "required|integer|exists:holidays,id"
        ];
    }
}
