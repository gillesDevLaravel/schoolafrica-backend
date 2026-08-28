<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ReglementInterieurStoreRequest extends MyCustomRequest
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
            'reglements_interieurs' => 'required|array',
            'reglements_interieurs.*.title' => 'required|string',
            'reglements_interieurs.*.description' => 'required|string',
            'reglements_interieurs.*.type' => 'nullable|string',
            'reglements_interieurs.*.image' => 'nullable|string',
            'reglements_interieurs.*.idSchool' => 'required|integer',
            'reglements_interieurs.*.idSection' => 'nullable|integer',
        ];
    }
}
