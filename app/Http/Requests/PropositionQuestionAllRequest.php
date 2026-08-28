<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropositionQuestionAllRequest extends MyCustomRequest
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
            'pageItems' => "integer|nullable",
            'nbreItems' => "integer|nullable",
            'filter_value' => "string|nullable",
            'idQuestion' => 'integer|required|exists:questionnaires,id',
        ];
    }
}
