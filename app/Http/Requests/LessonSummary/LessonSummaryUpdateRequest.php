<?php

namespace App\Http\Requests\LessonSummary;

use App\Http\Requests\MyCustomRequest;
use Illuminate\Support\Facades\Auth;

class LessonSummaryUpdateRequest extends MyCustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * il peut modifier si c'est lui l'auteur. (le fait qu'il soit enseignant a été vérifié à la création)
     *
     * @return bool
     */
    public function authorize()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer l'instance de Holiday en cours de mise à jour
        $lesson_summary = $this->route('lesson_summary');

        if (!$lesson_summary) {
            return false; // Bloquer si l'objet n'existe pas
        }

        return $lesson_summary->idTeacher === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idLesson' => 'nullable|integer|exists:lessons,id',
            'description' => 'nullable|string',
//            'images' => 'nullable|array',
//            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

            'images' => 'nullable|array',
            'images.*' => 'required|string',
            'date' => 'nullable|date|date_format:Y-m-d',
        ];
    }
}
