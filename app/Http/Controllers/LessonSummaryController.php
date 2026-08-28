<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonSummary\LessonSummaryDestroyRequest;
use App\Http\Requests\LessonSummary\LessonSummaryDownloadRequest;
use App\Http\Requests\LessonSummary\LessonSummaryGetRequest;
use App\Http\Requests\LessonSummary\LessonSummaryRestoreRequest;
use App\Http\Requests\LessonSummary\LessonSummaryStoreRequest;
use App\Http\Requests\LessonSummary\LessonSummaryTrashRequest;
use App\Http\Requests\LessonSummary\LessonSummaryUpdateRequest;
use App\Http\Resources\LessonSummaryResource;
use App\Http\Resources\StaffsSimp\LessonSimpResource;
use App\Models\Bonus;
use App\Models\Classes;
use App\Models\Image;
use App\Models\Lesson;
use App\Models\LessonSummary;
use App\Models\School;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class LessonSummaryController extends BaseController
{
    /**
     * Lister les résumés de leçons enregistrés
     *
     * @param LessonSummaryGetRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(LessonSummaryGetRequest $request)
    {
        try {
            $filter_value = $request->filter_value;
            $pageItems = $requestData['pageItems'] ?? 1; // page de pagination
            $nbreItems = $requestData['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $lesson_summaries = LessonSummary::select("lesson_summaries.*")
                ->join('lessons', 'lesson_summaries.idLesson', '=', 'lessons.id')
                ->join('chapters', 'lessons.idChapter', '=', 'chapters.id')
                ->join('modules', 'chapters.idModule', '=', 'modules.id')
                ->join('progressions', 'modules.idProgression', '=', 'progressions.id')
                ->join('classes', 'progressions.idClasse', '=', 'classes.id');

            $assessment_filters = [
                'idLesson' => $request->idLesson,
                'date' => $request->date,
                'idTeacher' => $request->idTeacher,
                'deleted' => (boolean)$request->trashed,
            ];
            foreach ($assessment_filters as $column => $value) {
                if (!is_null($value)) {
                    $lesson_summaries->where("lesson_summaries.$column", $value);
                }
            }

            if (!is_null($request->idChapter)) $lesson_summaries->where('chapters.id', $request->idChapter);
            if (!is_null($request->idModule)) $lesson_summaries->where('modules.id', $request->idModule);
            if (!is_null($request->idClasse)) $lesson_summaries->where('classes.id', $request->idClasse);

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $lesson_summaries->where(function ($lesson_summaries) use ($filter_value) {
                    $lesson_summaries->where('lesson_summaries.description', 'like', '%' . $filter_value . '%')
                        ->orwhereHas('teacher', function ($lesson_summaries) use ($filter_value) {
                            $lesson_summaries->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('lesson', function ($lesson_summaries) use ($filter_value) {
                            $lesson_summaries->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return LessonSummaryResource::collection(
                $lesson_summaries
                    ->orderBy("lesson_summaries.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un résumé d'une leçon
     *
     * @param LessonSummary $lesson_summary
     * @return LessonSummaryResource|\Illuminate\Http\JsonResponse
     */
    public function show(LessonSummary $lesson_summary)
    {
        try {
            return new LessonSummaryResource($lesson_summary);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un ou plusieurs résumés de leçon
     *
     * @param LessonSummaryStoreRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(LessonSummaryStoreRequest $request)
    {
        try {
            $summaries = [];

            foreach ($request->lesson_summaries as $tmp_lesson_summary) {
                // Créer le LessonSummary avec les données validées
                $lesson_summary = LessonSummary::create([
                    'idLesson' => $tmp_lesson_summary['idLesson'] ?? null,
                    'idTeacher' => auth()->user()->id,
                    'description' => $tmp_lesson_summary['description'],
                    'images' => !empty($tmp_lesson_summary['images']) ? implode('|', (array)$tmp_lesson_summary['images']) : null,
                    'date' => $tmp_lesson_summary['date'] ?? null,
                    'created_by' => auth()->user()->id,
                ]);

                $summaries[] = $lesson_summary;

                // Log de l'ajout
                Log::info("Ajout d'un résumé de leçon", ['lesson_summary_id' => $lesson_summary->id]);
            }

            return LessonSummaryResource::collection($summaries);
        } catch (\Throwable $th) {
            Log::critical("Erreur lors de l'ajout d'un résumé de leçon: {$th->getMessage()} in {$th->getFile()} on line {$th->getLine()}");
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier un résumé de leçon
     *
     * @param LessonSummaryUpdateRequest $request
     * @param LessonSummary $lesson_summary
     * @return LessonSummaryResource|\Illuminate\Http\JsonResponse
     */
    public function update(LessonSummaryUpdateRequest $request, LessonSummary $lesson_summary)
    {
        try {
            $lesson_summary->update([
                'idLesson' => $request->idLesson ?? $lesson_summary->idLesson,
                'idTeacher' => $request->idTeacher ?? $lesson_summary->idTeacher,
                'description' => $request->description ?? $lesson_summary->description,
                'images' => !empty($request['images']) ? implode('|', (array)$request['images']) : $lesson_summary->images,
                'date' => $request->date ?? $lesson_summary->date,
                'updated_by' => auth()->user()->id,
            ]);

            // upload des images si y'en a ici
//            if(isset($request->images) && !empty($request->images)){
//                //On désactive les images qui sont là
//                Image::where([
//                    'imageable_id' => $lesson_summary->id,
//                    'imageable_type' => LessonSummary::class,
//                ])->delete();
//
//                // On upload les nouvelles
//                foreach ($request->images as $image_link) {
//                    Image::create([
//                        'url' => uploadSingleImage($image_link, "lesson_summary"),
//                        'imageable_id' => $lesson_summary->id,
//                        'imageable_type' => LessonSummary::class,
//                    ]);
//                }
//            }

            return LessonSummaryResource::make($lesson_summary);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver un ou plusieurs résumés de leçons
     *
     * @param LessonSummaryTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash(LessonSummaryTrashRequest $request)
    {
        try {
            $author = auth()->user();

            LessonSummary::whereIn('id', $request->ids)->each(function ($lesson_summary) use ($author) {
                //TODO: Je peux archiver un résumé si j'en suis l'auteur ou fondateur/directeur
                // Si je suis role==7, on vérifie que le résumé m'appartient
                if (
                    in_array($author->getRole()->id, [1, 2, 3]) ||
                    ($author->getRole()->id === 7 && $author->id === $lesson_summary->idTea)
                ) {
                    $lesson_summary->update([
                        'deleted' => true,
                        'deleted_by' => $author->id,
                    ]);

                    Log::critical("Résumé de leçon mis en corbeille.", ['lesson_summary' => $lesson_summary->id, 'author' => $author->id]);
                }
            });

            return $this->sendResponse([], 'Résumé(s) de leçon mis en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer un ou plusieurs résumé(s) de leçons
     *
     * @param LessonSummaryRestoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(LessonSummaryRestoreRequest $request)
    {
        try {
            $author = auth()->user();

            LessonSummary::whereIn('id', $request->ids)->each(function ($lesson_summary) use ($author) {
                //TODO: Je peux archiver un résumé si j'en suis l'auteur ou fondateur/directeur
                // Si je suis role==7, on vérifie que le résumé m'appartient

                if (
                    in_array($author->getRole()->id, [1, 2, 3]) ||
                    ($author->getRole()->id === 7 && $author->id === $lesson_summary->idTea)
                ) {
                    $lesson_summary->update([
                        'deleted' => false
                    ]);

                    Log::critical("Résumé de leçon restauré.", ['lesson_summary' => $lesson_summary->id, 'author' => $author->id]);
                }
            });

            return $this->sendResponse([], 'Résumé(s) de leçon restauré(s).');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un ou plusieurs résumés de leçons
     *
     * @param LessonSummaryDestroyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LessonSummaryDestroyRequest $request)
    {
        try {
            $author = auth()->user();

            LessonSummary::whereIn('id', $request->ids)->each(function ($lesson_summary) use ($author) {
                Log::critical("Résumé de leçon supprimé.", ['lesson_summary' => $lesson_summary->id, 'author' => $author->id]);
                $lesson_summary->delete();
            });

            return $this->sendResponse([], 'Résumé(s) de leçon supprimé(s).');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Téléchargement PDF des résumés de leçon
     *
     * @param LessonSummaryDownloadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
        public function download(LessonSummaryDownloadRequest $request)
        {
            try {
                $lesson = Lesson::select('id', 'name', 'idChapter', 'idSchool')
                    ->find($request->idLesson);

                $lesson_summaries = LessonSummary::where('idLesson', $request->idLesson)
                    ->when($request->idLessonSummary !== null, function ($query) use ($request) {
                        $query->where('id', $request->idLessonSummary);
                    })
                    ->get()
                    ->map(function ($summary) {
                        // Transformer la chaîne "img1|img2" en tableau ['img1', 'img2']
                        $summary['images'] = !empty($summary['images'])
                            ? explode('|', $summary['images'])
                            : [];
                        return $summary;
                    });

                $data = [
                    'lesson' => json_encode(new LessonSimpResource($lesson)), // petit contournement de m***
                    'lesson_summaries' =>  $lesson_summaries,
                    'school' => School::select('id', 'name', 'logo')
                        ->where('id', $lesson->idSchool)
                        ->firstOrFail(),
                ];

                $filename = Str::slug("Résumé(s) de la leçon {$lesson->name}", '-' ) . '.pdf';

                $dompdf = new Dompdf();

                $folder = "documents.lesson-summaries";

                $route = $request->route;

                (view()->exists($folder."." . $route))
                    ? $vue = $folder."." . $route
                    : $vue = $folder.".default";

                // Récupérer la vue
                $view = View::make($vue)->with($data);

                // Récupérer le contenu de la vue
                $html = $view->render();

                // Charger le contenu HTML dans Dompdf
                $dompdf->loadHtml($html);

                // (Optionnel) Définir la taille et l'orientation du papier
                $dompdf->setPaper('A4', 'portrait');

                // Exécuter le rendu du PDF
                $dompdf->render();

                file_put_contents(public_path("pdfs/$filename"), $dompdf->output());

                return $this->sendResponse(asset("pdfs/$filename"), "Liste des questions/réponses aux examens.");
            } catch (\Throwable $th) {
                Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
                return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
            }
        }
}
