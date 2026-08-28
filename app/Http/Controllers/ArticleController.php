<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\ArticleArchiveRequest;
use App\Http\Requests\Article\ArticleCreateRequest;
use App\Http\Requests\Article\ArticleGetRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Articles
 *
 * Gestion des articles
 */
class ArticleController extends BaseController
{
    /**
     * Afficher la liste des articles
     */
    public function index(ArticleGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $expired = $request->get('expired');
            $idSchool = $request->get('idSchool');
            $idSection = $request->get('idSection');

            $articles = Article::query()
                ->when($request->type, function ($q) use ($request) {
                    return $q->where('type', $request->type);
                })
                ->when($idSchool, function ($q) use ($idSchool) {
                    return $q->where('idSchool', $idSchool);
                })
                ->when($idSection, function ($q) use ($idSection) {
                    return $q->where('idSection', $idSection);
                })
//                ->when($request->service_id, function ($q) use ($request) {
//                    return $q->where('service_id', $request->service_id);
//                })
                ->when($request->hotel_id, function ($q) use ($request) {
                    return $q->whereHas('service', function ($query) use ($request) {
                        return $query->where('hotel_id', $request->hotel_id);
                    });
                })
                ->when($request->filter_value, function ($q) use ($request) {
                    $q->where(function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->filter_value}%")
                            ->orWhere('reference', 'like', "%{$request->filter_value}%")
                            ->orWhere('description', 'like', "%{$request->filter_value}%");
//                            ->orWhereHas('service', function ($query) use ($request) {
//                                $query->where('name', 'like', "%{$request->filter_value}%");
//                            });
                    });
                });

            if (isset($request['expired'])) {
                $articles->where('expiry_date', $expired ? '<' : '>', now());
            }

            return ArticleResource::collection($articles
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Enregistrer des articles
     */
    public function create(ArticleCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction(); // Ajouté pour plus de clarté

            $author = auth()->user()->id;
            $newArticles = [];

            foreach ($request->validated()['articles'] as $article) {
                $reference = generateReferenceNumber(Article::class, 'reference', 6);
                $newArticle = Article::create([
                    'reference' => $reference,
                    'idSchool' => $article['idSchool'],
                    'idSection' => $article['idSection'] ?? null,
                    'name' => $article['name'],
                    'type' => $article['type'],
                    'image' => $article['image'] ?? null, // ou $fileName si tu veux gérer l’image
                    'price' => $article['price'],
                    'description' => $article['description'] ?? null,
                    'unit_of_measurement' => $article['unit_of_measurement'] ?? null,
                    'alert_quantity' => $article['alert_quantity'] ?? null,
                    'expiry_date' => $article['expiry_date'] ?? null,

                    'container' => $article['container'] ?? null,
                    'container_unit' => $article['container_unit'] ?? null,
                    'container_quantity' => $article['container_quantity'] ?? null,
                    'detail' => $article['detail'] ?? null,

//                    'service_id' => $article['service_id'],
                    'created_by' => $author,
                ]);

                // Ajout des fournisseurs
                if (! empty($article['suppliers'])) {
                    $newArticle->suppliers()->sync($article['suppliers']);
                }

                $newArticles[] = $newArticle;
            }

            DB::commit();

            Log::info('Ajout réussi des articles', ['author' => $author, 'articles' => $newArticles]);

            return $this->sendResponse(ArticleResource::collection($newArticles), __('article.create.success'), 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Afficher un article spécifique
     */
    public function show(Article $article)
    {
        try {
            return new ArticleResource($article);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Modifier un article spécifique
     */
    public function update(ArticleUpdateRequest $request, Article $article): JsonResponse
    {
        try {
            $author = auth()->id();
            $article->update([
                'idSchool' => $request['idSchool'] ?? $article['idSchool'],
                'idSection' => $request['idSection'] ?? $article['idSection'],
                'name' => $request['name'] ?? $article['name'],
                'type' => $request['type'] ?? $article['type'],
                'image' => $request['image'] ?? $article['image'], // $request['file_name'] ?? $article['image'],
                'price' => $request['price'] ?? $article['price'],
                'description' => $request['description'] ?? $article['description'],
                'unit_of_measurement' => $request['unit_of_measurement'] ?? $article['unit_of_measurement'],
                'alert_quantity' => $request['alert_quantity'] ?? $article['alert_quantity'],
                'expiry_date' => $request['expiry_date'] ?? $article['expiry_date'],

                'container' => $request['container'] ?? $article['container'],
                'container_unit' => $request['container_unit'] ?? $article['container_unit'],
                'container_quantity' => $request['container_quantity'] ?? $article['container_quantity'],
                'detail' => $request['detail'] ?? $article['detail'],

//                'service_id' => $request['service_id'] ?? $article['service_id'],
                'updated_by' => auth()->id(),
            ]);

            Log::info('Mise à jour de l\'article', ['article' => $article->id, 'author' => $author]);

            return $this->sendResponse(new ArticleResource($article), __('article.update.success'), 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction pour le multiple archivage des articles
     * @param ArticleArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(ArticleArchiveRequest $request): JsonResponse
    {
        try {
            $article_ids = $request['ids'] ?? null;

            // Désactiver les articles
            Article::whereIn('id', $article_ids)->delete();

            return $this->sendResponse([], __('article.trashed.success'), 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de restauration multiples des articles
     * @param ArticleArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(ArticleArchiveRequest $request): JsonResponse
    {
        try {
            $article_ids = $request['ids'] ?? null;

            // Restaurer les articles
            Article::withTrashed()->whereIn('id', $article_ids)->restore();

            return $this->sendResponse([], __('article.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des articles
     *
     * @param ArticleArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(ArticleArchiveRequest $request): JsonResponse
    {
        try {
            $article_ids = $request['ids'] ?? null;

            // Suppression définitive
            Article::withTrashed()->whereIn('id', $article_ids)->forceDelete();

            return $this->sendResponse([], __('article.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }
}
