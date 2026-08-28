<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\DuplicateCoursRequest;
use App\Models\Classes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Requests\Staffs\CourseRequest;

use App\Http\Requests\Course\CourseArchiveRequest;
use App\Http\Requests\Staffs\CourseGetAllRequest;
use App\Http\Resources\Staffs\CourseResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Course
 */
class CourseController extends BaseController
{
    /**
     * Lister les cours
     *
     * @param CourseGetAllRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(CourseGetAllRequest $request)
    {
        try {
            $course  = $request->validated();

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $idSection = $request['idSection'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idPiece = $request['idPiece'] ?? null;
            $date_start = $request['date_start'] ?? null;
            $date = $request['date'] ?? null;
            $jour = $request['jour'] ?? null;

            $date_end = $request['date_end'] ?? null;

            $filterUniqueCourses = $request['filterUniqueCourses'] ?? null; // 13 & 4

            $filter_value = $request['filter_value'];

           // $courses = Course::where('courses.idSchool',$course['idSchool']);
           $courses = Course::query();

            if(!is_null($idSection)){
                $courses = $courses->where('idSection',$idSection);
            }
            if(!is_null($idPiece)){
                $courses = $courses->where('idPiece',$idPiece);
            }
            if(!is_null($idLevel)){
                $courses = $courses->where('idLevel',$idLevel);
            }if(!is_null($idClasse)){
                $courses = $courses->where('idClasse',$idClasse);
            }if(!is_null($idTeacher)){
                $courses = $courses->where('idTeacher',$idTeacher);
            }if(!is_null($date)){
                $courses = $courses->where('date',$date);
            }if(!is_null($jour)){
                $courses = $courses->where('day',$jour);
            }if($date_start != null && $date_end != null){
                $courses = $courses->where('idClasse',$request['idClasse']);
            }
            if(!is_null($filter_value)){
                $courses->where(function($query) use ($filter_value) {
                    $query
                        ->where('day', 'like', "%$filter_value%")
                        ->orWhere('date', 'like', "%$filter_value%")
                        ->orwhereHas('matter', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('teacher', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('classe', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            if($filterUniqueCourses ){
                $courses = $courses->distinct('idMatter');
            }

            return CourseResource::collection(
                $courses->orderBy("courses.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un nouveau cours
     *
     * @param CourseRequest $request
     * @return CourseResource|JsonResponse
     */
    public function store(CourseRequest $request)
    {
        try {
            $course = $request->validated();

            $classe = Classes::find($request['idClasse']);

            $course = new Course();

            $course->hour = $request['hour'];
            $course->duration = $request['duration'];
            $course->day = $request['day'];
            $course->date = $request['date'] ?? null;
            $course->document = $request['document'] ?? null;
            $course->idMatter = $request['idMatter'];
            $course->idClasse = $request['idClasse'];
            $course->idTeacher = $request['idTeacher'];
            $course->idSchool = $classe->idSchool;
            $course->idSection = $classe->idSection;
            $course->idLevel = $classe->idLevel ?? null;
            $course->idPiece = $request['idPiece'] ?? null;
            $course->created_by = auth()->user()->id;
            $course->save();

            return new CourseResource($course);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function duplicateCours(DuplicateCoursRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $duplicatedCours = [];
                $classe = Classes::find($request['idClasse']);

                if (!empty($request['cours_id'])) {
                    $coursIds = $request['cours_id'];

                    foreach ($coursIds as $coursId) {
                        $originalCours = Course::find($coursId);

                        if (!$originalCours) {
                            Log::warning("Cours introuvable pour l'ID : {$coursId}");
                            continue; // passe au suivant
                        }

                        $cours = $originalCours->replicate();
                        $cours->idClasse = $request['idClasse'];
                        $cours->idTeacher = $request['idTeacher'];
                        $cours->idSchool = $classe->idSchool;
                        $cours->idSection = $classe->idSection;

                        $cours->save();

                        $duplicatedCours[] = $cours;
                    }
                }

                return $this->sendResponse($duplicatedCours, "Successfully duplicated assessments");
            });
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'un cours
     *
     * @param $id
     * @return CourseResource|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course = Course::find($id);
            return new CourseResource($course);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un cours
     *
     * @param Request $request
     * @param Course $course
     * @param $id
     * @return CourseResource|\Illuminate\Http\Response
     */
    public function update(Request $request, Course $course,$id)
    {
        try {
            $course = Course::find($id);

            $classe = Classes::find($request['idClasse']);

            $course->hour = $request['hour'] ?? $course['hour'];
            $course->duration = $request['duration'] ?? $course['duration'];
            $course->day = $request['day'] ?? $course['day'];
            $course->date = $request['date'] ?? $course['date'];
            $course->document = $request['document'] ?? null;
            $course->idMatter = $request['idMatter'] ?? $course->idMatter;
            $course->idClasse = $request['idClasse'];
            $course->idTeacher = $request['idTeacher'] ?? $course->idTeacher;
            $course->idSchool = $classe->idSchool ?? $request['idSchool'];
            $course->idSection = $classe->idSection ?? $request['idSection'];
            $course->idPiece = $classe->idPiece ?? $request['idPiece'];
            $course->idLevel = $classe->idLevel ?? $request['idLevel'];
            $course->updated_by = auth()->user()->id;
            $course->save();

            return new CourseResource($course);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }

    }

    /**
     * Supprimer un cours
     *
     * @param Course $course
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Course $course,$id)
    {
        try {
            $course = Course::find($id);
            $course->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer plusieurs cours
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyBulk(Request $request)
    {
        try {
            $this->validate($request, [
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:courses,id',
            ]);

            $ids = $request->input('ids');

            foreach ($ids as $id) {
                $course = Course::findOrFail($id);

                // Archiver (flag) au lieu de supprimer définitivement
                $course->update([
                    'deleted' => true,
                    'deleted_by' => auth()->user()->id,
                ]);
            }

            return response()->json(['message' => 'Cours archivés avec succès.'], 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des cours à la corbeille (soft delete).
     *
     * @param CourseArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(CourseArchiveRequest $request): JsonResponse
    {
        try {
            Course::whereIn('id', $request->ids)->delete();
            Log::info('Cours mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('course.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des cours : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des cours supprimés (soft delete).
     *
     * @param CourseArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(CourseArchiveRequest $request): JsonResponse
    {
        try {
            Course::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Cours restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('course.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des cours : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
    /**
     * Supprime définitivement des cours (hard delete).
     *
     * @param CourseArchiveRequest $request
     * @return JsonResponse
     */
    public function forceDelete(CourseArchiveRequest $request): JsonResponse
    {
        try {
            Course::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Cours supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('course.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des cours : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter plusieurs cours en un course
     *
     * @bodyParam courses Array de cours à ajouter. Le format de chaque tableau est définit par POST /api/courses
     * @return CourseResource|\Illuminate\Http\Response
     */
    public function storeBulk(Request $request)
    {
        try {
            $this->validate($request, [
                'courses' => 'required'
            ]);

            $courses = $request->courses;

            foreach ($courses as $cours) {
                $course = new Course();

                $course->hour = $cours['hour'];
                $course->duration = $cours['duration'];
                $course->day = $cours['day'];
                $course->date = $cours['date'] ?? null;
                $course->document = $cours['document'] ?? null;
                $course->idMatter = $cours['idMatter'];
                $course->idClasse = $cours['idClasse'];
                $course->idTeacher = $cours['idTeacher'];
                $course->idSchool = $cours['idSchool'];
                $course->idSection = $cours['idSection'];
                $course->idLevel = $cours['idLevel'] ?? null;
                $course->created_by = auth()->user()->id;
                $course->save();
            }

            return response()->json([], 201);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
