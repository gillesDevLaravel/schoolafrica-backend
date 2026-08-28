<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ClassesGetAllRequest;
use App\Http\Requests\Admin\ClassesStatisticsRequest;
use App\Http\Requests\Classes\ClassesArchiveRequest;
use App\Models\Level;
use App\Models\User;
use App\Traits\ManageDirectoryTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\ClassesResource;
use App\Http\Requests\Admin\ClassesRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Classes;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @group Classe
 */
class ClassesController extends BaseController
{
    use ManageDirectoryTrait;

    /**
     * Afficher la liste des classes
     * @param ClassesGetAllRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ClassesGetAllRequest $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idTeacher = $request['idTeacher'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $classes = Classes::query();

            if(!is_null($idSchool)) $classes = $classes->where('classes.idSchool',$request['idSchool']);

            if(!is_null($idSection)) $classes = $classes->where('classes.idSection',$request['idSection']);

            if(!is_null($idLevel)) $classes = $classes->where('idLevel', $idLevel);

            if(!is_null($idOptionLevel)) $classes = $classes->where('idOptionLevel', $idOptionLevel);

            if(!is_null($idTeacher)){
                $classes = $classes->select('classes.id as id','classes.name as name','classes.description as description','classes.idSection as idSection',
                    'classes.idLevel as idLevel','classes.idOptionLevel as idOptionLevel','classes.idSchool as idSchool','classes.idTeacher as idTeacher')
                    ->join('classe_has_user','classes.id','=','classe_has_user.classes_id')
                    ->where('classe_has_user.user_id',$request['idTeacher']);
            }

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $classes->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('description', 'like', "%$filter_value%");
                });
            }

            return ClassesResource::collection(
                $classes
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter une classe
     *
     * @param ClassesRequest $request
     * @return JsonResponse
     */
    public function store(ClassesRequest $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->classes as $classes) {
                $level = Level::find($classes['idLevel']);

                $photo = null;

                if(isset($classes['photo']) && !is_null($classes['photo'])){
                    // TODO: importer la photo ici
                    $file = $classes['photo'];
                    $this->createDirectory('public/profil/classes'); // On crée le dossier si il n'existe pas
                    $uploadPath = "public/profil/classes";
                    $originalImage = Str::uuid().".".$file->getClientOriginalExtension();

                    $file->move($uploadPath,$originalImage);

                    $photo = $originalImage;
                }
                $cl = Classes::create([
                    'name' => $classes['name'],
                    'idTeacher' => $classes['idTeacher'] ?? null,
                    'idLevel' => $classes['idLevel'],
                    'idOptionLevel' => $classes['idOptionLevel'] ?? null,
                    'description' => $classes['description'] ?? null,
                    'style' => $classes['style'] ?? null,
                    'photo' => $photo,
                    'idSchool' => $level->idSchool, // on prend l'info du parent qui est le 'level'
                    'idSection' => $level->idSection, // on prend l'info du parent qui est le 'level'
                    'created_by' => auth()->user()->id
                ]);

                if (!empty($classes['nextClasses'])){
                    $cl->nextClasses()->sync($classes['nextClasses']);
                }

                if(!empty($classes['users'])){
                    $cl->users()->sync($classes['users']);
                }
            }

            DB::commit();

