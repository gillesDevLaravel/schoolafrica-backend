<?php

namespace App\Http\Controllers;

use App\Enums\SupplyDemandStatusEnum;
use App\Http\Requests\SupplyDemand\SupplyDemandCreateRequest;
use App\Http\Requests\SupplyDemand\SupplyDemandUpdateRequest;
use App\Http\Requests\SupplyDemand\SupplyDemandArchiveRequest;
use App\Http\Requests\SupplyDemand\SupplyDemandGetRequest;
use App\Http\Resources\SupplyDemandResource;
use App\Models\Article;
use App\Models\SupplyDemand;
use App\Services\PurchaseOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Demande d'approvisionnement | Supply demand
 * Contrôleur chargé de la gestion des demandes d'approvisionnement.
 */
class SupplyDemandController extends BaseController
{

    /**
     * Affiche la liste paginée des demandes d'approvisionnement, avec filtres optionnels.
     *
     * @param  SupplyDemandGetRequest  $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(SupplyDemandGetRequest $request)
    {
        try {
            $responsible_id = $request->input('responsible_id');
            $priority = $request->input('priority');
            $priority = $request->input('priority');
            $status = $request->input('status');
            $filter_value = $request->input('filter_value');
            $date_start = $request->input('date_start');
            $date_end = $request->input('date_end');
//            $hotel_id = $request->input('hotel_id');

            $nbreItems = $request->input('nbreItems', 1000000);
            $pageItems = $request->input('pageItems', 1);

            $query = SupplyDemand::query()->with(['responsible']);


//            if ($hotel_id) {
//                $query->whereHas('articles.service', function ($q) use ($hotel_id) {
//                    $q->where('hotel_id', $hotel_id);
//                });
//            }

            if ($responsible_id) {
                $query->where('responsible_id', $responsible_id);
            }

            if ($priority) {
                $query->where('priority', $priority);
            }

            if ($status) {
                $query->where('status', $status);
            }

            // Filtres par date
            if ($date_start) {
                $query->whereDate('created_at', '>=', $date_start);
            }

            if ($date_end) {
                $query->whereDate('created_at', '<=', $date_end);
            }

            if ($filter_value) {
                $query->where(function ($q) use ($filter_value) {
                    $q->where('name', 'like', "%$filter_value%")
                        ->orWhere('reference', 'like', "%{$filter_value}%")
                        ->orWhere('description', 'like', "%$filter_value%")
                        ->orWhereHas('responsible', function ($sub) use ($filter_value) {
                            $sub->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return SupplyDemandResource::collection(
                $query->orderBy('id', 'desc')->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée une nouvelle demande d'approvisionnement.
     *
     * @param  SupplyDemandCreateRequest  $request
     * @return JsonResponse
     */
    public function create(SupplyDemandCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $supply_demand = SupplyDemand::create([
                'reference' => generateReferenceNumber(SupplyDemand::class, 'reference', 6),
                'name' => $data['name'] ?? null,
                'description' => $data['description'] ?? null,
                'responsible_id' => $data['responsible_id'],
                'priority' => $data['priority'],
                'status' => $data['status'] ?? SupplyDemandStatusEnum::PENDING,
                'created_by' => auth()->id(),
            ]);

            // Synchronisation des articles
            $articleData = [];

            foreach ($request->articles as $article) {
                $articleData[$article['id']] = [
                    'unit_price' => $article['unit_price'] ?? null,
                    'quantity' => $article['quantity'],
                    'supplier_id' => $article['supplier_id'],
                ];
            }
            $supply_demand->articles()->sync($articleData);

            DB::commit();
            Log::info("Ajout d'une demande d'approvisionnement", ['supply_demand' => $supply_demand, 'author' => auth()->id()]);

            return $this->sendResponse(new SupplyDemandResource($supply_demand), __('supply_demand.create.success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'une demande d'approvisionnement spécifique.
     *
     * @param  SupplyDemand  $supply_demand
     * @return JsonResponse|SupplyDemandResource
     */
    public function show(SupplyDemand $supply_demand)
    {
        try {
            return new SupplyDemandResource($supply_demand);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met à jour les informations d'une demande d'approvisionnement existante.
     *
     * @param SupplyDemandUpdateRequest $request
     * @param SupplyDemand $supply_demand
     * @param PurchaseOrderService $purchase_order_service
     * @return JsonResponse
     */
    public function update(SupplyDemandUpdateRequest $request, SupplyDemand $supply_demand, PurchaseOrderService $purchase_order_service): JsonResponse
    {
        try {
            if (($request->status && ($request->status !== $supply_demand->status)) && (auth()->id() !== $supply_demand->responsible_id)) {
                return $this->sendError(__('supply_demand.update.Unauthorized'));
            }

            // une fois que le statut est validé, on ne peut plus rien faire à ce sujet
            if(in_array($supply_demand->status, [SupplyDemandStatusEnum::ACCEPTED, SupplyDemandStatusEnum::REFUSED])){
                return $this->sendError(__('purchase_order.update.Unauthorized'), null, 403);
            }

            $supply_demand->update([
                'name' => $request->input('name', $supply_demand->name),
                'description' => $request->input('description', $supply_demand->description),
                'responsible_id' => $request->input('responsible_id', $supply_demand->responsible_id),
                'status' => $request->input('status', $supply_demand->status),
                'priority' => $request->input('priority', $supply_demand->priority),
                'updated_by' => auth()->id(),
            ]);

            // Mise à jour des articles associés (si fournis)
            if ($request->filled('articles')) {
                $supply_demand->articles()->detach();

                $articleData = [];
                foreach ($request->articles as $article) {
                    $articleData[$article['id']] = [
                        'unit_price' => $article['unit_price'] ?? null,
                        'quantity' => $article['quantity'],
                        'supplier_id' => $article['supplier_id']
                    ];
                }
                // Synchronise les articles avec les nouvelles données
                $supply_demand->articles()->sync($articleData);
            }

            if($request->status === SupplyDemandStatusEnum::ACCEPTED){
                $supply_articles = collect($supply_demand->articles)->groupBy('pivot.supplier_id');

                foreach ($supply_articles as $supplier_id => $articles) {
                    /** @var Collection<int, Article> $articles */
                    $purchase_order_service->createPurchaseOrder([
                        'supplier_id'   => $supplier_id,
                        'responsible_id'=> $supply_demand->responsible_id, // Meme responsable
                        'description'   => $supply_demand->description, //Meme priorité
                        'priority'      => $supply_demand->priority,
                        'articles'      => $articles->map(function ($article) {
                            return [
                                'id'         => $article['id'],
                                'unit_price' => $article->pivot->unit_price,
                                'quantity'   => $article->pivot->quantity,
                            ];
                        })->toArray(),
                    ]);
                }
            }

            return $this->sendResponse(new SupplyDemandResource($supply_demand), __('supply_demand.update.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met en corbeille (suppression logique) une ou plusieurs demandes d'approvisionnement.
     *
     * @param  SupplyDemandArchiveRequest  $request
     * @return JsonResponse
     */
    public function trash(SupplyDemandArchiveRequest $request): JsonResponse
    {
        try {
            SupplyDemand::whereIn('id', $request->ids)->each(function ($item) {
                $item->delete();
                $item->updated_by = auth()->id();
                $item->save();

                Log::critical('Demande d\'approvisionnement mise en corbeille.', [
                    'supply_demand' => $item->id,
                    'author' => auth()->id(),
                ]);
            });

            return $this->sendResponse(null, __('supply_demand.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure une ou plusieurs demandes d'approvisionnement supprimées (suppression logique).
     *
     * @param  SupplyDemandArchiveRequest  $request
     * @return JsonResponse
     */
    public function restore(SupplyDemandArchiveRequest $request): JsonResponse
    {
        try {
            $restored = [];

            SupplyDemand::onlyTrashed()->whereIn('id', $request->ids)->each(function ($item) use (&$restored) {
                $item->restore();
                $item->save();

                Log::critical('Demande restaurée.', [
                    'supply_demand' => $item->id,
                    'author' => auth()->id(),
                ]);

                $restored[] = $item;
            });

            return $this->sendResponse(SupplyDemandResource::collection($restored), __('supply_demand.restore.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement une ou plusieurs demandes d'approvisionnement.
     *
     * @param  SupplyDemandArchiveRequest  $request
     * @return JsonResponse
     */
    public function destroy(SupplyDemandArchiveRequest $request): JsonResponse
    {
        try {
            SupplyDemand::onlyTrashed()->whereIn('id', $request->ids)->each(function ($item) {
                Log::critical('Demande définitivement supprimée.', [
                    'supply_demand' => $item->id,
                    'author' => auth()->id(),
                ]);
                $item->forceDelete();
            });

            return $this->sendResponse(null, __('supply_demand.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
