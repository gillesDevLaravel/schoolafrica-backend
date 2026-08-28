<?php

namespace App\Http\Requests\DailyReport;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class DailyReportCreateRequest extends MyCustomRequest
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
            'name' => 'nullable|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'comments' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