            return $this->sendResponse([], "Classes créées avec succès.");
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'une classe
     * @param Classes $classes
     * @param $id
     * @return ClassesResource|JsonResponse
     */
    public function show(Classes $classes,$id)
    {
        try {
            $classes = Classes::find($id);
            return new ClassesResource($classes);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Maj des infos d'une classe
     * @param Request $request
     * @param $id
     * @return ClassesResource|JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $classe = Classes::findOrFail($id);

            $classe->name = $request['name'] ?? $classe['name'];
            $classe->idTeacher = $request['idTeacher'] ?? $classe['idTeacher'];
            $classe->idLevel = $request['idLevel'] ?? $classe['idLevel'];
            $classe->idOptionLevel = $request['idOptionLevel'] ?? $classe['idOptionLevel'];
            $classe->description = $request['description'] ?? $classe['description'];
            $classe->style = $request['style'] ?? $classe['style'];

            // Toujours propager idSchool et idSection depuis le Level lié
            $effectiveLevelId = $classe->idLevel;
            $level = Level::findOrFail($effectiveLevelId);
            $classe->idSchool = $level->idSchool; // on prend l'info du parent qui est le 'level'
            $classe->idSection = $level->idSection; // on prend l'info du parent qui est le 'level'

            $classe->updated_by = auth()->user()->id;

            $classe->save();

            if (!empty($request['nextClasses'])){
                $classe->nextClasses()->sync($request['nextClasses']);
            }

            if(!empty($request['users'])){
                $classe->users()->sync($request['users']);
            }

            DB::commit();
            return new ClassesResource($classe);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une classe
     *
     * @param Classes $classes
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Classes $classes,$id)
    {
        try {
            $classes = Classes::findOrFail($id);
//            $classes->delete();
            $classes->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id,
            ]);

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des classes à la corbeille (soft delete).
     *
     * @param  ClassesArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(ClassesArchiveRequest $request): JsonResponse
    {
        try {
            
            Classes::whereIn('id', $request->ids)->delete();
            Log::info('Classes mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des classes supprimées (soft delete).
     *
     * @param  ClassesArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(ClassesArchiveRequest $request): JsonResponse
    {
        try {
            Classes::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Classes restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des classes (hard delete).
     *
     * @param  ClassesArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(ClassesArchiveRequest $request): JsonResponse
    {
        try {
            Classes::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Classes supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

/**
 * Statistiques par niveau et classe avec nombre de filles et garçons.
 *
 * Retourne, pour une école donnée, la liste des niveaux avec leurs classes
 * ainsi que le nombre total de filles et de garçons par classe.
 *
 * @group Stistique Classe
 *
 * @bodyParam idSchool integer required ID de l'école. Example: 3
 *
 * @response 200 {
 *   "success": true,
 *   "data": [
 *     {
 *       "niveau": {
 *         "id": 1,
 *         "name": "Sixième"
 *       },
 *       "classes": [
 *         {
 *           "id": 5,
 *           "classe": "Sixième A",
 *           "girls_count": 12,
 *           "boys_count": 15
 *         }
 *       ]
 *     }
 *   ],
 *   "message": "Statistiques récupérées avec succès"
 * }
 *
 * @response 404 {
 *   "success": false,
 *   "message": "École introuvable"
 * }
 *
 * @response 500 {
 *   "success": false,
 *   "message": "Une erreur est survenue"
 * }
 */
    public function statisticsByClass(ClassesStatisticsRequest $request)
    {
        try {
            $idSchool = $request->idSchool;

            // Récupérer les niveaux de l'école
            $levels = Level::where('idSchool', $idSchool)->get();

            // Formater les données
            $statistics = $levels->map(function($level) use ($idSchool) {
                // Récupérer les classes du niveau
                $classes = Classes::where('idLevel', $level->id)->get();
                
                return [
                    'niveau' => [
                        'id' => $level->id,
                        'name' => $level->name
                    ],
                    'classes' => $classes->map(function($class) use ($idSchool) {
                        // Compter les filles dans la classe
                        $girls_count = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('roles.id', 8)
                            ->where('users.idSchool', $idSchool)
                            ->where('users.idClasse', $class->id)
                            ->where('users.gender', 'Female')
                            ->where('users.deleted', 0)
                            ->count();

                        // Compter les garçons dans la classe
                        $boys_count = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->where('roles.id', 8)
                            ->where('users.idSchool', $idSchool)
                            ->where('users.idClasse', $class->id)
                            ->where('users.gender', 'Male')
                            ->where('users.deleted', 0)
                            ->count();

                        return [
                            'id' => $class->id,
                            'classe' => $class->name,
                            'girls_count' => $girls_count,
                            'boys_count' => $boys_count
                        ];
                    })
                ];
            });

            return $this->sendResponse($statistics, 'Statistiques récupérées avec succès');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
//    /**
//     * Changer la classe d'un ou plusieurs élèves
//     *
//     * @param SwitchUsersClasseRequest $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function switchUsersClasse(SwitchUsersClasseRequest $request)
//    {
//        try {
//            DB::beginTransaction();
//
//            foreach ($request->idUsers as $idUser){
//                $user = User::select('id', 'name', 'idClasse')->find($idUser);
//
//                $user->idClasse = $request->idClasse;
//                $user->save();
//
//                Log::critical("idClasse d'un élève changé. idUser:$idUser --- old idClasse:{$user->idClasse} --- new idClasse:{$user->idClasse}");
//            }
//
//            DB::commit();
//
//            return $this->sendResponse([], "Classe changée");
//        } catch (\Throwable $th) {
//            DB::rollBack();
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//        }
//    }
}
