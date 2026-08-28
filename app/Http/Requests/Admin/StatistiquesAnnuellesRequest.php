<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyCustomRequest;

class StatistiquesAnnuellesRequest extends MyCustomRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idSchool' => 'nullable|integer|exists:schools,id|required_without_all:idLevel,idClasse',
            'idLevel' => 'nullable|integer|exists:levels,id|required_without_all:idSchool,idClasse',
            'idClasse' => 'nullable|integer|exists:classes,id|required_without_all:idSchool,idLevel',
        ];
    }
}
