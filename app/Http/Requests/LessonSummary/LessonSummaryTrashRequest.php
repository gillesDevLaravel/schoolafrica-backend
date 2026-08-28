<?php

namespace App\Http\Requests\LessonSummary;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Support\Facades\Auth;

class LessonSummaryTrashRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Je peux effectuer cette action si j'ai l'un de ces rôles

        return in_array(Auth::user()->getRole()->id, [1, 2, 3, 5]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:lesson_summaries,id',
        ];
    }
}
