<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends MyCustomRequest
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
            'name' => ['required'],
            'description' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['nullable'],
            'type' => ['required', 'in:interne,externe'],
            'idSchool' => ['integer', 'required'],
            'idSection' => ['integer', 'nullable'],
            'classes' => ['nullable'], // array
            'levels' => ['nullable'], // array
            'parentalContribution' => 'nullable',
            'budget' => 'nullable',
        ];
    }
}
