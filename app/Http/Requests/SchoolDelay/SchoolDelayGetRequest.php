<?php

namespace App\Http\Requests\SchoolDelay;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SchoolDelayGetRequest extends MyCustomRequest
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

            'filter_value' => 'nullable|string|max:255',
            'nbreItems'    => 'nullable|integer|min:1|max:1000000',
            'pageItems'    => 'nullable|integer|min:1',
            'idClasse'   => 'nullable|integer|exists:classes,id',
            'idStudent'   => 'nullable|integer|exists:users,id',
            'idCourse'    => 'nullable|integer|exists:courses,id',
            'date'        => 'nullable|date',
            'date_start'  => 'nullable|date',
            'date_end'    => 'nullable|date',
            'hour'        => 'nullable|date_format:H:i',
            'type'        => 'nullable|string|max:255',
        ];
    }

}
