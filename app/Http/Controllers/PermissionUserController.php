<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionUserFindRequest;
use App\Http\Requests\Staffs\PermissionUserRequest;
use App\Http\Requests\Staffs\PermissionUserUpdateRequest;
use App\Http\Resources\Staffs\PermissionUserResource;
use App\Models\Notification;
use App\Models\PermissionUser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group PermissionsUser
 */
class PermissionUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(PermissionUserFindRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 10000);
            $requete = PermissionUser::query();

            // Appliquer le filtrage sur la corbeille
            if ($request->filled('trashed')) {
                if ($request->trashed === 'withTrashed') {
                    $requete->withTrashed();
                } elseif ($request->trashed === 'onlyTrashed') {
                    $requete->onlyTrashed();
                }
            }

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $requete->where(function ($query) use ($request) {
                    $query->where('raison', 'like', '%' . $request->filter_value . '%')
                        ->orWhereHas('user', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->filter_value . '%');
                        });
                });
            }


            // Filtrage par statut (accord/refus)
            if ($request->filled('status')) {
                $requete->where('statut', $request->status);
            }

            // Filtrage par idUser
            if ($request->filled('idUser')) {
                $requete->where('idUser', $request->idUser);
            }

            // Filtrage par idUserApprove
            if ($request->filled('idUserApprove')) {
                $requete->where('idUserApprove', $request->idUserApprove);
            }

            // Filtrage par plage de dates (start_date et end_date sur le champ depart)
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $requete->whereBetween('depart', [$request->start_date, $request->end_date]);
            } elseif ($request->filled('start_date')) {
                $requete->whereDate('depart', '>=', $request->start_date);
            } elseif ($request->filled('end_date')) {
                $requete->whereDate('depart', '<=', $request->end_date);
            }

            // Filtrage par date de départ et de retour
            if ($request->filled('dateDepart')) {
                $requete->whereDate('depart', '=', $request->dateDepart);
            }

            if ($request->filled('dateRetour')) {
                $requete->whereDate('retour', '=', $request->dateRetour);
            }


            if ($request->filled('duration')) {
                $requete->where('duration', $request->duration);
            }

            // Filtrage par durée (si des valeurs sont présentes)
