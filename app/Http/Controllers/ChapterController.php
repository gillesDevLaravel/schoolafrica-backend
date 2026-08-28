<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Http\Requests\Staffs\ChapterRequest;
use App\Http\Requests\Staffs\ChapterGetAllRequest;
use App\Http\Resources\Staffs\ChapterResource;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Module;
use App\Models\Progression;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Chapter
 */
class ChapterController extends BaseController
{
    /**
     * Afficher la liste des chapitres
     *
     * @param ChapterGetAllRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(ChapterGetAllRequest $request)
    {
        try {
            $chapter  = $request->validated();
            $idModule = $request['idModule'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idProgression = $request['idProgression'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $filter_value = $request['filter_value'];

            $chapters  = Chapter::query();
            //   $chapters = Chapter::where('chapters.idSchool', $chapter['idSchool']);

            // filtre par idClasse (progression → module → chapter)
            $chapters = $chapters 
                ->when($request->idClasse, function ($query) use ($request) {
                     return $query->whereHas('module.progression', function ($q) use ($request) {
                        $q->where('idClasse', $request->idClasse);
                    });
                })
                 //  Filtrer par idTeacher (module → chapter)
                ->when($request->idTeacher, function ($query) use ($request) {
                    return $query->whereHas('module', function ($q) use ($request) {
                        $q->where('idTeacher', $request->idTeacher);
                    });
                });

            if($idSection != null) $chapters = $chapters->where('chapters.idSection',$request['idSection']);
            if($idModule != null) $chapters = $chapters->where('chapters.idModule',$request['idModule']);

            if($idProgression != null){
                $chapters = $chapters->select('chapters.id as id','chapters.name as name','chapters.description as description','chapters.nbrLessons as nbrLessons','chapters.startDate as startDate','chapters.endDate as endDate','chapters.duration as duration','chapters.image as image','chapters.status as status','chapters.observation as observation','chapters.idSchool as idSchool','chapters.idSection as idSection','chapters.idModule as idModule', 'progressions.name as progression_name')
                    ->join('modules', 'chapters.idModule', '=', 'modules.id')
                    ->join('progressions', 'modules.idProgression', '=', 'progressions.id')
                    ->where('progressions.id', $request['idProgression']);
            }

            if(!is_null($filter_value)){
                $chapters->where(function($query) use ($filter_value) {
                    $query
                        ->where('chapters.name', 'like', "%$filter_value%")
                        ->orWhere('chapters.startDate', 'like', "%$filter_value%")
                        ->orWhere('chapters.endDate', 'like', "%$filter_value%")
                        ->orwhereHas('module', function($q) use ($filter_value) {
                            $q->where('modules.name', 'like', "%$filter_value%");
                        });
                });
            }

//            if($idModule != null){
//                return ChapterResource::collection(
//                    Chapter::where('idSchool',$chapter['idSchool'])
//                            ->where('idSection',$chapter['idSection'])
//                            ->where('idModule',$request['idModule'])
//                            ->orderBy("id", "asc")
//                            ->paginate($nbreItems, ['*'], 'page', $pageItems)
//                );
//            }elseif ($idProgression != null){
//                return ChapterResource::collection(
//                    Chapter::select('chapters.id as id','chapters.name as name','chapters.description as description','chapters.nbrLessons as nbrLessons','chapters.startDate as startDate','chapters.endDate as endDate','chapters.duration as duration','chapters.image as image','chapters.status as status','chapters.observation as observation','chapters.idSchool as idSchool','chapters.idSection as idSection','chapters.idModule as idModule')
//                            ->join('modules', 'chapters.idModule', '=', 'modules.id')
//                            ->join('progressions', 'modules.idProgression', '=', 'progressions.id')
//                            ->where('chapters.idSchool', $chapter['idSchool'])
//                            ->where('chapters.idSection', $chapter['idSection'])
//                            ->where('progressions.id', $request['idProgression'])
//                            ->orderBy("chapters.id", "asc")
//                            ->paginate($nbreItems, ['*'], 'page', $pageItems)
//                );
//            }else{
//                return ChapterResource::collection(
//                    Chapter::where('idSchool',$chapter['idSchool'])
//                            ->where('idSection',$chapter['idSection'])
//                            ->orderBy("id", "asc")
//                            ->paginate($nbreItems, ['*'], 'page', $pageItems)
//                );
//            }

            return ChapterResource::collection(
                $chapters
                    ->orderBy("id", "asc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );


        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un chapitre
     *
     * @param ChapterRequest $request
     * @return ChapterResource|Response
     */
    public function store(ChapterRequest $request)
    {
        try {
            $chapter = $request->validated();

            $module = Module::find($request->idModule);

            $chapter = new Chapter();

            $chapter->name = $request['name'];
            $chapter->description = $request['description'];
            $chapter->nbrLessons = $request['nbrLessons'] ?? null;
            $chapter->status = $request['status'] ?? null;
            $chapter->observation = $request['observation'] ?? null;
            $chapter->startDate = $request['startDate'] ?? null;
            $chapter->endDate = $request['endDate'] ?? null;
            $chapter->duration = $request['duration'] ?? null;
            $chapter->image = $request['image'] ?? null;
            $chapter->idModule = $request['idModule'];
            $chapter->idSchool = $module->idSchool;
            $chapter->idSection = $module->idSection;
            $chapter->created_by = auth()->user()->id;
            $chapter->save();

            return new ChapterResource($chapter);
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
    public function show(Chapter $chapter,$id)
    {
        try {
            $chapter = Chapter::find($id);
            return new ChapterResource($chapter);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ChapterRequest $request, Chapter $chapter,$id)
    {
        try {
            $module = Module::find($request->idModule);

            $chapter = Chapter::find($id);
            $chapter->name = $request['name'];
            $chapter->description = $request['description'];
            $chapter->nbrLessons = $request['nbrLessons'] ?? null;
            $chapter->status = $request['status'] ?? null;
            $chapter->observation = $request['observation'] ?? $chapter['observation'];
            $chapter->startDate = $request['startDate'] ?? null;
            $chapter->endDate = $request['endDate'] ?? null;
            $chapter->duration = $request['duration'] ?? null;
            $chapter->image = $request['image'] ?? $chapter['image'];
            $chapter->idModule = $request['idModule'];
            $chapter->idSchool = $module->idSchool ?? $chapter->idSchool;
            $chapter->idSection = $module->idSection ?? $chapter->idSection;
            $chapter->updated_by = auth()->user()->id;
            $chapter->save();

            $nbrchapter = Chapter::where('idModule',$chapter['idModule'])
                                    ->count();

            $nbrchapterfinish = Chapter::where('idModule',$chapter['idModule'])
                                        ->where('status','finish')
                                        ->count();

            if($nbrchapterfinish == $nbrchapter){
                $module = Module::find($chapter['idModule']);
                $module->status = 'finish';
                $module->save();

                $moduleProgressionAll = Module::where('idProgression',$module['idProgression'])
                                                ->count();

                $moduleProgressionFinish = Module::where('idProgression',$module['idProgression'])
                                                ->where('status','finish')
                                                ->count();

                if($moduleProgressionFinish == $moduleProgressionAll){
                    $progression = Progression::where('idModule',$module['id'])->get();
                    $progression->status = 'finish';
                    $progression->save();
                }


            }

            return new ChapterResource($chapter);
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
    public function destroy(Chapter $chapter,$id)
    {
        try {
            $chapter = Chapter::find($id);
            $chapter->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
