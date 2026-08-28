<?php

namespace App\Http\Requests\MeetingReport;

use App\Http\Requests\MyCustomRequest;

class MeetingReportCreateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'meeting_reports' => 'required|array',
            'meeting_reports.*.name' => 'required|string|max:255',
            'meeting_reports.*.type' => 'required|string|max:50',
            'meeting_reports.*.description' => 'nullable|string|max:500',
            'meeting_reports.*.date' => 'nullable|date_format:Y-m-d',
            'meeting_reports.*.participants' => 'nullable|string|max:1000',
        ];
    }
}
