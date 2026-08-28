<?php

namespace App\Http\Controllers;

use App\Enums\DisbursementPaymentMethodEnum;
use App\Enums\DisbursementStatusEnum;
use App\Enums\PurchaseOrderPaymentMethodEnum;
use App\Enums\PurchaseOrderPaymentStatusEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Http\Requests\PurchaseOrder\PurchaseOrderArchiveRequest;
use App\Http\Requests\PurchaseOrder\PurchaseOrderGetRequest;
use App\Http\Requests\PurchaseOrder\PurchaseOrderStoreRequest;
use App\Http\Requests\PurchaseOrder\PurchaseOrderUpdateRequest;
use App\Http\Resources\DisbursementResource;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\Article;
use App\Models\ArticleMovement;
use App\Models\Disbursement;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Bons d'achats
 *
 * Gestion des bons d'achat
 */
class PurchaseOrderController extends BaseController
{
    /**
     * Afficher une liste filtrée des bons d'achat
     */
    public function index(PurchaseOrderGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
//            $hotel_id = $request->get('hotel_id');
            $article_ids = $request->get('article_ids', []);
            $filter_value = $request->get('filter_value', null);
            $date_start = $request->get('date_start', null);
            $date_end = $request->get('date_end', null);

            $query = PurchaseOrder::query()
                ->with(['supplier', 'responsible', 'articles'])
                ->when($request->status, function ($q) use ($request) {
                    return $q->where('status', $request->status);
                })
                ->when($request->priority, function ($q) use ($request) {
                    return $q->where('priority', $request->priority);
                })
                ->when($request->payment_status, function ($q) use ($request) {
                    return $q->where('payment_status', $request->payment_status);
                })
                ->when($request->supplier_id, function ($q) use ($request) {
                    return $q->where('supplier_id', $request->supplier_id);
                })
                ->when($request->responsible_id, function ($q) use ($request) {
                    return $q->where('responsible_id', $request->responsible_id);
                })
                ->when($filter_value, function ($q) use ($filter_value) {
                    $q->where(function ($subQuery) use ($filter_value) {
                        $subQuery->where('reference', 'like', "%{$filter_value}%")
                            ->orWhereHas('supplier', function ($q) use ($filter_value) {
                                $q->where('firstname', 'like', "%{$filter_value}%")
                                    ->orWhere('lastname', 'like', "%{$filter_value}%");
                            })
                            ->orWhereHas('responsible', function ($q) use ($filter_value) {
                                $q->where('firstname', 'like', "%{$filter_value}%")
                                    ->orWhere('lastname', 'like', "%{$filter_value}%");
                            })
                            ->orWhereHas('articles', function ($q) use ($filter_value) {
                                $q->where('name', 'like', "%{$filter_value}%");
                            });
                    });
                })
                ->when(!empty($article_ids), function ($q) use ($article_ids) {
                    $q->whereHas('articles', function ($q) use ($article_ids) {
                        $q->whereIn('articles.id', $article_ids);
                    }, '=', count($article_ids)); // doit contenir *tous* les articles
                })
                ->when($date_start, function ($q) use ($date_start) {
                    $q->where('created_at', '>=', $date_start);
                })
                ->when($date_end, function ($q) use ($date_end) {
                    $q->where('created_at', '<=', $date_end);
                });

               // $querys = $query->whereNotIn('payment_status', ['pending', 'cancelled']);
                $totalAmount = $query->get()->sum(function ($po) {
                    return $po->total_amount;
                });
                
                $purchase = (clone $query);//->whereNotIn('payment_status', ['none']);
                //recuperer les payments dans invoices
                $totalAmountPaid = Invoice::whereHas('purchaseOrder', function ($q) use ($purchase) {
                    $q->whereIn('id', $purchase->pluck('id'));
                })->where('statut', 'paid')->get()->sum('amount');

                $totalrest = $totalAmount - $totalAmountPaid;


//            if ($hotel_id) {
//                $query->whereHas('articles.service', function ($q) use ($hotel_id) {
//                    $q->where('hotel_id', $hotel_id);
//                });
//            }

            return PurchaseOrderResource::collection($query
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems)
            )->additional([
                'total_amount' => $totalAmount,
                'total_amount_paid' => $totalAmountPaid,
                'total_rest' => $totalrest,
                //'total_amount' => 'success',
            ]);
        } catch (\Exception $e) {
            return $this->sendError(__('app.error_occured'), null, 404, $e->getMessage());
        }
    }

    /**
     * Enregistrer un bon d'achat
     */
    public function create(PurchaseOrderStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $author = auth()->id();

            $reference = generateReferenceNumber(PurchaseOrder::class, 'reference', 6);
            $purchase_order = PurchaseOrder::create([
                'reference' => $reference,
                'supplier_id' => $request->supplier_id,
                'responsible_id' => $request->responsible_id,
                'description' => $request->description ?? null,
                'status' => $request->status ?? PurchaseOrderStatusEnum::REQUESTING_PRICE,
                'priority' => $request->priority ?? PurchaseOrderPriorityEnum::LOW,
                'payment_method' => $request->payment_method ?? null,
                'payment_status' => $request->payment_status ?? PurchaseOrderPaymentStatusEnum::NONE,
                'quotation_file' => $request->quotation_file ?? null,
//                'quotation_file' => $request->file_name ?? null,
                'created_by' => $author,
            ]);

            // Synchronisation des articles si fournis
            if ($request->filled('articles')) {
                $articleData = [];

                foreach ($request->articles as $article) {
                    $articleData[$article['id']] = [
                        'unit_price' => $article['unit_price'],
                        'quantity' => $article['quantity'],
                    ];
                }

                $purchase_order->articles()->sync($articleData);
            }

            // Todo : implementer la logique de gestion des stocks

            Log::info("Ajout d'un bon d'achat", ['purchase_order' => $purchase_order, 'author' => $author]);

            DB::commit();

            return $this->sendResponse(PurchaseOrderResource::make($purchase_order), __('purchase_order.create.success'), 201);
        } catch (\Exception $e) {
            return $this->sendError(__('purchase_order.create.error'), null, 400);
        }
    }

    /**
     * Afficher un bon d'achat spécifique
     */
    public function show(PurchaseOrder $purchase_order)
    {
        try {
            return PurchaseOrderResource::make($purchase_order);
        } catch (\Exception $e) {
            return $this->sendError(__('app.error_occured'), $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseOrderUpdateRequest $request, PurchaseOrder $purchase_order): JsonResponse
    {
        DB::beginTransaction();

        try {
            $author = auth()->id();

            if ($request->status && $request->status != $purchase_order->status && $author != $purchase_order->responsible_id) {
                return $this->sendError(__('purchase_order.update.Unauthorized'));
            }

            // une fois que le statut est validé, on ne peut plus rien faire à ce sujet
            if(in_array($purchase_order->status, [PurchaseOrderStatusEnum::DELIVERED])){
                return $this->sendError(__('purchase_order.update.Unauthorized'), null, 403);
            }

            // Traitement du fichier de devis
//            if ($request->hasFile('quotation_file') && $request->file('quotation_file')->isValid()) {
//                $fileName = $purchase_order->quotation_file;
//
//                $fileName = upload_file(
//                    'quotation-files',
//                    $request->file('quotation_file'),
//                    $fileName
//                );
//
//                $request['file_name'] = $fileName;
//            }

            // Mise à jour des champs principaux s'ils sont présents dans la requête
            $purchase_order->update([
                'supplier_id' => $request->supplier_id ?? $purchase_order->supplier_id,
                'responsible_id' => $request->responsible_id ?? $purchase_order->responsible_id,
                'description' => $request->description ?? $purchase_order->description,
                'status' => $request->status ?? $purchase_order->status,
                'priority' => $request->priority ?? $purchase_order->priority,
                'quotation_file' => $request->quotation_file ?? $purchase_order->quotation_file,
                'payment_method' => $request->payment_method ?? $purchase_order->payment_method,
                'payment_status' => $request->payment_status ?? $purchase_order->payment_status,
                'updated_at' => now(),
                'updated_by' => $author,
            ]);

            // Mise à jour des articles associés (si fournis)
            if ($request->filled('articles')) {
                $articleData = [];
                foreach ($request->articles as $article) {
                    if (isset($article['id'], $article['unit_price'], $article['quantity'])) {
                        $articleData[$article['id']] = [
                            'unit_price' => $article['unit_price'],
                            'quantity' => $article['quantity'],
                        ];
                    }
                }

                // Synchronise les articles avec les nouvelles données
                $purchase_order->articles()->sync($articleData);
            }

            DB::commit();

            Log::info("Mise à jour d'un bon d'achat", [
                'purchase_order_id' => $purchase_order->id,
                'updated_by' => $author,
            ]);

            // Si le bon passe au statut 'paye', on enregistre une dépense(disbursement)', on enregistre le mouvement d'articles
            if($purchase_order->status == PurchaseOrderStatusEnum::PAID){
//                $reference = generateReferenceNumber(Disbursement::class, 'reference', 9);

                $totalAmount = $purchase_order->articles->sum(function ($article) {
                    return $article->pivot->unit_price * $article->pivot->quantity;
                });

//                $disbursement = Disbursement::create([
//                    'reference' => $reference,
//                    'total_amount' => $totalAmount,
//                    'payment_method' => $request->payment_method ?? DisbursementPaymentMethodEnum::CASH,
//                    'status' => DisbursementStatusEnum::APPROVED,
//                    'expense_type_id' => 1,
//                    'reasons' => __('disbursement.reason_default', ['reference' => $purchase_order->reference]),
//                    'responsible_id' => $request->responsible_id,
//                    'purchase_order_id' => $purchase_order->id,
//                    'validation_date' => now(),
//                    'disbursement_date' => now(),
//                    'created_by' => $author,
//                ]);

//                return $this->sendResponse('', DisbursementResource::make($disbursement));

            $inv = Invoice::create([
                'purchase_order_id' => $purchase_order->id,
                'amount' => $totalAmount,
                'reasons' => __('invoice.reason_default', ['reference' => $purchase_order->reference]),
                'payment_deadline' => null,
                'date' => now(),
                'idSchool' => $purchase_order->articles->first()->idSchool,
                'idSection' => $purchase_order->articles->first()->idSection ?? null,
                'created_by' => auth()->user()->id,
                    'invoiceable_type' => "App\Models\User",
                'invoiceable_id' => $purchase_order->supplier_id,
                'statut' => $purchase_order->status,
                'mode' => $purchase_order['payment_method'] ?? PurchaseOrderPaymentMethodEnum::CASH,
                'idTypeInvoice' => 1,
            ]);
        }

            if($purchase_order->status == PurchaseOrderStatusEnum::DELIVERED){
                foreach($request->articles as $purchase_article){
                    $article = Article::find($purchase_article['id']);

                    ArticleMovement::create([
                        'stock' => $article->stock_quantity + ($purchase_article['quantity'] * $article->container_quantity),  // Mise à jour du stock
                        'quantity' => ($purchase_article['quantity'] * $article->container_quantity),
                        'operation_type' => 'entry', // Entrée de stock
                        'article_id' => $article->id,
//                        'product_id' => null,
                        'purchase_order_id' => $purchase_order->id,
                        'created_by' => $author,
                    ]);
                }
            }

            return $this->sendResponse(PurchaseOrderResource::make($purchase_order), __('purchase_order.update.success'), 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendError(__('purchase_order.update.error'), $e);
        }
    }

    /**
     * Fonction pour le multiple archivage des bonds d'achat
     * @param PurchaseOrderArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(PurchaseOrderArchiveRequest $request): JsonResponse
    {
        try {
            $purchase_vaucher_ids = $request['ids'] ?? null;

            // Désactiver les bonds d'achat
            PurchaseOrder::whereIn('id', $purchase_vaucher_ids)->delete();

            return $this->sendResponse(null, __('purchase_order.trashed.success'), 204);
        } catch (\Exception $e) {
            return $this->sendError(__('app.error_occured'), null, 404, $e->getMessage());
        }
    }

    /**
     * Fonction de restauration multiples des bonds d'achat
     * @param PurchaseOrderArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(PurchaseOrderArchiveRequest $request): JsonResponse
    {
        try {
            $purchase_vaucher_ids = $request['ids'] ?? null;

            // Restaurer les bonds d'achat
            PurchaseOrder::withTrashed()->whereIn('id', $purchase_vaucher_ids)->restore();

            return $this->sendResponse(null, __('purchase_order.restore.success'));
        } catch (\Exception $e) {
            return $this->sendError(__('app.error_occured'), null, 404, $e->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des bonds d'achat
     *
     * @param PurchaseOrderArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(PurchaseOrderArchiveRequest $request): JsonResponse
    {
        try {
            $purchase_vaucher_ids = $request['ids'] ?? null;

            // Suppression définitive
            PurchaseOrder::withTrashed()->whereIn('id', $purchase_vaucher_ids)->forceDelete();

            return $this->sendResponse(null, __('purchase_order.delete.success'), 204);
        } catch (\Exception $e) {
            return $this->sendError(__('app.error_occured'), null, 404, $e->getMessage());
        }
    }
}
