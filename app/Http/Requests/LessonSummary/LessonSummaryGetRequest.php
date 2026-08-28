<?php

namespace App\Http\Requests\LessonSummary;

use App\Http\Requests\MyCustomRequest;

class LessonSummaryGetRequest extends MyCustomRequest
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
            'idLesson' => 'nullable|integer|exists:lessons,id',
            'idChapter' => 'nullable|integer|exists:chapters,id',
            'idModule' => 'nullable|integer|exists:modules,id',
            'idClasse' => 'nullable|integer|exists:classes,id',
            'idTeacher' => 'nullable|integer|exists:users,id',
            'trashed' => 'nullable|boolean',
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
            'date' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
