<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CashInAllRequest;
use App\Http\Requests\Admin\CashInStoreRequest;
use App\Http\Requests\Admin\CashInUpdateRequest;
use App\Http\Requests\CashIn\CashInArchiveRequest;
use App\Http\Resources\Admin\CashInResource;
use App\Models\CashIn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @group Cash_In
 */
class CashInController extends BaseController
{

    /**
     * Récupérer la liste des encaissements
     *
     * @param CashInAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(CashInAllRequest $request)
    {
        try {
            $filter_value = $request->filter_value;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $cash_ins = CashIn::query();

            // Filtre par client
            if(!is_null($request->idClient)) {
                $cash_ins = $cash_ins->where('idClient', $request->idClient);
            }

            // Filtre par type de recette
            if(!is_null($request->idTypeOfRecipe)) {
                $cash_ins = $cash_ins->where('type_of_recipe_id', $request->idTypeOfRecipe);
            }

            // Filtre par plage de dates
            if(!is_null($request->date_start)) {
                $cash_ins = $cash_ins->whereDate('payment_date', '>=', $request->date_start);
            }
            if(!is_null($request->date_end)) {
                $cash_ins = $cash_ins->whereDate('payment_date', '<=', $request->date_end);
            }

            if(!is_null($request->irpp)) $cash_ins = $cash_ins->where('irpp', $request->irpp);

            if(!is_null($filter_value)){
                $cash_ins->where(function($query) use ($filter_value) {
                    $query->where('payment_method', 'like', "%$filter_value%")
                        ->orWhere('reason', 'like', "%$filter_value%")
                        ->orWhereHas('client', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }
            
            
            $queryForSum = clone $cash_ins;
            $queryForSums = $queryForSum->get();
            // Calcul des sommes par méthode de paiement
            $sums = [
                'om' => $queryForSums->where('payment_method', 'Orange Money')->sum('amount_received'),
                'momo' => $queryForSums->where('payment_method', 'Mobile Money')->sum('amount_received'),
                'cash' => $queryForSums->where('payment_method', 'Cash')->sum('amount_received'),
                'bank' => $queryForSums->where('payment_method', 'Bank')->sum('amount_received'),
                'total' => $queryForSums->sum('amount_received')
            ];
            return CashInResource::collection(
                $cash_ins
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems))
                ->additional(['sums' => $sums]);

        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les informations d'un encaissement
     *
     * @param $idCashIn
     * @return CashInResource|\Illuminate\Http\JsonResponse
     */
    public function show($idCashIn)
    {
        try {
            return CashInResource::make(CashIn::findOrFail($idCashIn));
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer un nouveau encaissement
     *
     * @param CashInStoreRequest $request
     * @return CashInResource|\Illuminate\Http\JsonResponse
     */
    public function store(CashInStoreRequest $request)
    {
        try {
            $cashin = CashIn::create([
                'idClient' => $request->idClient,
                'amount_to_receive' => $request->amount_to_receive,
                'amount_received' => $request->amount_received,
                'reason' => $request->reason,
                'payment_method' => $request->payment_method,
                'irpp' => $request->irpp,
                'payment_date' => $request->payment_date,
                'receipt_number' => $request->receipt_number,
                'operator' => $request->operator,
                'type_of_recipe_id' => $request->idTypeOfRecipe,
                'created_by' => auth()->user()->id
            ]);

            Log::info("Ajout d'un cash_in", ['auteur' => auth()->user()->id, 'cash_in' => $cashin->id]);

            return CashInResource::make($cashin);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour les infos d'un encaissement
     *
     * @param CashInUpdateRequest $request
     * @param $idCashIn
     * @return CashInResource|\Illuminate\Http\JsonResponse
     */
    public function update(CashInUpdateRequest $request, $idCashIn)
    {
        try {
            $cash_in = CashIn::findOrFail($idCashIn);

            $cash_in->update([
                'idClient' => $request->idClient ?? $cash_in->idClient,
                'amount_to_receive' => $request->amount_to_receive ?? $cash_in->amount_to_receive,
                'amount_received' => $request->amount_received ?? $cash_in->amount_received,
                'reason' => $request->reason ?? $cash_in->reason,
                'payment_method' => $request->payment_method ?? $cash_in->payment_method,
                'irpp' => $request->irpp ?? $cash_in->irpp,
                'payment_date' => $request->payment_date ?? $cash_in->payment_date,
                'receipt_number' => $request->receipt_number ?? $cash_in->receipt_number,
                'operator' => $request->operator ?? $cash_in->operator,
                'type_of_recipe_id' => $request->idTypeOfRecipe ?? $cash_in->type_of_recipe_id,
                'updated_by' => auth()->user()->id
            ]);

            $cash_in->save();

            Log::info("maj d'un cash_in", ['auteur' => auth()->user()->id, 'cash_in' => $cash_in->id]);

            return CashInResource::make($cash_in);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer un encaissement à la corbeille
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash($id)
    {
        try {
            $cash_in = CashIn::findOrFail($id);

            $cash_in->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            Log::critical("Mise en corbeille d'un encaissement", ['auteur' => auth()->user()->id, 'cash_in' => $cash_in->id]);

            return $this->sendResponse([], "CashIn supprimé avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer un encaissement de la corbeille
     * Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return CashInResource|\Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        try {
            $cash_in = CashIn::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $cash_in->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);
            Log::critical("Restauration d'un encaissement de la corbeille", ['auteur' => auth()->user()->id, 'cash_in' => $cash_in->id]);

            return CashInResource::make($cash_in);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des encaissements à la corbeille (soft delete).
     *
     * @param  CashInArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(CashInArchiveRequest $request): JsonResponse
    {
        try {
            CashIn::whereIn('id', $request->ids)->delete();
            Log::info('Encaissements mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('cash_in.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des encaissements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des encaissements supprimés (soft delete).
     *
     * @param  CashInArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(CashInArchiveRequest $request): JsonResponse
    {
        try {
            CashIn::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Encaissements restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('cash_in.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des encaissements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des encaissements (hard delete).
     *
     * @param  CashInArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(CashInArchiveRequest $request): JsonResponse
    {
        try {
            CashIn::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Encaissements supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('cash_in.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des encaissements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
