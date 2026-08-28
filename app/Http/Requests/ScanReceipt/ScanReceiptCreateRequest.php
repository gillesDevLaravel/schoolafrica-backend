<?php

namespace App\Http\Requests\ScanReceipt;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ScanReceiptCreateRequest extends MyCustomRequest
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
            'idAcademicYear' => 'nullable|integer|exists:academic_years,id',
            'idSchool' => 'required|integer|exists:schools,id',
            'idStudent' => 'required|integer|exists:users,id',
            'image_scan' => 'required|string',
        ];
    }
}
