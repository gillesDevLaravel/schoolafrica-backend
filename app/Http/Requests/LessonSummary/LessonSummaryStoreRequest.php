<?php

namespace App\Http\Requests\LessonSummary;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class LessonSummaryStoreRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // uniquement l'enseignant doit pouvoir faire cette action
        return true;
//        return strtolower(auth()->user()->getRole()->name) === 'teacher';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lesson_summaries' => 'required|array',
            'lesson_summaries.*.idLesson' => 'nullable|integer',
            'lesson_summaries.*.description' => 'required|string',
//            'lesson_summaries.*.images' => 'nullable|array',
//            'lesson_summaries.*.images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'lesson_summaries.*.images' => 'nullable|array',
            'lesson_summaries.*.images.*' => 'required|string',
            'lesson_summaries.*.date' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
