<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\Progression;
use App\Http\Requests\Progression\ProgressionArchiveRequest;
use App\Http\Requests\Staffs\ProgressionRequest;
use App\Http\Requests\Staffs\ProgressionGetAllRequest;
use App\Http\Resources\Staffs\ProgressionResource;
use App\Http\Resources\Staffs\ProgressionCahierTexteRessource;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\CahierTestRequest;
use App\Http\Requests\Staffs\TeacherMatterRequest;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\Matter;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @group Progression
 */
class ProgressionController extends BaseController
{
    /**
     * Liste des progressions
     *
     * @param ProgressionGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(ProgressionGetAllRequest $request)
    {
        try {
            $progression  = $request->validated();
            $idClasse = $request['idClasse'] ?? null;
            $idSection = $request['idSection'] ?? null;

            $progressions = Progression::select('progressions.id as id','progressions.name as name','progressions.description as description','progressions.nbrModules as nbrModules','progressions.status as status','progressions.idClasse as idClasse','progressions.idSchool as idSchool','progressions.idSection as idSection','progressions.created_by as created_by','progressions.updated_by as updated_by','progressions.created_at as created_at','progressions.updated_at as updated_at')
                ->where('progressions.idSchool',$progression['idSchool']);

            if(!is_null($idSection)) $progressions = $progressions->where('progressions.idSection',$progression['idSection']);

            if(!is_null($idClasse)){
                $progressions = $progressions->join('progressions_has_classes','progressions_has_classes.progression_id','=','progressions.id')
                    ->where('progressions_has_classes.classes_id',$request['idClasse']);
            }

            return ProgressionResource::collection(
                $progressions->orderBy("progressions.id", "desc")->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter une progression
     *
     * @param ProgressionRequest $request
     * @return ProgressionResource|\Illuminate\Http\Response
     */
    public function store(ProgressionRequest $request)
    {
        try {
            $progression = $request->validated();

            $classe = Classes::find($request['idClasse']);

            $progression = new Progression();

            $progression->name = $request['name'];
            $progression->description = $request['description'];
            $progression->nbrModules = $request['nbrModules'] ?? null;
            $progression->status = $request['status'] ?? null;
            $progression->idClasse = $request['idClasse'];
            $progression->idSchool = $classe->idSchool;
            $progression->idSection = $classe->idSection;
            $progression->created_by = auth()->user()->id;
            $progression->save();

            if(!empty($request['classes'])){
                $progression->classes()->sync($request['classes']);
            }

            return new ProgressionResource($progression);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'une progression
     *
     * @param Progression $progression
     * @param $id
     * @return ProgressionResource|\Illuminate\Http\Response
     */
    public function show(Progression $progression,$id)
    {
        try {
            $progression = Progression::find($id);
            return new ProgressionResource($progression);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une progression
     *
     * @param ProgressionRequest $request
     * @param Progression $progression
     * @param $id
     * @return ProgressionResource|\Illuminate\Http\Response
     */
    public function update(ProgressionRequest $request, Progression $progression,$id)
    {
        try {
            $classe = Classes::find($request['idClasse']);

            $progression = Progression::find($id);
            $progression->name = $request['name'] ?? $progression['name'];
            $progression->description = $request['description'] ?? $progression['description'];
            $progression->nbrModules = $request['nbrModules'] ?? $progression['nbrModules'];
            $progression->status = $request['status'] ?? $progression['status'];
            $progression->idClasse = $request['idClasse'] ?? $progression['idClasse'];
            $progression->idSchool = $classe->idSchool ?? $progression['idSchool'];
            $progression->idSection = $classe->idSection ?? $progression['idSection'];
            $progression->created_by = auth()->user()->id;
            $progression->save();

            if(!empty($request['classes'])){
                $progression->classes()->sync($request['classes']);
            }

            return new ProgressionResource($progression);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une progression
     *
     * @param Progression $progression
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Progression $progression,$id)
    {
        try {
            $progression = Progression::find($id);
            $progression->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function getcahiertexte(Request $request)
    {
        try {

            $idClasse = $request['idClasse'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $tabCahier = array();
            if($idSchool != null && $idSection != null && $idClasse != null && $idTeacher != null){
                $progression = ProgressionCahierTexteRessource::collection(Progression::select('progressions.id as id','progressions.name as name','progressions.description as description','progressions.nbrModules as nbrModules','progressions.status as status','progressions.idClasse as idClasse','progressions.idSchool as idSchool','progressions.idSection as idSection','progressions.created_by as created_by','progressions.updated_by as updated_by','progressions.created_at as created_at','progressions.updated_at as updated_at')
                                            ->join('progressions_has_classes','progressions_has_classes.progression_id','=','progressions.id')
                                            ->where('progressions.idSchool',$request['idSchool'])
                                            ->where('progressions.idSection',$request['idSection'])
                                            ->where('progressions_has_classes.classes_id',$request['idClasse'])->get());


                $tabCahier['progression'] = $progression;

                $module = Module::where('idSchool',$request['idSchool'])
                                        ->where('idSection',$request['idSection'])
                                        ->where('idProgression',$progression[0]['id'])
                                        ->where('idTeacher',$request['idTeacher'])->get();

                $tabCahier['module'] = $module;

                for ($i=0; $i < $module->count(); $i++) {
                    $chapter = Chapter::where('idSchool',$request['idSchool'])
                                                    ->where('idSection',$request['idSection'])
                                                    ->where('idModule',$module[$i]['id'])->get();

                    $tabCahier['module'][$i]['chapitres'] = $chapter;

                    for($j=0; $j < $chapter->count(); $j++){
                        $lesson = Lesson::where('idSchool',$request['idSchool'])
                                            ->where('idSection',$request['idSection'])
                                            ->where('idChapter',$chapter[$j]['id'])->get();

                        $tabCahier['module'][$i]['chapitres'][$j]['lessons'] = $lesson;
                    }
                }

                return $this->sendResponse($tabCahier, 'Cahier texte');
            }
            elseif($idSchool != null && $idSection != null && $idClasse != null){
                $progression = ProgressionCahierTexteRessource::collection(Progression::select('progressions.id as id','progressions.name as name','progressions.description as description','progressions.nbrModules as nbrModules','progressions.status as status','progressions.idClasse as idClasse','progressions.idSchool as idSchool','progressions.idSection as idSection','progressions.created_by as created_by','progressions.updated_by as updated_by','progressions.created_at as created_at','progressions.updated_at as updated_at')
                                            ->join('progressions_has_classes','progressions_has_classes.progression_id','=','progressions.id')
                                            ->where('progressions.idSchool',$request['idSchool'])
                                            ->where('progressions.idSection',$request['idSection'])
                                            ->where('progressions_has_classes.classes_id',$request['idClasse'])->get());

                $tabCahier['progression'] = $progression->toArray($request);

                foreach ($progression as $z => $progressionItem) {
                    $module = Module::where('idSchool', $request['idSchool'])
                                    ->where('idSection', $request['idSection'])
                                    ->where('idProgression', $progressionItem['id'])
                                    ->get();

                    $tabCahier['progression'][$z]['modules'] = $module->toArray();

                    foreach ($module as $i => $moduleItem) {
                        $chapter = Chapter::where('idSchool', $request['idSchool'])
                                          ->where('idSection', $request['idSection'])
                                          ->where('idModule', $moduleItem['id'])
                                          ->get();

                        $tabCahier['progression'][$z]['modules'][$i]['chapitres'] = $chapter->toArray();

                        foreach ($chapter as $j => $chapterItem) {
                            $lesson = Lesson::where('idSchool', $request['idSchool'])
                                            ->where('idSection', $request['idSection'])
                                            ->where('idChapter', $chapterItem['id'])
                                            ->get();

                            $tabCahier['progression'][$z]['modules'][$i]['chapitres'][$j]['lessons'] = $lesson->toArray();
                        }
                    }
                }

                return $this->sendResponse($tabCahier, 'Cahier texte');
            }
            elseif($idSchool != null && $idSection != null){
                $progression = ProgressionCahierTexteRessource::collection(Progression::select('progressions.id as id','progressions.name as name','progressions.description as description','progressions.nbrModules as nbrModules','progressions.status as status','progressions.idClasse as idClasse','progressions.idSchool as idSchool','progressions.idSection as idSection','progressions.created_by as created_by','progressions.updated_by as updated_by','progressions.created_at as created_at','progressions.updated_at as updated_at')
                                            //->join('progressions_has_classes','progressions_has_classes.progression_id','=','progressions.id')
                                            ->where('progressions.idSchool',$request['idSchool'])
                                            ->where('progressions.idSection',$request['idSection'])->get());

                $tabCahier['progression'] = $progression->toArray($request);

                foreach ($progression as $z => $progressionItem) {
                    $module = Module::where('idSchool', $request['idSchool'])
                                    ->where('idSection', $request['idSection'])
                                    ->where('idProgression', $progressionItem['id'])
                                    ->get();

                    $tabCahier['progression'][$z]['modules'] = $module->toArray();

                    foreach ($module as $i => $moduleItem) {
                        $chapter = Chapter::where('idSchool', $request['idSchool'])
                                          ->where('idSection', $request['idSection'])
                                          ->where('idModule', $moduleItem['id'])
                                          ->get();

                        $tabCahier['progression'][$z]['modules'][$i]['chapitres'] = $chapter->toArray();

                        foreach ($chapter as $j => $chapterItem) {
                            $lesson = Lesson::where('idSchool', $request['idSchool'])
                                            ->where('idSection', $request['idSection'])
                                            ->where('idChapter', $chapterItem['id'])
                                            ->get();

                            $tabCahier['progression'][$z]['modules'][$i]['chapitres'][$j]['lessons'] = $lesson->toArray();
                        }
                    }
                }

                return $this->sendResponse($tabCahier, 'Cahier texte');
            }


        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    public function getmatterteacher(TeacherMatterRequest $request)
    {
        try {

            $request = $request->validated();
            $progression = Progression::where('idSchool',$request['idSchool'])
                                        ->where('idSection',$request['idSection'])
                                        ->where('idClasse',$request['idClasse'])->get();

            $matter = Matter::select('matter.id as id','matter.name as name')
                            ->join('modules','modules.idMatter','=','matter.id')
                            ->where('modules.idProgression',@$progression[0]['id'])
                            ->where('modules.idTeacher',$request['idTeacher'])
                            ->where('matter.idSchool',$request['idSchool'])
                            ->where('matter.idSection',$request['idSection'])
                            ->get();

            return $this->sendResponse($matter, 'MatterTeacher');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }



    public function duplicateProgression(Request $request)
    {
        if(!$request['idProgression']){
            return $this->sendError("idProgression est obligatoire");
        }

        DB::beginTransaction();

        try {
            $originalProgression = Progression::find($request['idProgression']);

            $newProgression = $originalProgression->replicate();
            $newProgression->name = 'Copie de ' . $originalProgression->name;
            $newProgression->save();

            $originalModules = Module::where('idProgression', $originalProgression->id)->get();

            if ($originalModules->isNotEmpty()) {
                foreach ($originalModules as $originalModule) {
                    $newModule = $originalModule->replicate();
                    $newModule->idProgression = $newProgression->id;
                    $newModule->save();

                    $originalChapters = Chapter::where('idModule', $originalModule->id)->get();

                    if ($originalChapters->isNotEmpty()) {
                        foreach ($originalChapters as $originalChapter) {
                            $newChapter = $originalChapter->replicate();
                            $newChapter->idModule = $newModule->id;
                            $newChapter->save();

                            $originalLessons = Lesson::where('idChapter', $originalChapter->id)->get();

                            if ($originalLessons->isNotEmpty()) {
                                foreach ($originalLessons as $originalLesson) {
                                    $newLesson = $originalLesson->replicate();
                                    $newLesson->idChapter = $newChapter->id;
                                    $newLesson->save();
                                }
                            }
                        }
                    }
                }
            }

            $newProgression->classes()->sync($originalProgression->classes->pluck('id'));

            DB::commit();

            return new ProgressionResource($newProgression);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError("Une erreur est survenue lors de la duplication de la progression : " . $th->getMessage());
        }
    }

    /**
     * Met des progressions à la corbeille (soft delete).
     *
     * @param  ProgressionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(ProgressionArchiveRequest $request): JsonResponse
    {
        try {
            Progression::whereIn('id', $request->ids)->delete();
            Log::info('Progressions mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des progressions : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des progressions supprimées (soft delete).
     *
     * @param  ProgressionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(ProgressionArchiveRequest $request): JsonResponse
    {
        try {
            Progression::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Progressions restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des progressions : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des progressions (hard delete).
     *
     * @param  ProgressionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(ProgressionArchiveRequest $request): JsonResponse
    {
        try {
            Progression::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Progressions supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des progressions : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
