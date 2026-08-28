<?php

namespace App\Http\Controllers;

use App\Http\Requests\Memo\MemoArchiveRequest;
use App\Http\Requests\Memo\MemoCreateRequest;
use App\Http\Requests\Memo\MemoGetRequest;
use App\Http\Requests\Memo\MemoUpdateRequest;
use App\Http\Resources\MemoResource;
use App\Models\Memo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Memos
 *
 * Ce contrôleur gère toutes les opérations CRUD et d'archivage
 * concernant les mémos.
 */
class MemoController extends BaseController
{
    /**
     * Lister les mémos avec possibilité de filtrage.
     *
     * @bodyParam name string Filtre par nom. Example: Conseil
     * @bodyParam type string Filtre par type. Example: Information
     * @bodyParam date string Filtre par date. Example: 2026-03-12
     * @bodyParam date_start string Filtre à partir de cette date. Example: 2026-03-01
     * @bodyParam date_end string Filtre jusqu'à cette date. Example: 2026-03-31
     * @bodyParam filter_value string Recherche globale. Example: important
     * @bodyParam pageItems integer Numéro de page. Example: 1
     * @bodyParam nbreItems integer Nombre d'éléments par page. Example: 20
     *
     * @param  MemoGetRequest  $request
     * @return AnonymousResourceCollection<MemoResource>
     */
    public function index(MemoGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $memos = Memo::query();

            
            if ($request->filled('type')) {
                $memos->where('type', $request->type);
            }

            if ($request->filled('date')) {
                $memos->whereDate('date', $request->date);
            }

            if ($request->filled('date_start') && $request->filled('date_end')) {
                $memos->whereBetween('date', [$request->date_start, $request->date_end]);
            }

            if ($request->filled('filter_value')) {
                $memos->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('name', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('type', 'like', '%' . $request->filter_value . '%');
                });
            }

            return MemoResource::collection(
                $memos
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Créer un ou plusieurs mémos.
     *
     * @bodyParam memos array required Liste des mémos à créer.
     * @bodyParam memos[].name string required Nom du mémo. Example: Conseil d'Administration
     * @bodyParam memos[].description string required Description du mémo. Example: Informations importantes
     * @bodyParam memos[].type string Type du mémo. Example: Information
     * @bodyParam memos[].date string Date du mémo. Example: 2026-03-12
     * @bodyParam memos[].image string URL de l'image. Example: https://example.com/image.jpg
     *
     * @param  MemoCreateRequest  $request
     * @return JsonResponse
     */
    public function create(MemoCreateRequest $request): JsonResponse
    {
        try {
            $data = [];
            foreach ($request->memos as $memo) {
                $data[] = [
                    'name'        => $memo['name'],
                    'type'        => $memo['type'] ?? null,
                    'description' => $memo['description'],
                    'date'        => $memo['date'] ?? null,
                    'image'        => $memo['image'] ?? null,
                    'created_by'  => auth()->id(),
                ];
            }
            Memo::insert($data);
            Log::info('Mémos créés avec succès', ['memos' => $data]);
            return $this->sendResponse($data, __('memo.create.success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création des mémos : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher un mémo spécifique.
     *
     * @urlParam memo integer required ID du mémo. Example: 12
     * @param  Memo  $memo
     * @return MemoResource|JsonResponse
     */
    public function show(Memo $memo)
    {
        try {
            return new MemoResource($memo);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'affichage du mémo : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour un mémo.
     *
     * @urlParam memo integer required ID du mémo. Example: 12
     * @bodyParam name string Nom du mémo. Example: Conseil d'Administration
     * @bodyParam description string Description du mémo. Example: Informations importantes
     * @bodyParam type string Type du mémo. Example: Information
     * @bodyParam date string Date du mémo. Example: 2026-03-12
     * @bodyParam image string URL de l'image. Example: https://example.com/image.jpg
     *
     * @param  MemoUpdateRequest  $request
     * @param  Memo               $memo
     * @return JsonResponse
     */
    public function update(MemoUpdateRequest $request, Memo $memo): JsonResponse
    {
        try {
            $memo->update([
                'name'        => $request['name'] ?? $memo['name'],
                'type'        => $request['type'] ?? $memo['type'],
                'description' => $request['description'] ?? $memo['description'],
                'date'        => $request['date'] ?? $memo['date'],
                'image'        => $request['image'] ?? $memo['image'],
                'updated_by'  => auth()->id(),
            ]);
            Log::info('Mémo mis à jour avec succès', ['memo' => $memo]);
            return $this->sendResponse(new MemoResource($memo), __('memo.update.success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du mémo : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver des mémos.
     *
     * @bodyParam ids array required Liste des IDs à archiver. Example: [1,2,3]
     * @bodyParam ids.* integer required ID d'un mémo existant. Example: 1
     *
     * @param  MemoArchiveRequest  $request
     * @return JsonResponse
     */
    public function trash(MemoArchiveRequest $request): JsonResponse
    {
        try {
            Memo::whereIn('id', $request->ids)->delete();
            Log::info('Mémos archivés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('memo.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'archivage des mémos : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer des mémos archivés.
     *
     * @bodyParam ids array required Liste des IDs à restaurer. Example: [1,2,3]
     * @bodyParam ids.* integer required ID d'un mémo existant. Example: 1
     *
     * @param  MemoArchiveRequest  $request
     * @return JsonResponse
     */
    public function restore(MemoArchiveRequest $request): JsonResponse
    {
        try {
            Memo::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Mémos restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('memo.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des mémos : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement des mémos.
     *
     * @bodyParam ids array required Liste des IDs à supprimer. Example: [1,2,3]
     * @bodyParam ids.* integer required ID d'un mémo existant. Example: 1
     *
     * @param  MemoArchiveRequest  $request
     * @return JsonResponse
     */
    public function destroy(MemoArchiveRequest $request): JsonResponse
    {
        try {
            Memo::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Mémos supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('memo.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des mémos : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
