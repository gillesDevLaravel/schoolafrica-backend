<?php

namespace App\Http\Requests;

use App\Models\PropositionQuestion;
use Illuminate\Foundation\Http\FormRequest;

class PropositionQuestionStoreRequest extends MyCustomRequest
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
            "idQuestion" => "required|integer|exists:questionnaires,id",
            "propositions" => "required|array",
            "propositions.*.intitule" => "required|string|max:100",
            "propositions.*.is_correct" => "required|boolean",
        ];
    }
}
