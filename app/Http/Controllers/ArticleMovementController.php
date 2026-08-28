<?php

namespace App\Http\Controllers;

use App\Enums\ArticleMovementOperationTypeEnum;
use App\Http\Requests\ArticleMovement\ArticleMovementCreateRequest;
use App\Http\Requests\ArticleMovement\ArticleMovementGetRequest;
use App\Http\Requests\ArticleMovement\ArticleMovementUpdateRequest;
use App\Http\Requests\ArticleMovement\ArticleMovementArchiveRequest;
use App\Http\Resources\ArticleMovementResource;
use App\Models\Article;
use App\Models\ArticleMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Mouvements d'articles
 *
 * Gestion des mouvements d'articles
 */
class ArticleMovementController extends BaseController
{
    /**
     * Lister les mouvements d'article en fonction du filtre
     * @param ArticleMovementGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ArticleMovementGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $filter_value = $request->filter_value;

            $article_id = $request->article_id;
            $operation_type = $request->operation_type;
//            $product_id = $request->product_id;
            $date_start = $request->date_start;
            $date_end = $request->date_end;

            $movements = ArticleMovement::query();

            if (! is_null($article_id)) {
                $movements->where('article_id', $article_id);
            }

            if (! is_null($operation_type)) {
                $movements->where('operation_type', $operation_type);
            }

//            if (! is_null($product_id)) {
//                $movements->where('product_id', $product_id);
//            }

            if (! is_null($date_start)) {
                $movements->whereDate('created_at', '>=', $date_start);
            }

            if (! is_null($date_end)) {
                $movements->whereDate('created_at', '<=', $date_end);
            }

            if (! is_null($filter_value)) {
                $movements->where(function ($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhereHas('article', function ($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('product', function ($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return ArticleMovementResource::collection(
                $movements
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Ajout mutiple des mouvements d'article
     * @param ArticleMovementCreateRequest $request
     * @return JsonResponse
     */
    public function create(ArticleMovementCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $movementsData = $request->input('article_movements');
            $savedMovements = [];

            foreach ($movementsData as $movement) {
                $article = Article::find($movement['article_id']);

                if (!$article) {
                    return $this->sendError(__('article_movement.article_not_found'));
                }

                // Vérification du stock si opération de sortie
                if (
                    $movement['operation_type'] === ArticleMovementOperationTypeEnum::EXIT &&
                    $article->stock_quantity < $movement['quantity']
                ) {
                    return $this->sendError(__('article_movement.insuffisant_stock'), [
                        'article_id' => $movement['article_id']
                    ]);
                }

                // Calcul du nouveau stock
                $newStock = $movement['operation_type'] === ArticleMovementOperationTypeEnum::ENTRY
                    ? $article->stock_quantity + $movement['quantity']
                    : $article->stock_quantity - $movement['quantity'];

                // Création du mouvement
                $articleMovement = ArticleMovement::create([
                    'quantity' => $movement['quantity'],
                    'reason' => $movement['reason'] ?? null,
                    'date' => $movement['date'] ?? null,
                    'description' => $movement['description'] ?? null,
                    'operation_type' => $movement['operation_type'],
                    'article_id' => $movement['article_id'],
                    'purchase_order_id' => $movement['purchase_order_id'] ?? null,
                    'created_by' => auth()->id(),
                    'user_id' => $movement['idUser'] ?? null, // ou autre champ si différent
                    'stock' => $newStock,
                ]);

                $savedMovements[] = $articleMovement;
            }

            Log::info('Mouvements de produits enregistrés', [
                'author' => auth()->id(),
                'movements' => $savedMovements
            ]);

            DB::commit();

            return $this->sendResponse(
                ArticleMovementResource::collection($savedMovements),
                __('article_movement.create.success')
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }


    /**
     * Afficher un mouvement d'article spécifique
     * @param ArticleMovement $articleMovement
     * @return ArticleMovementResource|JsonResponse
     */
    public function show(ArticleMovement $articleMovement)
    {
        try {
            return new ArticleMovementResource($articleMovement);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Met des mouvements d'articles à la corbeille (soft delete).
     *
     * @param ArticleMovementArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(ArticleMovementArchiveRequest $request): JsonResponse
    {
        try {
            ArticleMovement::whereIn('id', $request->ids)->delete();
            Log::info('Mouvements d\'articles mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('articlemovement.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des mouvements d\'articles : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des mouvements d'articles supprimés (soft delete).
     *
     * @param ArticleMovementArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(ArticleMovementArchiveRequest $request): JsonResponse
    {
        try {
            ArticleMovement::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Mouvements d\'articles restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('articlemovement.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des mouvements d\'articles : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des mouvements d'articles (hard delete).
     *
     * @param ArticleMovementArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(ArticleMovementArchiveRequest $request): JsonResponse
    {
        try {
            ArticleMovement::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Mouvements d\'articles supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('articlemovement.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des mouvements d\'articles : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
