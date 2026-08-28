<?php

namespace App\Http\Requests\LessonSummary;

use App\Http\Requests\MyCustomRequest;

class LessonSummaryDownloadRequest extends MyCustomRequest
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
            'idLesson' => 'required|exists:lessons,id',
            'idLessonSummary' => 'nullable|exists:lesson_summaries,id',
        ];
    }
}
