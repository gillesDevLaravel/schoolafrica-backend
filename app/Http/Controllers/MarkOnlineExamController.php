<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\MarkOnlineExamGetStudentResponsesRequest;
use App\Http\Requests\Admin\MarkOnlineExamStoreStudentNotesRequest;
use App\Http\Resources\Admin\ResponseUserMarkExamResource;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\Questionnaire;
use App\Models\Rating;
use App\Models\ResponseUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarkOnlineExamController extends BaseController
{
    /**
     * Récupérer toutes les réponses d'un enfant à un examen et pour une séquence donnés
     *
     * @param MarkOnlineExamGetStudentResponsesRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getStudentResponses(MarkOnlineExamGetStudentResponsesRequest $request)
    {
        // On récupérer toutes les questions de cet examen
        // Pour chaque question, on associe la proposition de réponse de l'élève

        try {
            // je retrouve d'abord les questions concernées
            $questionnaires = Questionnaire::where([
                'idAssessment' => $request->idAssessment,
                'idAssessmentType' => $request->idAssessmentType,
            ])->get();

            foreach ($questionnaires as $questionnaire) {
                $tmp_user_resp = ResponseUser::where([
                    'idUser' => $request->idUser,
                    'idAssessment' => $request->idAssessment,
                    'idQuestionnaire' => $questionnaire->id,
                ])->first();

                $questionnaire->proposition_user = $tmp_user_resp;
            }

            return ResponseUserMarkExamResource::collection($questionnaires);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Corriger l'épreuve d'un étudiant sur un examen en ligne
     *
     * @param MarkOnlineExamStoreStudentNotesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStudentNotes(MarkOnlineExamStoreStudentNotesRequest $request)
    {
        try {
            // On fait une boucle sur les notes
            // pour chaque note, on récupère l'élément correspondant en BD et on le met à jour

            $notes = $request->notes;

            // on garde dans une variable le total de points sur cette évaluation pour lorsqu'on devra créer l'enregistrement sur la table ratings
            $total_points = 0;

            foreach ($notes as $note) {
                $prop = ResponseUser::where([
                    'idUser' => $request->idUser, // en principe idResponseUser seul suffit MAIS BON .....
                    'idQuestionnaire' => $note['idQuestionnaire'], // en principe idResponseUser seul suffit MAIS BON .....
                    'id' => $note['idResponseUser'], // en principe idResponseUser seul suffit MAIS BON .....
                ])->first();

                if(!is_null($prop)) {
                    // on s'assure que la note attribuée n'est pas > à la notemax de la question
                    $questionnaire = Questionnaire::find($note['idQuestionnaire']);
                    $tmp_note = (float) min($note['note'], $questionnaire->notemax);

                    $total_points += $tmp_note;
                    $prop->update([
                        'note' => $tmp_note,
//                        'status' => $note['status'],
                        'updated_by' => auth()->user()->id,
                    ]);
                }
            }

            $assessment = Assessment::find($request->idAssessment);
            $student = User::find($request->idUser);
            $classe = Classes::find($student->idClasse);

            // À la fin, on enregistre la note sur la table ratings
            $rating = Rating::updateOrCreate([
                'idStudent' => $request->idUser,
                'idMatter' => $assessment->idMatter,
                'idAssessmentType' => $request->idAssessmentType,
                'idAssessment' => $request->idAssessment
            ],[
                'value' => $total_points,
                'observation' => null,
                'notemax' => $assessment->notemax ?? null,
                'idCoeficient' => null,
                'idClasse' => $classe->id,
                'idTeacher' => $classe->idTeacher ?? null,
                'idSchool' => $student->idSchool,
                'idSection' => $student->idSection,
                'created_by' => auth()->user()->id,
            ]);

            return $this->sendResponse($rating, "Successfully created");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
