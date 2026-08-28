<?php

namespace App\Http\Requests\Staffs;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkDoneDownloadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: Qui peut effectuer cette action ?
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
            'idStudent' => "nullable|integer|exists:users,id",
            'idHomework' => "nullable|integer|exists:homework,id",
            'idHomeworkDone' => "nullable|integer|exists:homework_dones,id",
        ];
    }
}
