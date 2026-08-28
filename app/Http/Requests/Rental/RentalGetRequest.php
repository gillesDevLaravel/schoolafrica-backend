<?php

namespace App\Http\Requests\Rental;

use App\Http\Requests\MyCustomRequest;

class RentalGetRequest extends MyCustomRequest
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
            'article_id'    => 'nullable|integer|exists:articles,id',
            'user_id'       => 'nullable|integer|exists:users,id',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'filter_value'  => 'nullable|string|max:255',
            'nbreItems'     => 'nullable|integer|min:1|max:1000000', // nombre d’éléments par page
            'pageItems'     => 'nullable|integer|min:1', // numéro de page
        ];
    }
}
