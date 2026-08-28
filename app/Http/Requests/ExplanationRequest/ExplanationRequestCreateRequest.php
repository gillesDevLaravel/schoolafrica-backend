<?php

namespace App\Http\Requests\ExplanationRequest;

use App\Http\Requests\MyCustomRequest;

class ExplanationRequestCreateRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'explanation_requests' => 'required|array',
            'explanation_requests.*.name' => 'required|string|max:255',
            'explanation_requests.*.description' => 'required|string|max:1000',
            'explanation_requests.*.date' => 'nullable|string',
            'explanation_requests.*.idUser' => 'required|integer|exists:users,id',
            'explanation_requests.*.idResponsable' => 'required|integer|exists:users,id',
            'explanation_requests.*.image' => 'nullable|string|max:255',
            'explanation_requests.*.comments' => 'nullable|string|max:2000',
        ];
    }
}
