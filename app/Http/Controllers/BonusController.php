<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\Bonus\BonusDestroyRequest;
use App\Http\Requests\Bonus\BonusGetRequest;
use App\Http\Requests\Bonus\BonusRestoreRequest;
use App\Http\Requests\Bonus\BonusStoreRequest;
use App\Http\Requests\Bonus\BonusTrashRequest;
use App\Http\Requests\Bonus\BonusUpdateRequest;
use App\Http\Resources\BonusResource;
use App\Models\Bonus;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BonusController extends BaseController
{
    /**
     * Lister les bonus enregistrés
     *
     * @param BonusGetRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(BonusGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $bonuses = Bonus::query();

            $assessment_filters = [
                'idUser' => $request->idUser,
                'idUserApprove' => $request->idUserApprove,
                'bonus_type' => $request->bonus_type,
                'status' => $request->status,
                'is_used' => (boolean) $request->is_used,
                'deleted' => (boolean) $request->trashed,
            ];
            foreach ($assessment_filters as $column => $value) {
                if (!is_null($value)) {
                    $bonuses->where($column, $value);
                }
            }

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $bonuses->where(function ($bonuses) use ($filter_value) {
                    $bonuses->where('reason', 'like', '%' . $filter_value . '%')
                        ->orWhere('status', 'like', '%' . $filter_value . '%')
                        ->orWhere('bonus_type', 'like', '%' . $filter_value . '%')
                        ->orwhereHas('user', function($bonuses) use ($filter_value) {
                            $bonuses->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('userApprove', function($bonuses) use ($filter_value) {
                            $bonuses->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            $meta = [
                'current_page' => 0,
                'last_page' => 0,
                'to' => 0,
                'total' => 0,
            ];

            $bonuses = $bonuses
                ->orderBy("bonuses.id", "desc")
                ->get();

            if(count($bonuses) != 0){
                $pageItems = $requestData['pageItems'] ?? 1; // page de pagination
                $nbreItems = $requestData['nbreItems'] ?? 1000000; // nbre de résultats de la page

                $bonuses = $bonuses
                    ->toQuery()
                    ->orderBy("bonuses.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems);

                $meta = [
                    'current_page' => $bonuses->currentPage(),
                    'last_page' => $bonuses->lastPage(),
                    'to' => $bonuses->lastItem(),
                    'total' => $bonuses->total(),
                ];
            }

            return [
                'data' => BonusResource::collection($bonuses),
                'meta' => $meta,
                'sommes' => number_format($bonuses->sum('amount'))
            ];
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Afficher les détails d'un bonus
     *
     * @param Bonus $bonus
     * @return BonusResource|\Illuminate\Http\JsonResponse
     */
    public function show(Bonus $bonus)
    {
        try {
            return new BonusResource($bonus);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Enregistrer un ou plusieurs bonus
     *
     * @param BonusStoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(BonusStoreRequest $request)
    {
        try {
            $user = auth()->user();

            $bonuses = array();
            foreach ($request->bonuses as $tmp_bonus) {
                $bonuses[] = $bonus = Bonus::create([
                    'idUser' => $tmp_bonus['idUser'],
                    'idUserApprove' => $tmp_bonus['idUserApprove'],
                    'bonus_type' => $tmp_bonus['bonus_type'],
                    'amount' => $tmp_bonus['amount'],
                    'reason' => $tmp_bonus['reason'],
                    'is_used' => $tmp_bonus['is_used'] ?? false,
                    'created_by' => $user->id,
                ]);

                Log::info(__('bonus.create.success'), ['bonus_id' => $bonus->id, 'author' => $user->id]);
            }

            return BonusResource::collection($bonuses);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier un bonus
     *
     * @param BonusUpdateRequest $request
     * @param Bonus $bonus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BonusUpdateRequest $request, Bonus $bonus)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user(); // Récupère l'utilisateur connecté

            // Empêcher de modifier un bonus déjà approuvé
            if ($bonus->status === StatusEnum::APPROVED) {
                return $this->sendError(__('bonus.update.impossible'), [], 403);
            }

            // Mettre à jour les informations de base
            $bonus->updated_by = $user->id;
            $bonus->amount = $request->amount ?? $bonus->amount;
//            $bonus->idUserApprove = $request->idUserApprove ?? $bonus->idUserApprove;
            $bonus->bonus_type = $request->bonus_type ?? $bonus->bonus_type;
            $bonus->reason = $request->reason ?? $bonus->reason;
            $bonus->is_used = $request->is_used ?? $bonus->is_used;
            $bonus->save(); // fait exprès de mettre ça ici d'abord

            // Vérifier si l'utilisateur tente d'approuver
            if ($request->status === StatusEnum::APPROVED) {
                // Vérifier que l'utilisateur a le droit d'approuver
                if ($user->id !== $bonus->idUserApprove) {
                    Log::critical("Utilisateur non authorisé a essayé d'approuver un bonus sans autorisation adéquate", ['author' => $user->id]);
                    return $this->sendError(__('bonus.update.unauthorized'), [], 403);
                }

                $bonus->status = StatusEnum::APPROVED;

                //TODO: Ajouter une notification pour idUser et son parent (si non null)
                $bonus_approved = true;
            }else{
                //si le statut envoyé n'est pas APPROVED, on le garde quand même mais rien d'autre n'est effectué
                $bonus->status = $request->status ?? $bonus->status;
            }

            // on enregistre les modifications
            $bonus->save();

            DB::commit();

            if(isset($bonus_approved) && $bonus_approved){
                $user = User::select('id','idParent')->where(['id' => $user->id, 'deleted' => 0])->first();

                Notification::create([
                    'notificationable_type' => Bonus::class,
                    'notificationable_id' => $bonus->id,
                    'title' => __('bonus.notif_title'),
                    'description' => __('bonus.notif_description', ['amount' => $bonus->amount]),
                    'user_id' => null,
                    'grouped_users' => json_encode([$user->id, $user->idParent]),
                ]);
            }

            return $this->sendResponse($bonus, __('Le bonus a été mis à jour avec succès.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver un ou plusieurs bonus
     *
     * @param BonusTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash(BonusTrashRequest $request)
    {
        try {
            $author = auth()->user();

            Bonus::whereIn('id', $request->idBonuses)->each(function ($bonus) use ($author) {
                $bonus->update([
                    'deleted' => true,
                    'deleted_by' => $author->id,
                ]);

                Log::critical("Bonus mis en corbeille.", ['bonus' => $bonus->id, 'author' => $author->id]);
            });

            return $this->sendResponse([],  'Bonus mis en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une ou plusieurs bonus
     *
     * @param BonusTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(BonusRestoreRequest $request)
    {
        try {
            $author = auth()->user();

            Bonus::whereIn('id', $request->idBonuses)->each(function ($bonus) use ($author) {
                $bonus->update([
                    'deleted' => false
                ]);

                Log::critical("Bonus restauré.", ['bonus' => $bonus->id, 'author' => $author->id]);
            });

            return $this->sendResponse([],  'Bonus restauré.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un ou plusieurs bonus
     *
     * @param BonusDestroyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BonusDestroyRequest $request)
    {
        try {
            $author = auth()->user();

            Bonus::whereIn('id', $request->idBonuses)->each(function ($bonus) use ($author) {
                Log::critical("Bonus supprimé.", ['bonus' => $bonus->id, 'author' => $author->id]);
                $bonus->delete();
            });

            return $this->sendResponse([],  'Bonus supprimé.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
