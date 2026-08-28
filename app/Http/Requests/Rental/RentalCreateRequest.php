<?php

namespace App\Http\Requests\Rental;

use App\Http\Requests\MyCustomRequest;

class RentalCreateRequest extends MyCustomRequest
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
            'user_id'         => 'nullable|integer|exists:users,id',
            'article_id'      => 'required|integer|exists:articles,id',
            'description'      => 'nullable|string',
            'reason'      => 'nullable|string',

            'exit_quantity'   => 'required|integer|min:1',
            'exit_date'       => 'nullable|date',
            'exit_condition'  => 'nullable|string|max:255',
            'exit_image'      => 'nullable|string',

            'entry_quantity'  => 'nullable|integer|min:0',
            'entry_date'      => 'nullable|date|after_or_equal:exit_date',
            'entry_condition' => 'nullable|string|max:255',
            'entry_image'     => 'nullable|string',
        ];
    }
}
