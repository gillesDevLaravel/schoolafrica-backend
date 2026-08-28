<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends MyCustomRequest
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
            'name' => ['required', 'max:255'],
            'description' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['required'],
            'duration' => ['required'],
            'status' => ['required'],
            'idLesson' => ['required'],
            'idSchool' => ['required'],
            'idSection' => ['nullable'],
        ];
    }
}
