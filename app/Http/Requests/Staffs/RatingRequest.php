<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends MyCustomRequest
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
            'value' => ['required'],
            'idMatter' => ['required'],
            'idStudent' => ['required'],
            'idAssessment' => ['required'],
            'idSchool' => ['required'],
            'idSection' => ['required']
        ];
    }
}
