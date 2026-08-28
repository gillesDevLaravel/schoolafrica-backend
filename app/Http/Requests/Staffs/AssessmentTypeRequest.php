<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssessmentTypeRequest extends MyCustomRequest
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
            'assessmenttypes' => 'required|array',
            'assessmenttypes.*.name' => ['required', 'string'],
            'assessmenttypes.*.idTrimestre' => ['required', 'integer'],
            'assessmenttypes.*.takenIntoAccount' => 'nullable|boolean',
            'assessmenttypes.*.numbering' => 'nullable|integer',
            'assessmenttypes.*.pourcentage' => 'nullable|numeric|min:0|max:100',
            'assessmenttypes.*.notes_completed' => 'nullable|boolean',
            'assessmenttypes.*.start_date' => 'nullable|date',
            'assessmenttypes.*.end_date' => 'nullable|date|after:assessmenttypes.*.start_date',
//            'assessmenttypes.*.idSchool' => ['nullable', 'integer'],
//            'assessmenttypes.*.idSection' => ['nullable', 'integer']
        ];
    }
}
