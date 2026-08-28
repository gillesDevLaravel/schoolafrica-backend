<?php

namespace App\Http\Requests\Suggestion;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SuggestionUpdateRequest extends MyCustomRequest
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
            'description' => 'nullable|string',
            'user_id' => 'nullable|integer|exists:users,id',
            'isAnonymous' => 'nullable|boolean',
            'answer' => 'nullable|string',
        ];
    }
}
