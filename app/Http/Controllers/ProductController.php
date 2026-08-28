<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductDestroyRequest;
use App\Http\Requests\Products\ProductGetRequest;
use App\Http\Requests\Products\ProductRestoreRequest;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductTrashRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{
    /**
     * Liste des produits
     *
     * @param ProductGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ProductGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $products = Product::query()
                ->where('deleted', (boolean) $request->trashed);

            if ($request->type) $products->where('type', $request->type);

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $products->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('type', 'like', '%' . $request->filter_value . '%');
                });
            }

            return ProductResource::collection(
                $products
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Enregistrer un ou plusieurs produits
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $products = array();

            foreach ($request->products as $product) {
                $products[] = [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'type' => $product['type'],
                    'created_at' => now(),
                    'created_by' =>  auth()->user()->id,
                ];
            }

            Product::insert($products);

            return $this->sendResponse(new ProductResource($products), 'Prouit(s) créé(s) avec succès.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un produit
     *
     * @param $id
     * @return ProductResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return new ProductResource($product);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour les infos d'un produit
     *
     * @param ProductUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            if(!in_array($this->getRole()->id, [1, 2])){
                return $this->sendError("Vous n'êtes pas autorisé a modifier ce produit");
            }

            $product->update([
                'name' => $request->name ?? $product->name,
                'description' => $request->description ?? $product->description,
                'price' => $request->price ?? $product->price,
                'type' => $request->type ?? $product->type,
                'updated_by' => auth()->user()->id,
            ]);
            $product->save();

            return $this->sendResponse(
                new ProductResource($product),
                "Produit mis à jour avec succès."
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre un ou plusieurs produits en corbeille
     *
     * @param ProductTrashRequest $request
     * @return JsonResponse
     */
    public function trash(ProductTrashRequest $request)
    {
        try {
            Product::whereIn('id', $request->idProducts)->each(function ($product) {
                if(count($product->invoices) === 0){
                    $product->update([
                        'deleted' => true,
                        'deleted_by' => auth()->user()->id,
                    ]);

                    Log::critical("Produit mis en corbeille.", ['product' => $product->id, 'author' => auth()->user()->id]);
                }else{
                    Log::warning("Impossible mettre un produit en corbeille. Dépenses associées !!!", ['product' => $product->id, 'author' => auth()->user()->id]);
                }
            });

            return $this->sendResponse([],  'Produit(s) mis en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Restaurer un ou plusieurs produits de la corbeille
     *
     * @param ProductRestoreRequest $request
     * @return JsonResponse
     */
    public function restore(ProductRestoreRequest $request)
    {
        try {
            $products = Product::whereIn('id', $request->idProducts)
                ->get();

            foreach ($products as $product) {
                $product->update([
                    'deleted' => false,
                    'deleted_by' => auth()->user()->id,
                ]);

                Log::info("Restauration d'un produit de la corbeille.", ['product' => $product->id, 'author' => auth()->user()->id]);
            }

            return response()->json([
                'message' => 'Produit(s) restaurée avec succès.',
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(ProductDestroyRequest $request)
    {
        try {
            Product::whereIn('id', $request->idProducts)->each(function ($product) {
                if(count($product->invoices) === 0){
                    Log::critical("Produit supprimé.", ['product' => $product->id, 'author' => auth()->user()->id]);

                    $product->delete();
                }else{
                    Log::warning("Impossible de supprimer un produit. Dépenses associées !!!", ['product' => $product->id, 'author' => auth()->user()->id]);
                }
            });

            return $this->sendResponse([],  'Produit(s) supprimés avec succès.');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
