<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staffs\PresenceTeacherCreateRequest;
use App\Http\Requests\Staffs\PresenceTeacherRequest;
use App\Http\Requests\TauxHorairePresenceTeacherRequest;
use App\Http\Requests\PresenceTeacher\PresenceTeacherArchiveRequest;
use App\Http\Resources\Staffs\PresenceTeacherResource;
use App\Http\Resources\Staffs\TeacherResource;
use App\Models\PresenceTeacher;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Presence Teacher
 */
class PresenceTeacherController extends BaseController
{
    /**
     * Lister les présences enseignants
     *
     * @param PresenceTeacherRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(PresenceTeacherRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $presenceteachers = PresenceTeacher::query();

            if($request->filled('idSection')){
                $presenceteachers->where('idSection',$request['idSection']);
            }
            if(isset($request['type'])){
                $presenceteachers->where('type',$request['type']);
            }
            if(isset($request['scanPerCourse'])){
                $presenceteachers->where('scanPerCourse',$request['scanPerCourse']);
            }
            if(isset($request['savingType'])){
                $presenceteachers->where('savingType',$request['savingType']);
            }
            if($request->filled('idTeacher')){
                $presenceteachers->where('idTeacher',$request['idTeacher']);
            }
            if(!is_null($request['date'])){
                $presenceteachers->where('date',$request['date']);
            }
            $date_start = $request['date_start'];
            $date_end = $request['date_end'];
            if(!is_null($date_start) && !is_null($date_end)) {
                $presenceteachers->whereBetween('date', [$date_start, $date_end]);
            } elseif (!is_null($date_start)) {
                $presenceteachers->whereDate('date', '>=', $date_start);
            } elseif (!is_null($date_end)) {
                $presenceteachers->whereDate('date', '<=', $date_end);
            }

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $presenceteachers->where(function($query) use ($filter_value) {
                    $query->where('type', 'like', "%$filter_value%")
                        ->orWhere('savingType', 'like', "%$filter_value%")
                        ->orWhere('hour', 'like', "%$filter_value%")
                        ->orWhere('arrivalTime', 'like', "%$filter_value%")
                        ->orWhere('departureTime', 'like', "%$filter_value%")
                        ->orWhereHas('teacher', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
//                        ->orWhereHas('matter', function($q) use ($filter_value) {
//                            $q->where('name', 'like', "%$filter_value%");
//                        });
//                        ->orWhereHasMorph('invoiceable', ['App\Models\User', 'App\Models\Customer'], function($q) use ($filter_value) {
//                            $q->where('name', 'like', "%$filter_value%");
//                        });
                });
            }

            return PresenceTeacherResource::collection(
                $presenceteachers
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une présence manuellement
     *
     * @param PresenceTeacherCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresenceTeacherCreateRequest $request)
    {
        try {
            $presenceteachers = $request->validated();

            $teacher = User::find($request['idTeacher']);
            $classe = Classes::find($request['idClasse']);

            $presenceteachers = PresenceTeacher::create([
                'idTeacher' => $request['idTeacher'],
                'date' => $request['date'] ?? null,
                'hour' => $request['hour'] ?? null,
                'arrivalTime' => $request['arrivalTime'] ?? null,
                'departureTime' => $request['departureTime'] ?? null,
                'idCourse' => $request['idCourse'] ?? null,
                'idSchool' => $classe->idSchool ?? null, 
                'idSection' => $classe->idSection ?? null,
                'type' => $request['type'],
                'scanPerCourse' => $request['scanPerCourse'],
                'raison' => $request['raison'],
                'savingType' => 'manuel',
                'created_by' => auth()->user()->id
            ]);

            return $this->sendResponse($presenceteachers,"successfully created");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Afficher les détails d'une présence enseignant
     *
     * @param PresenceTeacher $presenceteachers
     * @param $id
     * @return PresenceTeacherResource|\Illuminate\Http\Response
     */
    public function show(PresenceTeacher $presenceteachers,$id)
    {
        try {
            $presenceteachers = PresenceTeacher::find($id);
            return new PresenceTeacherResource($presenceteachers);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une présence enseignant
     *
     * @param PresenceTeacherRequest $request
     * @param PresenceTeacher $presenceteachers
     * @param $id
     * @return PresenceTeacherResource|\Illuminate\Http\Response
     */
    public function update(PresenceTeacherRequest $request,PresenceTeacher $presenceteachers, $id)
    {
        try {
            $presenceteachers = PresenceTeacher::find($id);
            $presenceteachers->idTeacher = $request['idTeacher'] ?? $presenceteachers['idTeacher'];
            $presenceteachers->date = $request['date'] ?? $presenceteachers['date'];
            $presenceteachers->hour = $request['hour'] ?? $presenceteachers['hour'];
            $presenceteachers->arrivalTime = $request['arrivalTime'] ?? $presenceteachers['arrivalTime'];
            $presenceteachers->departureTime = $request['departureTime'] ?? $presenceteachers['departureTime'];
            $presenceteachers->idCourse = $request['idCourse'] ?? $presenceteachers['idCourse'];
            $presenceteachers->idSection = $request['idSection'] ?? $presenceteachers['idSection'];
            $presenceteachers->updated_by = auth()->user()->id;

            $presenceteachers->idSchool = User::find($presenceteachers->idTeacher)->idSchool;

            $presenceteachers->save();

            return new PresenceTeacherResource($presenceteachers);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des présences enseignants à la corbeille (soft delete).
     *
     * @param PresenceTeacherArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(PresenceTeacherArchiveRequest $request): JsonResponse
    {
        try {
            PresenceTeacher::whereIn('id', $request->ids)->delete();
            Log::info('Présences enseignants mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('presenceteacher.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des présences enseignants : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des présences enseignants supprimés (soft delete).
     *
     * @param PresenceTeacherArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(PresenceTeacherArchiveRequest $request): JsonResponse
    {
        try {
            PresenceTeacher::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Présences enseignants restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('presenceteacher.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des présences enseignants : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des présences enseignants (hard delete).
     *
     * @param PresenceTeacherArchiveRequest $request
     * @return JsonResponse
     */
    public function destroyBulk(PresenceTeacherArchiveRequest $request): JsonResponse
    {
        try {
            PresenceTeacher::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Présences enseignants supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('presenceteacher.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des présences enseignants : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une présence enseignant (ancienne méthode conservée pour compatibilité)
     *
     * @param PresenceTeacher $presenceteachers
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(PresenceTeacher $presenceteachers,$id)
    {
        try {
            $presenceteachers = PresenceTeacher::find($id);
            $presenceteachers->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Calcul du taux horaire d'un enseignant
     *
     * @param TauxHorairePresenceTeacherRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function calcultauxhoraire(TauxHorairePresenceTeacherRequest $request)
    {
        try {
            $totalHours = PresenceTeacher::select(DB::raw('SUM(courses.duration) AS total_horaire'))
                ->join('courses', 'courses.id', '=', 'presence_teacher.idCourse')
                ->join('users', 'users.id', '=', 'presence_teacher.idTeacher')
                ->whereBetween('presence_teacher.date', [$request->date_debut, $request->date_fin])
                ->where('presence_teacher.idTeacher', $request['idTeacher'])
                ->groupBy('presence_teacher.idTeacher', 'users.name')
                ->first();

            return response()->json([
                'total_horaire' => $totalHours->total_horaire ?? null,
                'teacher' => TeacherResource::make(User::find($request['idTeacher']))
            ]);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
