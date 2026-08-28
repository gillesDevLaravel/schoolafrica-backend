<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Support\Facades\Auth;

class AcademicYearUpdateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array(Auth::user()->getRole()->id, [1, 2, 3]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            "previousAcademicYearId" => "nullable|integer|exists:academic_years,id",
        ];
    }
}
