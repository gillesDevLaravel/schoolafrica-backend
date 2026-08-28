<?php

namespace App\Http\Requests\Staffs;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Foundation\Http\FormRequest;

class ExamStudentRequest extends MyCustomRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        // Retourne true si l'utilisateur est autorisé, sinon false.
        // Par défaut, retourne true pour autoriser toutes les requêtes.
        return true;
    }

    /**
     * Règles de validation des données de la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idAssessment' => 'required|integer|exists:assessments,id', // Vérifie que l'idAssessment existe dans la table assessments
            'idAssessmentType' => 'required|integer|exists:assessment_type,id', // Vérifie que l'idAssessmentType existe dans la table assessment_type
        ];
    }
}
