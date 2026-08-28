<?php

namespace App\Http\Requests\SchoolDelay;

use Illuminate\Foundation\Http\FormRequest;

class SchoolDelayUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'hour'        => 'sometimes|required|date_format:H:i',
            'date'        => 'sometimes|required|date',
            'description' => 'nullable|string|max:500',
            'type'        => 'nullable|string|max:255',
            'idStudent'   => 'sometimes|required|exists:users,id',
            'idCourse'    => 'nullable|exists:courses,id',
        ];
    }
}
