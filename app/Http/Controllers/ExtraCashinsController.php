<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CashInAllRequest;
use App\Http\Requests\Admin\CashInsAllRequest;
use App\Http\Requests\Admin\CashInStoreRequest;
use App\Http\Requests\Admin\CashInUpdateRequest;
use App\Http\Resources\Admin\ExtracashinsResource;
use App\Models\ExtraCashins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @group ExtraCashins
 */
class ExtraCashinsController extends BaseController
{

    /**
     * Récupérer la liste des encaissements
     *
     * @param CashInAllRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(CashInAllRequest $request)
    {
        try {
            $filter_value = $request->filter_value;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $extra_cashins = ExtraCashins::query();

            if(!is_null($request->irpp)) $extra_cashins = $extra_cashins->where('irpp', $request->irpp);

            if(!is_null($filter_value)){
                $extra_cashins->where(function($query) use ($filter_value) {
                    $query->where('payment_method', 'like', "%$filter_value%")
                        ->orWhere('reason', 'like', "%$filter_value%")
                        ->orWhereHas('client', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return ExtracashinsResource::collection(
                $extra_cashins
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems));

        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les informations d'un encaissement
     *
     * @param $idCashIn
     * @return ExtracashinsResource|JsonResponse
     */
    public function show($idCashIn)
    {
        try {
            return ExtracashinsResource::make(ExtraCashins::findOrFail($idCashIn));
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer un nouvel encaissement
     *
     * @param CashInStoreRequest $request
     * @return ExtracashinsResource|JsonResponse
     */
    public function store(CashInStoreRequest $request)
    {
        try {
            $cashin = ExtraCashins::create([
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

            Log::info("Ajout d'un extra_cashins", ['auteur' => auth()->user()->id, 'extra_cashins' => $cashin->id]);

            return ExtracashinsResource::make($cashin);
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
     * @return ExtracashinsResource|JsonResponse
     */
    public function update(CashInUpdateRequest $request, $idCashIn)
    {
        try {
            $extra_cashins = ExtraCashins::findOrFail($idCashIn);

            $extra_cashins->update([
                'idClient' => $request->idClient ?? $extra_cashins->idClient,
                'amount_to_receive' => $request->amount_to_receive ?? $extra_cashins->amount_to_receive,
                'amount_received' => $request->amount_received ?? $extra_cashins->amount_received,
                'reason' => $request->reason ?? $extra_cashins->reason,
                'payment_method' => $request->payment_method ?? $extra_cashins->payment_method,
                'irpp' => $request->irpp ?? $extra_cashins->irpp,
                'payment_date' => $request->payment_date ?? $extra_cashins->payment_date,
                'receipt_number' => $request->receipt_number ?? $extra_cashins->receipt_number,
                'operator' => $request->operator ?? $extra_cashins->operator,
                'type_of_recipe_id' => $request->idTypeOfRecipe ?? $extra_cashins->type_of_recipe_id,
                'updated_by' => auth()->user()->id
            ]);

            $extra_cashins->save();

            Log::info("maj d'un extra_cashins", ['auteur' => auth()->user()->id, 'extra_cashins' => $extra_cashins->id]);

            return ExtracashinsResource::make($extra_cashins);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer un encaissement à la corbeille
     *
     * @param $id
     * @return JsonResponse
     */
    public function trash($id)
    {
        try {
            $extra_cashins = ExtraCashins::findOrFail($id);

            $extra_cashins->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            Log::critical("Mise en corbeille d'un encaissement", ['auteur' => auth()->user()->id, 'extra_cashins' => $extra_cashins->id]);

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
     * @return ExtracashinsResource|JsonResponse
     */
    public function restore($id)
    {
        try {
            $extra_cashins = ExtraCashins::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $extra_cashins->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);
            Log::critical("Restauration d'un encaissement de la corbeille", ['auteur' => auth()->user()->id, 'extra_cashins' => $extra_cashins->id]);

            return ExtracashinsResource::make($extra_cashins);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
