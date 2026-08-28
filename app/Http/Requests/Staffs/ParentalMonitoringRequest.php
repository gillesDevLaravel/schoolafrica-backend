<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ParentalMonitoringRequest extends MyCustomRequest
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
            'name' => ['required'],
            'type' => ['required'],
            'comment' => ['required'],
            'answer' => ['required'],
            'idParent' => ['required'],
            'idStudent' => ['required'],
            'idClasse' => ['required'],
            'idSchool' => ['required'],
            'idSection' => ['nullable']
        ];
    }
}
