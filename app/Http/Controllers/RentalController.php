<?php

namespace App\Http\Controllers;

use App\Enums\ArticleMovementOperationTypeEnum;
use App\Http\Requests\Rental\RentalArchiveRequest;
use App\Http\Requests\Rental\RentalCreateRequest;
use App\Http\Requests\Rental\RentalGetRequest;
use App\Http\Requests\Rental\RentalUpdateRequest;
use App\Http\Resources\RentalResource;
use App\Models\Article;
use App\Models\ArticleMovement;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;


/**
 * @group Rentals / Locations
 *
 * Gestion des locations
 */
class RentalController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param RentalGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(RentalGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $filter_value = $request->filter_value;

            $rental = Rental::query();

            // Filtres possibles
            if ($request->filled('article_id')) {
                $rental->where('article_id', $request->article_id);
            }

            if ($request->filled('user_id')) {
                $rental->where('user_id', $request->user_id);
            }

            if ($request->filled('start_date')) {
                $rental->whereDate('exit_date', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $rental->whereDate('exit_date', '<=', $request->end_date);
            }

            if ($request->filled('filter_value')) {
                $rental->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('reason', 'like', '%' . $request->filter_value . '%');
                });
            }

            return RentalResource::collection(
                $rental
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param RentalCreateRequest $request
     * @return JsonResponse
     */
    public function create(RentalCreateRequest $request)
    {
        try {
            if (($request['entry_quantity'] ?? 0)  > $request['exit_quantity']){
                return $this->sendError(__('rental.create.stock_error'));
            }

            $article = Article::find($request['article_id']);

            if ($article->stock_quantity < $request['exit_quantity']){
                return $this->sendError(__('article_movement.insuffisant_stock'), [
                    'article_id' => $request['article_id']
                ]);
            }

            $rental = Rental::create([
                'user_id' => $request['user_id'] ?? null,
                'article_id' => $request['article_id'],
                'description' => $request['description'] ?? null,
                'reason' => $request['reason'] ?? null,
                'exit_quantity' => $request['exit_quantity'],
                'exit_date' => $request['exit_date'] ?? now(),
                'exit_condition' => $request['exit_condition'] ?? null,
                'exit_image' => $request['exit_image'] ?? null,
                'entry_quantity' => $request['entry_quantity'] ?? 0,
                'entry_date' => $request['entry_date'] ?? null,
                'entry_condition' => $request['entry_condition'] ?? null,
                'entry_image' => $request['entry_image'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $articleMovement = ArticleMovement::create([
                'quantity' => $request['exit_quantity'],
                'reason' => $rental['reason'],
                'date' => $request['exit_date'] ?? null,
                'description' => $rental['description'] ?? null,
                'operation_type' => ArticleMovementOperationTypeEnum::RENTAL_EXIT,
                'article_id' => $rental['article_id'],
                'purchase_order_id' => null,
                'created_by' => auth()->id(),
                'user_id' => $rental['user_id'] ?? null, // ou autre champ si différent
                'stock' => $article->stock_quantity - $rental['exit_quantity'],
            ]);

            if ($rental['entry_quantity'] > 0){
                $articleMovement = ArticleMovement::create([
                    'quantity' => $request['entry_quantity'],
                    'reason' => $rental['reason'],
                    'date' => $rental['entry_date'] ?? null,
                    'description' => $rental['description'] ?? null,
                    'operation_type' => ArticleMovementOperationTypeEnum::RENTAL_ENTRY,
                    'article_id' => $rental['article_id'],
                    'purchase_order_id' => null,
                    'created_by' => auth()->id(),
                    'user_id' => $rental['user_id'] ?? null, // ou autre champ si différent
                    'stock' => $article->stock_quantity + $rental['entry_quantity'],
                ]);
            }

            Log::info('Ajout réussi de la location', ['author' => auth()->id(), 'rental' => $rental]);

            return $this->sendResponse(new RentalResource($rental), __('budget.create.success'));
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @param Rental $rental
     * @return RentalResource|JsonResponse
     */
    public function show(Rental $rental)
    {
        try {
            return new RentalResource($rental);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param RentalUpdateRequest $request
     * @param Rental $rental
     * @return JsonResponse
     */
    public function update(RentalUpdateRequest $request, Rental $rental)
    {
        try {
            $article = Article::find($rental['article_id']);

            if (($request['return_quantity'] ?? 0) + $rental['entry_quantity'] > $rental['exit_quantity']){
                return $this->sendError(__('rental.update.exeed_return_quantity'));
            }

            $rental->update([
                'user_id' => $request['user_id'] ?? $rental['user_id'],
//                'article_id' => $request['article_id'] ?? $rental['article_id'],
                'description' => $request['description'] ?? $rental['description'],
//                'exit_quantity' => $request['exit_quantity'] ?? $rental['exit_quantity'],
                'exit_date' => $request['exit_date'] ?? $rental['exit_date'],
                'exit_condition' => $request['exit_condition'] ?? $rental['exit_condition'],
                'exit_image' => $request['exit_image'] ?? $rental['exit_image'],
//                'entry_quantity' => $request['entry_quantity'] ?? $rental['entry_quantity'],
                'entry_date' => $request['entry_date'] ?? $rental['entry_date'],
                'entry_condition' => $request['entry_condition'] ?? $rental['entry_condition'],
                'entry_image' => $request['entry_image'] ?? $rental['entry_image'],
                'updated_by' => auth()->id(),
            ]);

            if (($request['return_quantity'] ?? 0) > 0){
                $articleMovement = ArticleMovement::create([
                    'quantity' => $request['return_quantity'],
                    'reason' => $rental['reason'],
                    'date' => $rental['entry_date'] ?? null,
                    'description' => $rental['description'] ?? null,
                    'operation_type' => ArticleMovementOperationTypeEnum::RENTAL_ENTRY,
                    'article_id' => $rental['article_id'],
                    'purchase_order_id' => null,
                    'created_by' => auth()->id(),
                    'user_id' => $rental['user_id'] ?? null, // ou autre champ si différent
                    'stock' => $article->stock_quantity + $request['return_quantity'],
                ]);

                $rental->update([
                    'entry_quantity' => $rental['entry_quantity'] + $request['return_quantity'],
                ]);
            }

            Log::info('Modification réussie de la location', ['author' => auth()->id(), 'rental' => $rental]);
            return $this->sendResponse(RentalResource::make($rental), __('budget.update.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }


    /**
     * Fonction pour le multiple archivage des locations
     * @param RentalArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(RentalArchiveRequest $request)
    {
        try {
            $rental_ids = $request['ids'] ?? null;

            // Désactiver les locations
            Rental::whereIn('id', $rental_ids)->delete();

            return $this->sendResponse([], __('rental.trashed.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de restauration multiples des locations
     * @param RentalArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(RentalArchiveRequest $request)
    {
        try {
            $rental_ids = $request['ids'] ?? null;

            // Restaurer les locations
            Rental::withTrashed()->whereIn('id', $rental_ids)->restore();

            return $this->sendResponse([], __('rental.restore.success'), 200);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des locations
     * @param RentalArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(RentalArchiveRequest $request)
    {
        try {
            $rental_ids = $request['ids'] ?? null;

            // Suppression définitive
            Rental::withTrashed()->whereIn('id', $rental_ids)->forceDelete();

            return $this->sendResponse([], __('rental.delete.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }
}
