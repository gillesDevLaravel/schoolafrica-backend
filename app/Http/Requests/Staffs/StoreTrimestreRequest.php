<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrimestreRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'trimestres' => 'required|array',
            'trimestres.*.name' => 'required|string',
            'trimestres.*.numbering' => 'nullable|integer',
            'trimestres.*.idSchool' => 'required|integer',
            'trimestres.*.idSection' => 'required|integer',
            'trimestres.*.idSemestre' => 'nullable|integer',
            'trimestres.*.takenIntoAccount' => 'nullable|boolean',
        ];
    }
}