//            if ($request->filled('duree')) {
//                $resultats = [];
//
//                foreach ($requete->get() as $element) {
//                    // Calcul de la durée en minutes
//                    $duree = Carbon::parse($element->depart)->diff(Carbon::parse($element->retour));
//                    $dureeMinutes =
//                        ($duree->y * 365 * 24 * 60) +  // Années en minutes
//                        ($duree->m * 30 * 24 * 60) +   // Mois en minutes (approx.)
//                        ($duree->d * 24 * 60) +        // Jours en minutes
//                        ($duree->h * 60) +             // Heures en minutes
//                        ($duree->i);                   // Minutes
//
//                    // Conversion des valeurs de la requête en minutes
//                    $dureeRequeteMinutes = 0;
//
//                    if (!empty($request->duree['annee'])) {
//                        $dureeRequeteMinutes += intval($request->duree['annee']) * 365 * 24 * 60;
//                    }
//                    if (!empty($request->duree['mois'])) {
//                        $dureeRequeteMinutes += intval($request->duree['mois']) * 30 * 24 * 60;
//                    }
//                    if (!empty($request->duree['jour'])) {
//                        $dureeRequeteMinutes += intval($request->duree['jour']) * 24 * 60;
//                    }
//                    if (!empty($request->duree['heure'])) {
//                        $dureeRequeteMinutes += intval($request->duree['heure']) * 60;
//                    }
//                    if (!empty($request->duree['minute'])) {
//                        $dureeRequeteMinutes += intval($request->duree['minute']);
//                    }
//
//
//                    // Vérification de l'égalité
//                    if ($dureeMinutes === $dureeRequeteMinutes) {
//                        $resultats[] = $element->id;
//                    }
//                }
//
//                // Appliquer le filtre à la requête
//                $requete = $requete->whereIn('id', $resultats);
//            }

            // Comptage des permissions par statut
            $requetesall = clone $requete;
            $requetes = $requetesall->get();
            $stats = [
                'total' => $requetes->count(),
                'approved' => $requetes->where('statut', 'approved')->count(),
                'rejected' => $requetes->where('statut', 'rejected')->count(),
                'in_progress' => $requetes->where('statut', 'in_progress')->count(),
                'pending' => $requetes->where('statut', 'pending_approval')->count(),
            ];

            // Tri par ordre décroissant d'ID
            $permissions = $requete->orderBy('id', 'desc')->paginate($nbreItems, ['*'], 'page', $pageItems);

            return PermissionUserResource::collection($permissions)->additional(['stats' => $stats]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionUserRequest $request
     * @return JsonResponse
     */
    public function store(PermissionUserRequest $request)
    {
        try {
            // Création de la permission
            $permission = PermissionUser::create([
                'raison' => $request["raison"],
                'depart' => $request["dateDepart"],
                'retour' => $request["dateRetour"] ?? null,
                'duration' => $request["duration"] ?? null,
                'statut' => (!is_null($request["status"] ?? null))
                    ? $request["status"] : "pending_approval",
                'idUserApprove' => $request["idUserApprove"],
                'idUser' => $request["idUser"] ?? auth()->user()->id,
                'comments' => $request["comments"] ?? null,
                'updated_by' => null,
            ]);

            if((is_null($request["statut"] ?? null))){
                Notification::create([
                    'notificationable_type' => PermissionUser::class,
                    'notificationable_id' => $permission->id,
                    'title' => __('notifs.permission_user_request'),
                    'description' => $permission->name . " : " . $permission->raison,
                    'user_id' => $request["idUserApprove"],
                    'grouped_users' => null
                ]);
            }else{
                Notification::create([
                    'notificationable_type' => PermissionUser::class,
                    'notificationable_id' => $permission->id,
                    'title' => __('notifs.permission_user_response'),
                    'description' => $permission->name . " : " . $permission->statut,
                    'user_id' => auth()->id(),
                    'grouped_users' => null
                ]);
            }

            return $this->sendResponse(new PermissionUserResource($permission), __("permission_users.create.success"));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PermissionUserResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $permission = PermissionUser::findOrFail($id);
            return new PermissionUserResource($permission);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUserUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PermissionUserUpdateRequest $request, $id): JsonResponse
    {
        try {
            $permission = PermissionUser::findOrFail($id);

            if ($permission["statut"] != "pending_approval"){
                return $this->sendError(__("permission_users.update.permission_locked"));
            }

//            if(!in_array($this->getRole()->id, [1, 2, $permission["idUser"]])){
//                return $this->sendError("Vous n'êtes pas autorisé a modifier cette permission");
//            }
            $permission->update([
                'raison' => $request->raison?? $permission["raison"],
                'depart' => $request->dateDepart?? $permission["depart"],
                'retour' => $request->dateRetour?? $permission["retour"],
                'duration' => $request->duration?? $permission["duration"],
                'statut' => (!is_null($request["status"] ?? null))
                    ? $request["status"] : $permission["statut"],
                'idUserApprove' => $request["idUserApprove"],
                'comments' => $request->comments ?? $permission["comments"],
                'updated_by' => auth()->user()->id,
            ]);

            if((!is_null($request["statut"] ?? null))){
                Notification::create([
                    'notificationable_type' => PermissionUser::class,
                    'notificationable_id' => $permission->id,
                    'title' => __('notifs.permission_user_response'),
                    'description' => $permission->name . " : " . $permission->statut,
                    'user_id' => $request["idUserApprove"],
                    'grouped_users' => null
                ]);
            }

            return $this->sendResponse(
                new PermissionUserResource($permission),
                __("permission_users.update.success")
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Soft delete the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function trash($id)
    {
        try {
            // Trouver la permission, incluant les soft deletes
            $permission = PermissionUser::withTrashed()->findOrFail($id);

//            if(!in_array($this->getRole()->id, [1, 2, $permission["idUser"]])){
//                return $this->sendError("Vous n'êtes pas autorisé à supprimer cette permission");
//            }

            // Vérifier si l'élément a déjà été supprimé (soft delete)
//            if ($permission->trashed()) {
//                return $this->sendError("Cette permission a déjà été supprimée.");
//            }


            // Effectuer le soft delete
            $permission->delete();
            $permission->update([
                'deleted_by' => auth()->user()->id,
            ]);

            return $this->sendResponse(
                null,
                __("permission_users.trash.success")
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }



    /**
     * Restore the specified soft deleted resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function restore($id)
    {
        try {
            $permission = PermissionUser::withTrashed()->findOrFail($id);
            $permission->restore(); // Restaurer la permission soft supprimée



            return $this->sendResponse(
                null,
                __("permission_users.restore.success")
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            if(in_array(auth()->user()->getRole()->id, [1, 2])){
                $permission = PermissionUser::onlyTrashed()->find($id);

                if (!$permission) {
                    return $this->sendError("Permission non trouvée dans la corbeille.");

                }

                $permission->forceDelete(); // Suppression définitive

                return $this->sendResponse(
                    null,
                    __("permission_users.destroy.success")
                );
            }else{
                return $this->sendError("Vous n'êtes pas autorisé à effectuer cette action");
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

}
