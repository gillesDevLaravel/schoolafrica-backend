<?php

namespace App\Http\Requests\ScanReceipt;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ScanReceiptUpdateRequest extends MyCustomRequest
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
            'idSchool' => 'nullable|integer|exists:schools,id',
            'idStudent' => 'nullable|integer|exists:users,id',
            'image_scan' => 'nullable|string',
        ];
    }
}
