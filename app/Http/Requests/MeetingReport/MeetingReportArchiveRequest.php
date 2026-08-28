<?php

namespace App\Http\Requests\MeetingReport;

use App\Http\Requests\MyCustomRequest;

class MeetingReportArchiveRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:meeting_reports,id'],
        ];
    }
}
