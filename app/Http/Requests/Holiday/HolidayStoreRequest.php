<?php

namespace App\Http\Requests\Holiday;

use App\Http\Requests\MyCustomRequest;

class HolidayStoreRequest extends MyCustomRequest
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
            'type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today|date_format:Y-m-d',
            'end_date' => 'required|date|after_or_equal:start_date|date_format:Y-m-d',
            'days_taken' => 'required|integer',
            'reason' => 'required|string|max:255',
            'idUserApprove' => 'required|integer|exists:users,id',
        ];
    }
}
