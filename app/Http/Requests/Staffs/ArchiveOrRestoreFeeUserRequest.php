<?php

namespace App\Http\Requests\Staffs;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveOrRestoreFeeUserRequest extends FormRequest
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
            'action' => "required|in:archive,restore",
            'idFeeUser' => "required|integer",
            'reason' => "required_if:action,archive|string",
        ];
    }
}
