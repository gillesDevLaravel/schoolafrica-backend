<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tutorial\TutorialArchiveRequest;
use App\Http\Requests\Tutorial\TutorialCreateRequest;
use App\Http\Requests\Tutorial\TutorialGetRequest;
use App\Http\Requests\Tutorial\TutorialUpdateRequest;
use App\Http\Resources\TutorialResource;
use App\Models\Tutorial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @group Tutorials
 *
 * Ce contrôleur gère toutes les opérations CRUD, de filtrage et d'archivage
 * concernant la documentation et les tutoriels du logiciel.
 */
class TutorialController extends BaseController
{
    /**
     * Lister les tutoriels avec possibilité de filtrage et pagination.
     *
     * @bodyParam category string Filtre par catégorie/module. Example: Scolarité
     * @bodyParam target_role string Filtre par rôle cible. Example: admin
     * @bodyParam is_published boolean Filtre par statut de publication. Example: true
     * @bodyParam filter_value string Recherche par mot-clé (titre, description, contenu).
     * @bodyParam pageItems integer Numéro de page. Example: 1
     * @bodyParam nbreItems integer Nombre d'éléments par page. Example: 20
     *
     * @param  TutorialGetRequest  $request
     * @return AnonymousResourceCollection<TutorialResource>|JsonResponse
     */
    public function index(TutorialGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $query = Tutorial::query();

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            if ($request->filled('target_role')) {
                $query->where('target_role', $request->target_role);
            }

            if ($request->has('is_published') && !is_null($request->is_published)) {
                $query->where('is_published', filter_var($request->is_published, FILTER_VALIDATE_BOOLEAN));
            }

            if ($request->filled('filter_value')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->filter_value . '%')
                      ->orWhere('description', 'like', '%' . $request->filter_value . '%')
                      ->orWhere('content', 'like', '%' . $request->filter_value . '%')
                      ->orWhere('category', 'like', '%' . $request->filter_value . '%');
                });
            }

            return TutorialResource::collection(
                $query
                    ->orderBy('order', 'asc')
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Créer un ou plusieurs tutoriels.
     *
     * @param  TutorialCreateRequest  $request
     * @return JsonResponse
     */
    public function create(TutorialCreateRequest $request): JsonResponse
    {
        try {
            $createdTutorials = [];

            if ($request->has('tutorials') && is_array($request->tutorials)) {
                foreach ($request->tutorials as $item) {
                    $tutorial = Tutorial::create([
                        'title'        => $item['title'],
                        'slug'         => $item['slug'] ?? Str::slug($item['title']),
                        'description'  => $item['description'] ?? null,
                        'content'      => $item['content'] ?? null,
                        'video_url'    => $item['video_url'] ?? null,
                        'image'        => $item['image'] ?? null,
                        'document'     => $item['document'] ?? null,
                        'category'     => $item['category'] ?? null,
                        'target_role'  => $item['target_role'] ?? null,
                        'order'        => $item['order'] ?? 0,
                        'is_published' => $item['is_published'] ?? true,
                        'created_by'   => auth()->id(),
                    ]);
                    $createdTutorials[] = new TutorialResource($tutorial);
                }
            } else {
                $tutorial = Tutorial::create([
                    'title'        => $request->title,
                    'slug'         => $request->slug ?? Str::slug($request->title),
                    'description'  => $request->description,
                    'content'      => $request->content,
                    'video_url'    => $request->video_url,
                    'image'        => $request->image,
                    'document'     => $request->document,
                    'category'     => $request->category,
                    'target_role'  => $request->target_role,
                    'order'        => $request->order ?? 0,
                    'is_published' => $request->is_published ?? true,
                    'created_by'   => auth()->id(),
                ]);
                $createdTutorials[] = new TutorialResource($tutorial);
            }

            Log::info('Tutoriel(s) créé(s) avec succès', ['data' => $createdTutorials]);
            return $this->sendResponse($createdTutorials, __('app.create_success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création du tutoriel : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher un tutoriel spécifique.
     *
     * @param  Tutorial  $tutorial
     * @return TutorialResource|JsonResponse
     */
    public function show(Tutorial $tutorial)
    {
        try {
            return new TutorialResource($tutorial);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'affichage du tutoriel : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour un tutoriel.
     *
     * @param  TutorialUpdateRequest  $request
     * @param  Tutorial               $tutorial
     * @return JsonResponse
     */
    public function update(TutorialUpdateRequest $request, Tutorial $tutorial): JsonResponse
    {
        try {
            $data = $request->only([
                'title',
                'slug',
                'description',
                'content',
                'video_url',
                'image',
                'document',
                'category',
                'target_role',
                'order',
                'is_published',
            ]);

            if (isset($data['title']) && empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            $data['updated_by'] = auth()->id();

            $tutorial->update(array_filter($data, function ($value) {
                return !is_null($value);
            }));

            Log::info('Tutoriel mis à jour avec succès', ['tutorial_id' => $tutorial->id]);
            return $this->sendResponse(new TutorialResource($tutorial), __('app.update_success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du tutoriel : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver (soft delete) un ou plusieurs tutoriels.
     *
     * @param  TutorialArchiveRequest  $request
     * @return JsonResponse
     */
    public function trash(TutorialArchiveRequest $request): JsonResponse
    {
        try {
            Tutorial::whereIn('id', $request->ids)->update([
                'deleted'    => true,
                'deleted_by' => auth()->id(),
            ]);
            Tutorial::whereIn('id', $request->ids)->delete();

            Log::info('Tutoriels archivés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.trash_success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'archivage des tutoriels : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer des tutoriels archivés.
     *
     * @param  TutorialArchiveRequest  $request
     * @return JsonResponse
     */
    public function restore(TutorialArchiveRequest $request): JsonResponse
    {
        try {
            Tutorial::withTrashed()->whereIn('id', $request->ids)->update([
                'deleted'    => false,
                'deleted_by' => null,
            ]);
            Tutorial::withTrashed()->whereIn('id', $request->ids)->restore();

            Log::info('Tutoriels restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.restore_success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des tutoriels : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement des tutoriels.
     *
     * @param  TutorialArchiveRequest  $request
     * @return JsonResponse
     */
    public function destroy(TutorialArchiveRequest $request): JsonResponse
    {
        try {
            Tutorial::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Tutoriels supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.delete_success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des tutoriels : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
