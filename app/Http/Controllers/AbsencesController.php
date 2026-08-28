<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceGetRequest;
use App\Http\Requests\Absence\AbsenceArchiveRequest;
use App\Models\AssessmentType;
use App\Models\Course;
use App\Models\Homework;
use App\Models\Notification;
use App\Models\School;
use App\Models\User;
use App\Traits\NotificationsTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\AbsencesResource;
use App\Http\Requests\Staffs\AbsencesRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Absence;
use App\Services\AbsenceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Absence
 */
class AbsencesController extends BaseController
{
    use NotificationsTrait;

    protected $absenceService;

    public function __construct(AbsenceService $absenceService)
    {
        $this->absenceService = $absenceService;
    }

    /**
     * Listage des absences
     * @param AbsenceGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(AbsenceGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1;
            $nbreItems = $request['nbreItems'] ?? 1000000;

            $absences = Absence::with(['course', 'student', 'teacher'])
                ->where('idSchool', $request['idSchool'])
                ->when($request->filled('idSection'), function($q) use ($request) {
                    return $q->where('idSection', $request['idSection']);
                })
                ->when($request->filled('idStudent'), function($q) use ($request) {
                    return $q->where('idStudent', $request['idStudent']);
                })
                ->when($request->filled('idUser'), function($q) use ($request) {
                    return $q->where('idStudent', $request['idUser']);
                })
                ->when($request->filled('idTeacher'), function($q) use ($request) {
                    return $q->where('idTeacher', $request['idTeacher']);
                })
                ->when($request->filled('type'), function($q) use ($request) {
                    return $q->where('type', $request['type']);
                })
                ->when($request->filled('date'), function($q) use ($request) {
                    return $q->whereDate('date', $request['date']);
                })
                ->when($request->filled('idClasse'), function($q) use ($request) {
                    return $q->whereHas('course', function($c) use ($request) {
                        $c->where('idClasse', $request['idClasse']);
                    });
                })
                ->when($request->filled('is_justified'), function($q) use ($request) {
                    return $q->where('is_justified', $request['is_justified']);
                })
                ->when($request->filled('start_date') && $request->filled('end_date'), function($q) use ($request) {
                    return $q->whereBetween('date', [$request['start_date'], $request['end_date']]);
                })
                ->when($request->filled('start_date') && !$request->filled('end_date'), function($q) use ($request) {
                    return $q->where('date', '>=', $request['start_date']);
                })
                ->when(!$request->filled('start_date') && $request->filled('end_date'), function($q) use ($request) {
                    return $q->where('date', '<=', $request['end_date']);
                })
                ->when($request->filled('filter_value'), function($q) use ($request) {
                    $filterValue = $request['filter_value'];
                    return $q->where(function($query) use ($filterValue) {
                        $query->where('date', 'like', "%$filterValue%")
                            ->orWhereHas('student', function($s) use ($filterValue) {
                                $s->where('name', 'like', "%$filterValue%");
                            });
                    });
                });

            // Calcul des statistiques avant pagination
            $totalAbsences = (clone $absences)->count();

            $justifiedAbsences = (clone $absences)->where('is_justified', true)->with('course')->get();
            $totalDurationJustified = $justifiedAbsences->sum(function($absence) {
                return $absence->course ? $absence->course->duration : 0;
            });

            $notJustifiedAbsences = (clone $absences)->where('is_justified', false)->with('course')->get();
            $totalDurationNotJustified = $notJustifiedAbsences->sum(function($absence) {
                return $absence->course ? $absence->course->duration : 0;
            });

            return AbsencesResource::collection(
                $absences
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            )->additional([
                'statistics' => [
//                    'total_absences' => $totalAbsences,
                    'total_duration_justified' => (int) $totalDurationJustified,
                    'total_duration_not_justified' => (int) $totalDurationNotJustified,
                ]
            ]);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter des absences
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $tab = array();

            if(!empty($request['absences'])){

                $tab = $request['absences'];

                for ($i=0; $i < count($tab); $i++) {
                    $student = User::find($tab[$i]['idStudent']);

                    $school = School::find($student->idSchool);

                    // If idAssessmentType is not provided, find it based on date
//                    if (!isset($tab[$i]['idAssessmentType']) || is_null($tab[$i]['idAssessmentType'])) {
//                        $assessmentType = AssessmentType::where('idSchool', $student->idSchool)
//                            ->where('start_date', '<=', $tab[$i]['date'])
//                            ->where('end_date', '>=', $tab[$i]['date'])
//                            ->first();
//                        if ($assessmentType) {
//                            $tab[$i]['idAssessmentType'] = $assessmentType->id;
//                        }
//                    }

                    $absence = Absence::create([
                        'image' => $tab[$i]['image'] ?? null,
                        'type' => $tab[$i]['type'],
                        'date' => $tab[$i]['date'] ?? null,
                        'periode' => $tab[$i]['periode'] ?? null,
                        'justification' => $tab[$i]['justification'] ?? null,
                        'idCourse' => $tab[$i]['idCourse'] ?? null,
                        'is_justified' => $tab[$i]['is_justified'] ?? false,
                        'idAssessmentType' => $tab[$i]['idAssessmentType'] ?? null,
                        'idTeacher' => $tab[$i]['idTeacher'] ?? null,
                        'idStudent' => $tab[$i]['idStudent'],
                        'idSchool' => $student->idSchool,
                        'idSection' => $student->idSection ?? null,
                        'created_by' => auth()->user()->id
                    ]);

                    if(!is_null($tab[$i]['idStudent'])){
                        $user = User::find($tab[$i]['idStudent']);

                        //TODO: On vérifie le type d'école pour avoir le bon idUser qui recevra & verra la notif

                        $infos_du_cours = Course::select('courses.id', 'courses.hour', 'courses.idMatter', 'matter.libelle', 'matter.name')
                            ->join('matter', 'matter.id', '=', 'courses.idMatter')
                            ->where('courses.id', $tab[$i]['idCourse'])
                            ->first();

                        Notification::create([
                            'notificationable_type' => Absence::class,
                            'notificationable_id' => $absence->id,
                            'title' => __('notifs.absence_title'),
                            'description' => __('notifs.absence_desc', [
                                'nom' => $user->name,
                                'cours_libelle' => $infos_du_cours->libelle,
                                'date' => $tab[$i]['date'],
                                'heure' => $infos_du_cours->hour->format('H:i')
                            ]), //$user->name . ' absent(e) au cours de '.$infos_du_cours->libelle.' le '.$tab[$i]['date'] . ' à ' . $infos_du_cours->hour->format('H:i'),
                            'user_id' => (in_array($school->scholar_level, ["University", "CF"]))
                                ? $user->id
                                : $user->idParent,
                            'grouped_users' => null,
                        ]);
                    }
                }
            }

            return $this->sendResponse($tab,"successfully created");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les détails d'une absence
     * @param $id
     * @return AbsencesResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $absence = Absence::findOrFail($id);
            return new AbsencesResource($absence);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une absence
     * @param AbsencesRequest $request
     * @param $id
     * @return AbsencesResource|JsonResponse
     */
    public function update(AbsencesRequest $request, $id)
    {
        try {
            $absence = Absence::find($id);

            $student = User::find($absence->idStudent);

            $absence->image = $request['image'] ?? $absence['image'];
            $absence->type = $request['type'] ?? $absence['type'];
            $absence->date = $request['date'] ?? $absence['date'];
            $absence->periode = $request['periode'] ?? $absence['periode'];
            $absence->justification = $request['justification'] ?? $absence['justification'];
            $absence->idCourse = $request['idCourse'] ?? $absence['idCourse'];
            $absence->is_justified = $request['is_justified'] ?? $absence['is_justified'];
            $absence->idAssessmentType = $request['idAssessmentType'] ?? $absence['idAssessmentType'];
            $absence->idTeacher = $request['idTeacher'] ?? $absence['idTeacher'];
            $absence->idStudent = $request['idStudent'] ?? $absence['idStudent'];
            $absence->idSchool = $student->idSchool;
            $absence->idSection = $student->idSection;
            $absence->updated_by = auth()->user()->id;

            $absence->save();
            return new AbsencesResource($absence);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des absences à la corbeille (soft delete).
     *
     * @param AbsenceArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(AbsenceArchiveRequest $request): JsonResponse
    {
        try {
            Absence::whereIn('id', $request->ids)->delete();
            Log::info('Absences mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('absence.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des absences : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des absences supprimés (soft delete).
     *
     * @param AbsenceArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(AbsenceArchiveRequest $request): JsonResponse
    {
        try {
            Absence::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Absences restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('absence.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des absences : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des absences (hard delete).
     *
     * @param AbsenceArchiveRequest $request
     * @return JsonResponse
     */
    public function destroyBulk(AbsenceArchiveRequest $request): JsonResponse
    {
        try {
            Absence::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Absences supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('absence.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des absences : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une absence
     * @param $id
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function destroy($id)
    {
        try {
            $absences = Absence::findOrFail($id);

            $absences->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
