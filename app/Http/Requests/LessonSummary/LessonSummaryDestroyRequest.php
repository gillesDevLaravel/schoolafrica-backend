<?php

namespace App\Http\Requests\LessonSummary;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Support\Facades\Auth;

class LessonSummaryDestroyRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Accessible uniquement aux admins
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
            'ids' => 'required|array',
            'ids.*' => 'exists:lesson_summaries,id',
        ];
    }
}
