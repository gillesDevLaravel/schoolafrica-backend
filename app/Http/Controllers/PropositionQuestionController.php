<?php

namespace App\Http\Controllers;

use App\Http\Requests\PDFListStudentAnswersOnAssessmentRequest;
use App\Http\Requests\PropositionQuestionAllRequest;
use App\Http\Requests\PropositionQuestionStoreRequest;
use App\Http\Requests\PropositionQuestionUpdateRequest;
use App\Http\Resources\Admin\PropositionQuestionResource;
use App\Http\Resources\AdminSimp\PropositionQuestionSimpResource;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\ExamStudent;
use App\Models\PropositionQuestion;
use App\Models\Questionnaire;
use App\Models\ResponseUser;
use App\Models\School;
use App\Models\User;
use App\Services\PDFGlobalGeneratorService;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PropositionQuestionController extends BaseController
{
    protected $pdfGlobalGenerator;

    public function __construct(PDFGlobalGeneratorService $pdfGlobalGenerator)
    {
        $this->pdfGlobalGenerator = $pdfGlobalGenerator;
    }

    /**
     * Lister les propositions de questions d'un examen
     *
     * @param PropositionQuestionAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PropositionQuestionAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $idQuestion = $request->idQuestion;

            $pages = PropositionQuestion::query();

            if(!is_null($request->idQuestion)) $pages = $pages->where('idQuestionnaire', $idQuestion);

            if(!is_null($filter_value)){
                $pages->where(function($query) use ($filter_value) {
                    $query->where('intitule', 'like', "%$filter_value%");
//                        ->orWhere('reponse', 'like', "%$filter_value%");
                });
            }

            $props = $pages
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            if(auth()->user()->getRole()->id === 8){
                return PropositionQuestionSimpResource::collection($props);
            }else{
                return PropositionQuestionResource::collection($props);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une proposition de question
     *
     * @param $idPropositionQuestion
     * @return PropositionQuestionResource|\Illuminate\Http\JsonResponse
     */
    public function show($idPropositionQuestion)
    {
        try {
            $propositionQuestion = PropositionQuestion::findOrFail($idPropositionQuestion);
            return PropositionQuestionResource::make($propositionQuestion);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une proposition de question
     *
     * @param PropositionQuestionStoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(PropositionQuestionStoreRequest $request)
    {
        try {
            $propositions = $request->propositions;

            $props = [];
            foreach ($propositions as $proposition) {
                $props[] = PropositionQuestion::updateOrCreate([
                    'intitule' => $proposition['intitule'],
                    'is_correct' => $proposition['is_correct'],
                    'idQuestionnaire' => $request->idQuestion
                ]);
            }

            return PropositionQuestionResource::collection($props);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une proposition de question d'examen
     *
     * @param PropositionQuestionUpdateRequest $request
     * @param $id
     * @return PropositionQuestionResource|\Illuminate\Http\JsonResponse
     */
    public function update(PropositionQuestionUpdateRequest $request, $id)
    {
        try {
            $propositionQuestion = PropositionQuestion::findOrFail($id);

            $propositionQuestion->update([
                'intitule' => $request->intitule ?? $propositionQuestion->intitule,
                'is_correct' => $request->is_correct ?? $propositionQuestion->is_correct,
                'idQuestionnaire' => $request->idQuestionnaire ?? $propositionQuestion->idQuestionnaire,
                'updated_by' => auth()->user()->id,
            ]);

            return PropositionQuestionResource::make($propositionQuestion);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer une proposition de question à la corbeille
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash($id)
    {
        try {
            if(auth()->user()->getRole()->id === 8){
                return $this->sendError("Non autorisé", [], 403);
            }

            $propositionQuestion = PropositionQuestion::findOrFail($id);

            $propositionQuestion->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return $this->sendResponse([], "PropositoinQuestion supprimée avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une proposition de question de la corbeille
     * NB: Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return PropositionQuestionResource|\Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        try {
            $propositionQuestion = PropositionQuestion::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $propositionQuestion->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);

            return PropositionQuestionResource::make($propositionQuestion);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Lister dans un PDF les réponses d'un étudiant à un ou plusieurs évaluations d'une séquence
     *
     * @param PDFListStudentAnswersOnAssessmentRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function listStudentAnswersOnAssessment(PDFListStudentAnswersOnAssessmentRequest $request)
    {
        try {
            /**
             * On récupère tous les examens (idAssessment peut être null)
             * Pour chacun de ces examens, on récupère les couples Question/Réponse pour l'étudiant
             * On va donc remplir le PDF avec ces infos
             */

            $classe = Classes::select('id', 'name')
                ->where('deleted', 0)
                ->where('id', $request->idClasse)
                ->firstOrFail();

            $assessmentType = AssessmentType::select('id', 'name', 'idSchool')
                ->where('id', $request->idAssessmentType)
                ->where('deleted', 0)
                ->firstOrFail();

            // On récupére le(s) student(s) de la classe
            $students = User::select('users.id', 'users.name', 'users.matricule', 'users.photo', 'users.idClasse')
                ->join('classes', 'classes.id', '=', 'users.idClasse')
                ->when($request->idClasse !== null, function ($query) use ($request) {
                    $query->where('users.idClasse', $request->idClasse);
                })
                ->when($request->idStudent !== null, function ($query) use ($request) {
                    $query->where('users.id', $request->idStudent);
                })
                ->where('users.deleted', 0)
                ->get();

            $folder = "documents.questions-reponses";
            $route = $request->route;

            (view()->exists($folder."." . $route))
                ? $vue = $folder."." . $route
                : $vue = $folder.".default";

            $docs = array();

            // on va créer un sous dossier et mettre les épreuves de chaun dedans
            foreach ($students as $student) {
                $exams = ExamStudent::select('matter.name', 'matter.libelle', 'exam_students.id', 'exam_students.idAssessmentType', 'exam_students.idAssessment')
                    ->join('assessments', 'exam_students.idAssessment', '=', 'assessments.id')
                    ->join('matter', 'matter.id', '=', 'assessments.idMatter')
                    ->where('exam_students.idUser', $student->id)
                    ->where('exam_students.idAssessmentType', $request->idAssessmentType)
                    ->when(!is_null($request->idAssessment), function($query) use ($request) {
                        $query->where('exam_students.idAssessment', $request['idAssessment']);
                    })
                    ->where('exam_students.deleted', 0)
                    ->where('assessments.deleted', 0)
                    ->get();

                if(count($exams) == 0){
                    continue;
                }

                foreach ($exams as $exam) {
                    $questions = Questionnaire::select('id', 'intitule', 'reponse')
                        ->where('idAssessment', $exam->idAssessment)
                        ->where('idAssessmentType', $exam->idAssessmentType)
                        ->orderBy('id', 'desc')
                        ->get();

                    foreach ($questions as $question) {
                        $proposition_etudiant = ResponseUser::select('id', 'idQuestionnaire', 'response')
                            ->where('idAssessment', $exam->idAssessment)
                            ->where('idQuestionnaire' , $question->id)
                            ->where('idUser', $student->id)
                            ->first();

                        $question['proposition_etudiant'] = !is_null($proposition_etudiant) ? $proposition_etudiant : ['response' =>"R.A.S"];
                    }

                    $exam['questions'] = $questions;

                    $data = [
                        'assessmentType' =>  $assessmentType,
                        'student' =>  $student,
                        'exam' =>  $exam,
                        'school' => School::select('id', 'name', 'logo')
                            ->where('id', $assessmentType->idSchool)
                            ->first(),
                        'classe' => $classe,
                    ];

                    $filename = Str::slug("{$student->name} sur {$exam->name}", '_' );

                    $pdf_generated = $this->pdfGlobalGenerator->generatePDF($vue, $data, $filename, Str::slug($student->name));

                    $docs[] = [
                        'name' => $filename, // je pourais avoir besoin de ce nom plus tard
                        'link' => $pdf_generated,
                        'folder' => Str::slug($student->name),
                    ];
                }
            }

            return $this->sendResponse($this->pdfGlobalGenerator->generateZIP($docs, Str::slug("Epreuves")), "Liste des questions/réponses aux examens.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
