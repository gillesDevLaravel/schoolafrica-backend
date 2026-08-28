<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\SanctionGetRequest;
use App\Http\Requests\Staffs\SanctionRequest;
use App\Http\Requests\Sanction\SanctionArchiveRequest;
use App\Http\Resources\Staffs\SanctionResource;
use App\Models\Notification;
use App\Models\Sanction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @group Sanction
 */
class SanctionController extends BaseController
{
    /**
     * Listing des sanctions
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(SanctionGetRequest $request)
    {
        try {
            $idClasse = $request['idClasse'] ?? null;
            $date     = $request['date'] ?? null;
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idUser = $request['idUser'] ?? null;
            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;
            $type = $request['type'] ?? null;
            $typeUser = $request['typeUser'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $sanctions = Sanction::query();
            //filtre par classe (idClasse)
            if(!is_null($idClasse))
            {
                $studentsIds = User::where('idClasse', $idClasse)->pluck('id');
                $sanctions = $sanctions->whereIn('idUser', $studentsIds);
            }
            //filtre par date
            if (!is_null($date))
            {
                $sanctions = $sanctions->whereDate('created_at', $date);
            }
            if (!is_null($date_start) && !is_null($date_end)) {
            
            $sanctions =$sanctions->whereBetween('created_at', [$date_start, $date_end]);
            } elseif (!is_null($date_start)) {
            
            $sanctions =$sanctions->whereDate('created_at', '>=', $date_start);
            } elseif (!is_null($date_end)) {
           
            $sanctions =$sanctions->whereDate('created_at', '<=', $date_end);
            }

            if(!is_null($idSchool)) $sanctions = $sanctions->where('idSchool', $idSchool);
            if(!is_null($idSection)) $sanctions = $sanctions->where('idSection', $idSection);
            if(!is_null($idUser)) $sanctions = $sanctions->where('idUser', $idUser);
            if(!is_null($type)) $sanctions = $sanctions->where('type', $type);
            if(!is_null($typeUser)) $sanctions = $sanctions->where('typeUser', $typeUser);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $sanctions->where(function($query) use ($filter_value) {
                    $query->where('reasons', 'like', "%$filter_value%")
                        ->orWhere('type', 'like', "%$filter_value%")
                        ->orWhere('typeUser', 'like', "%$filter_value%")
                        ->orWhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return SanctionResource::collection(
                $sanctions
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter une sanction
     *
     * @param SanctionRequest $request
     * @return SanctionResource|\Illuminate\Http\Response
     */
    public function store(SanctionRequest $request)
    {
        try {
            $sanction = $request->validated();

            $student = User::find($request['idUser']);

            $sanction = Sanction::create([
                'type' => $sanction['type'],
                'typeUser' => $sanction['typeUser'],
                'description' => $sanction['description'],
                'reasons' => $sanction['reasons'],
                'idUser' => $request['idUser'],
                'idSchool' => $student->idSchool,
                'idSection' => $student->idSection,
                'created_by' => auth()->user()->id
            ]);

            $author = Auth::user()->name;

            // TODO: Envoyer une notification à l'étudiant et son parent
            Notification::create([
                'notificationable_type' => Sanction::class,
                'notificationable_id' => $sanction->id,
                'title' => __('notifs.sanction_title', ['student_name' => $student->name, 'author' => $author]),
                'description' => $sanction['description'],
                'grouped_users' => json_encode([$request['idUser'], $student->idParent])
            ]);

            return new SanctionResource($sanction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'une sanction
     *
     * @param Sanction $sanction
     * @param $id
     * @return SanctionResource|\Illuminate\Http\Response
     */
    public function show(Sanction $sanction,$id)
    {
        try {
            $sanction = Sanction::find($id);
            return new SanctionResource($sanction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une sanction
     *
     * @param SanctionRequest $request
     * @param Sanction $sanction
     * @param $id
     * @return SanctionResource|\Illuminate\Http\Response
     */
    public function update(SanctionRequest $request,Sanction $sanction, $id)
    {
        try {
            $sanction = Sanction::findOrFail($id);

            $student = User::find($request['idUser']);

            $sanction->type = $request['type'] ?? $sanction->type;
            $sanction->typeUser = $request['typeUser'] ?? $sanction->typeUser;
            $sanction->description = $request['description'] ?? $sanction->description;
            $sanction->reasons = $request['reasons'] ?? $sanction->reasons;
            $sanction->idUser = $request['idUser'] ?? $sanction->idUser;
            $sanction->idSchool = $student->idSchool;
            $sanction->idSection = $student->idSection;
            $sanction->updated_by = auth()->user()->id;

            $sanction->save();
            return new SanctionResource($sanction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une sanction
     *
     * @param Sanction $sanction
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Sanction $sanction,$id)
    {
        try {
            $sanction = Sanction::find($id);
            $sanction->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des sanctions à la corbeille (soft delete).
     *
     * @param  SanctionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(SanctionArchiveRequest $request): JsonResponse
    {
        try {
            Sanction::whereIn('id', $request->ids)->delete();
            Log::info('Sanctions mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des sanctions : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des sanctions supprimées (soft delete).
     *
     * @param  SanctionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(SanctionArchiveRequest $request): JsonResponse
    {
        try {
            Sanction::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Sanctions restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des sanctions : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des sanctions (hard delete).
     *
     * @param  SanctionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(SanctionArchiveRequest $request): JsonResponse
    {
        try {
            Sanction::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Sanctions supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des sanctions : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
