<?php

namespace App\Http\Requests\MeetingReport;

use Illuminate\Foundation\Http\FormRequest;

class MeetingReportUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'nullable|string|max:255',
            'type'        => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'date' => 'nullable|date_format:Y-m-d',
            'participants' => 'nullable|string|max:1000',

        ];
    }
}
