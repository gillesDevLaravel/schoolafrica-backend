<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class StudentsPensionSummaryRequest extends MyCustomRequest
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
            'idClasse' => ['nullable', 'integer', 'exists:classes,id'],
            'idStudent' => ['nullable', 'integer', 'exists:users,id'],
            'idSchool' => ['nullable', 'integer', 'exists:schools,id'],
            'idSection' => ['nullable', 'integer', 'exists:section,id'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (
                !$this->idClasse &&
                !$this->idStudent &&
                !$this->idSchool &&
                !$this->idSection
            ) {
                $validator->errors()->add('filter', 'Au moins un filtre doit être fourni (idClasse, idStudent, idSchool ou idSection)');
            }
        });
    }
}
