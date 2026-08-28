<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropositionQuestionUpdateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->getRole()->id !== 8;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'intitule' => "nullable|string",
            'is_correct' => "nullable|boolean",
            'idQuestionnaire' => "nullable|integer",
        ];
    }
}
