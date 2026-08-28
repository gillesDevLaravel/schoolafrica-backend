<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Http\Requests\Staffs\LessonRequest;
use App\Http\Requests\Staffs\LessonGetAllRequest;
use App\Http\Resources\Staffs\LessonResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Lessons
 */
class LessonController extends BaseController
{
    /**
     * Afficher la liste des leçons
     *
     * @param LessonGetAllRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(LessonGetAllRequest $request)
    {
        try {
            $lesson  = $request->validated();
            $idChapter = $request['idChapter'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $filter_value = $request['filter_value'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $lessons = Lesson::where('idSchool',$lesson['idSchool']);

            if(!is_null($idSection)) $lessons = $lessons->where('idSection',$lesson['idSection']);

            if(!is_null($idChapter)) $lessons = $lessons->where('idChapter', $idChapter);

            if(!is_null($filter_value)){
                $lessons->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('startDate', 'like', "%$filter_value%")
                        ->orWhere('endDate', 'like', "%$filter_value%")
                        ->orwhereHas('chapter', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return LessonResource::collection(
                $lessons
                    ->orderBy("id", "asc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LessonRequest $request
     * @return JsonResponse|LessonResource
     */
    public function store(LessonRequest $request)
    {
        try {
            $lesson = $request->validated();

            $chapter = Chapter::find($request->idChapter);

            $lesson = new Lesson();

            $lesson->name = $request['name'];
            $lesson->description = $request['description'];
            $lesson->nbrSections = $request['nbrSections'] ?? null;
            $lesson->status = $request['status'] ?? null;
            $lesson->observation = $request['observation'] ?? null;
            $lesson->startDate = $request['startDate'] ?? null;
            $lesson->endDate = $request['endDate'] ?? null;
            $lesson->duration = $request['duration'] ?? null;
            $lesson->image = $request['image'] ?? null;
            $lesson->idChapter = $request['idChapter'];
            $lesson->idSchool = $chapter->idSchool;
            $lesson->idSection = $chapter->idSection;
            $lesson->created_by = auth()->user()->id;
            $lesson->save();

            return new LessonResource($lesson);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Lesson $lesson,$id)
    {
        try {
            $lesson = Lesson::find($id);
            return new LessonResource($lesson);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(LessonRequest $request, Lesson $lesson,$id)
    {
        try {
            $chapter = Chapter::find($request->idChapter);

            $lesson = Lesson::find($id);
            $lesson->name = $request['name'];
            $lesson->description = $request['description'];
            $lesson->nbrSections = $request['nbrSections'] ?? null;
            $lesson->status = $request['status'] ?? null;
            $lesson->observation = $request['observation'] ?? $lesson['observation'];
            $lesson->startDate = $request['startDate'] ?? null;
            $lesson->endDate = $request['endDate'] ?? null;
            $lesson->duration = $request['duration'] ?? null;
            $lesson->image = $request['image'] ?? $lesson['image'];
            $lesson->idChapter = $request['idChapter'];
            $lesson->idSchool = $chapter->idSchool ?? $lesson->idSchool;
            $lesson->idSection = $chapter->idSection ?? $lesson->idSection;
            $lesson->created_by = auth()->user()->id;
            $lesson->save();

            return new LessonResource($lesson);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Lesson $lesson,$id)
    {
        try {
            $lesson = Lesson::find($id);
            $lesson->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
