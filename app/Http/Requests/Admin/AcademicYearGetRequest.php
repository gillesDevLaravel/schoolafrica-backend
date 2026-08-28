<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class AcademicYearGetRequest extends MyCustomRequest
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
            'pageItems' => 'nullable|integer|min:1',
            'nbreItems' => 'nullable|integer|min:1|max:10000',
            'filter_value' => 'nullable|string|max:255',
            "startDate" => "nullable|date",
            "endDate" => "nullable|date|after:dateDepart",
            'trashed' => 'nullable|boolean',
        ];
    }
}
