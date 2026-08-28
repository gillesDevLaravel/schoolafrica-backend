<?php

namespace App\Http\Requests\MeetingReport;

use App\Http\Requests\MyCustomRequest;

class MeetingReportGetRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'   => 'nullable|string',
            'type'   => 'nullable|string',
            'filter_value' => 'nullable|string',
            'date' => 'nullable|date_format:Y-m-d',
            'date_start' => 'nullable|date_format:Y-m-d',
            'date_end' => 'nullable|date_format:Y-m-d',
            'pageItems' => 'nullable|integer',
            'nbreItems' => 'nullable|integer',
        ];
    }
}
