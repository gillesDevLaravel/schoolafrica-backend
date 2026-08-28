<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\TypeInvoiceStoreRequest;
use App\Http\Requests\Admin\TypeInvoiceUpdateRequest;
use App\Http\Requests\TypeInvoice\TypeInvoiceArchiveRequest;
use App\Http\Resources\TypeInvoiceResource;
use App\Models\Invoice;
use App\Models\TypeInvoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Type Invoice
 */
class TypeInvoiceController extends BaseController
{
    /**
     * Lister tous les types d'invoices créés
     *
     * @param Request $request
     * @urlParam type string required
     * @return AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $typeInvoice = TypeInvoice::query();
            if($request->has('type')) {
                $typeInvoice->where('type', $request->type);
            }
            
            
            return TypeInvoiceResource::collection($typeInvoice->orderBy('id', 'desc')->get());
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un type d'invoice
     *
     * @urlParam id int required
     * @return TypeInvoiceResource|\Illuminate\Http\Response
     */
    public function show($idTypeInvoice)
    {
        try {
            return TypeInvoiceResource::make(TypeInvoice::findOrFail($idTypeInvoice));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un nouveau type d'invoice
     * @param TypeInvoiceRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function store(TypeInvoiceStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $typeInvoiceDatas = $request['type_invoices'];

            $typeInvoices = [];

            foreach ($typeInvoiceDatas as $typeInvoiceData){
                $typeInvoice = TypeInvoice::create([
                    'name' => $typeInvoiceData['name'],
                    'code' => $typeInvoiceData['code'] ?? null,
                    'type' => $typeInvoiceData['type'] ?? null,
                    'category' => $typeInvoiceData['category'],
                    'school_id' => $typeInvoiceData['idSchool'] ?? null,
                    'created_by' => auth()->user()->id
                ]);

                $typeInvoices []= $typeInvoice;
            }

            DB::commit();

            return TypeInvoiceResource::collection($typeInvoices);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour le nom d'un type d'invoice
     *
     * @urlParam id int required
     * @param TypeInvoiceRequest $request
     * @return TypeInvoiceResource|\Illuminate\Http\Response
     */
    public function update(TypeInvoiceUpdateRequest $request, $idTypeInvoice)
    {
        try {
            $type_invoice = TypeInvoice::findOrFail($idTypeInvoice);
            $type_invoice->name = $request->name ?? $type_invoice->name;
            $type_invoice->code = $request->code ?? $type_invoice->code;
            $type_invoice->type = $request->type ?? $type_invoice->type;
            $type_invoice->category = $request->category ?? $type_invoice->category;
            $type_invoice->school_id = $request->idSchool ?? $type_invoice->school_id;
            $type_invoice->updated_by = auth()->user()->id;
            $type_invoice->save();

            return TypeInvoiceResource::make($type_invoice);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un type d'invoice (NB: Seulement si il n'a pas de invoice associé)
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response
     */
    public function destroy($idTypeInvoice)
    {
        try {
            $type_invoice = TypeInvoice::findOrFail($idTypeInvoice);

            $invoices = Invoice::where('idTypeInvoice', $idTypeInvoice)->count();

            if($invoices != 0){
                return $this->sendError("Impossible de supprimer ce type d'invoice, car il contient des invoices!");
            }

            $type_invoice->delete();

            return response()->json([], 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des types d'invoice à la corbeille (soft delete).
     *
     * @param  TypeInvoiceArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trash(TypeInvoiceArchiveRequest $request): JsonResponse
    {
        try {
            TypeInvoice::whereIn('id', $request->ids)->delete();
            Log::info('Types d\'invoice mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('type_invoice.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des types d\'invoice : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des types d'invoice supprimés (soft delete).
     *
     * @param  TypeInvoiceArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restore(TypeInvoiceArchiveRequest $request): JsonResponse
    {
        try {
            TypeInvoice::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Types d\'invoice restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('type_invoice.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des types d\'invoice : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des types d'invoice (hard delete).
     *
     * @param  TypeInvoiceArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(TypeInvoiceArchiveRequest $request): JsonResponse
    {
        try {
            TypeInvoice::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Types d\'invoice supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('type_invoice.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des types d\'invoice : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
