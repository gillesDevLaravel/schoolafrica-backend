<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Requests\Admin\TransactionRequest;
use App\Http\Resources\Admin\TransactionResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @group Transaction
 */
class TransactionController extends BaseController
{
    /**
     * Lister les transactions
     *
     * @bodyParam idSchool int
     * @bodyParam idSection int
     * @bodyParam type string
     * @bodyParam filter_value string
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $type = $request['type'] ?? null;
            $status = $request['status'] ?? null;
            $idStudent = $request['idStudent'] ?? null;
            $payment_date = $request['payment_date'] ?? null;
            $filter_value = $request['filter_value'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $transactions = Transaction::query();

            if(!is_null($idSchool)) $transactions = $transactions->where('idSchool', $request['idSchool']);
            if(!is_null($idSection)) $transactions = $transactions->where('idSection', $request['idSection']);
            if(!is_null($type)) $transactions = $transactions->where('type', $request['type']);
            if(!is_null($status)) $transactions = $transactions->where('status', $request['status']);
            if(!is_null($idStudent)) $transactions = $transactions->where('idStudent', $request['idStudent']);
            if(!is_null($payment_date)) $transactions = $transactions->where('payment_date', $request['payment_date']);

            if (!is_null($filter_value)) {
                $transactions->where(function ($query) use ($filter_value) {
                    $query->where('reference', 'like', "%$filter_value%")
                        ->orWhere('payment_mode', 'like', "%$filter_value%")
                        ->orWhere('status', 'like', "%$filter_value%")
                        ->orWhere('compteEmeteur', 'like', "%$filter_value%")
                        ->orWhereHas('student', function ($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return TransactionResource::collection(
                $transactions
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Créer une transaction
     *
     * @param TransactionRequest $request
     * @return TransactionResource|\Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            $transaction = $request->validated();
            $transaction = new Transaction();

            $transaction->access_token = $request['access_token'];
            $transaction->expires_in = $request['expires_in'];
            $transaction->order_id = $request['order_id'] ?? null;
            $transaction->amount = $request['amount'] ?? null;
            $transaction->reference = $request['reference'] ?? null;
            $transaction->status = $request['status'] ?? null;
            $transaction->message = $request['message'] ?? null;
            $transaction->pay_token = $request['pay_token'] ?? null;
            $transaction->payment_url = $request['payment_url'] ?? null;
            $transaction->notif_token = $request['notif_token'] ?? null;

            $transaction->payment_mode = $request['payment_mode'] ?? null;
            $transaction->payment_date = $request['payment_date'] ?? null;
            $transaction->tnxid = $request['tnxid'] ?? null;
            $transaction->idFee = $request['idFee'] ?? null;
            $transaction->idLevel = $request['idLevel'] ?? null;
            $transaction->idStudent = $request['idStudent'] ?? null;
            $transaction->idInvoice = $request['idInvoice'] ?? null;
            $transaction->type = $request['type'] ?? null;
            $transaction->idSchool = $request['idSchool'] ?? null;
            $transaction->idSection = $request['idSection'] ?? null;
            $transaction->idInscription = $request['idInscription'] ?? null;
            $transaction->idPension = $request['idPension'] ?? null;
            $transaction->idTranche = $request['idTranche'] ?? null;
            $transaction->idEnseignant = $request['idEnseignant'] ?? null;
            $transaction->compteEmeteur = $request['compteEmeteur'] ?? null;
            $transaction->compteRecepteur = $request['compteRecepteur'] ?? null;
            $transaction->created_by = auth()->user()->id;
            $transaction->save();

            return new TransactionResource($transaction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les détails d'une transaction
     *
     * @param $id
     * @return TransactionResource|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $transaction = Transaction::find($id);
            return new TransactionResource($transaction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une transaction
     *
     * @param TransactionRequest $request
     * @urlParam id int required
     * @return TransactionResource|\Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {
        try {
            $transaction = Transaction::find($id);

            $transaction->access_token = $request['access_token'] ?? $transaction['access_token'];
            $transaction->expires_in = $request['expires_in'] ?? $transaction['expires_in'];
            $transaction->order_id = $request['order_id'] ?? $transaction['order_id'];
            $transaction->amount = $request['amount'] ?? $transaction['amount'];
            $transaction->reference = $request['reference'] ?? $transaction['reference'];
            $transaction->status = $request['status'] ?? $transaction['status'];
            $transaction->message = $request['message'] ?? $transaction['message'];
            $transaction->pay_token = $request['pay_token'] ?? $transaction['pay_token'];
            $transaction->payment_url = $request['payment_url'] ?? $transaction['payment_url'];
            $transaction->notif_token = $request['notif_token'] ?? $transaction['notif_token'];
            $transaction->tnxid = $request['tnxid'] ?? $transaction['tnxid'];

            $transaction->payment_mode = $request['payment_mode'] ?? $transaction['payment_mode'];
            $transaction->payment_date = $request['payment_date'] ?? $transaction['payment_date'];
            $transaction->idFee = $request['idFee'] ?? $transaction['idFee'];
            $transaction->idLevel = $request['idLevel'] ?? $transaction['idLevel'];
            $transaction->idStudent = $request['idStudent'] ?? $transaction['idStudent'];
            $transaction->idInvoice = $request['idInvoice'] ?? $transaction['idInvoice'];
            $transaction->type = $request['type'] ?? $transaction['type'];
            $transaction->idSchool = $request['idSchool'] ?? $transaction['idSchool'];
            $transaction->idSection = $request['idSection'] ?? $transaction['idSection'];
            $transaction->idInscription = $request['idInscription'] ?? $transaction['idInscription'];
            $transaction->idPension = $request['idPension'] ?? $transaction['idPension'];
            $transaction->idTranche = $request['idTranche'] ?? $transaction['idTranche'];
            $transaction->idEnseignant = $request['idEnseignant'] ?? $transaction['idEnseignant'];
            $transaction->compteEmeteur = $request['compteEmeteur'] ?? $transaction['compteEmeteur'];
            $transaction->compteRecepteur = $request['compteRecepteur'] ?? $transaction['compteRecepteur'];
            $transaction->updated_by = auth()->user()->id;
            $transaction->save();

            return new TransactionResource($transaction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une transaction
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
//            $transaction->delete();

            $transaction->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id,
            ]);

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
