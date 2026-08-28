<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class SchoolFolderRequest extends MyCustomRequest
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
            'idSchool' => ['required'],
            'idSection' => ['required'],
            'idStudent' => ['required'],
            'medicalCertificate' => ['required'],
            'lastBulletin' => ['required'],
            'lastDiploma' => ['required'],
            'birthCertificate' => ['required']
        ];
    }
}
