<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class PensionGetAllRequest extends MyCustomRequest
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
            'idSchool' => "integer|required",
            'idSection' => "integer|nullable",
            'idTypeOfRecipe' => "integer|nullable|exists:type_of_recipes,id",
            'idPension' => "integer|nullable",
            'idTranche' => "integer|nullable",
            'idStudent' => "integer|nullable",
            'idClasse' => "integer|nullable",
            'date' => "nullable",
            'date_start' => "nullable",
            'date_end' => "nullable",
            'payment_mode' => "nullable",
        ];
    }
}
