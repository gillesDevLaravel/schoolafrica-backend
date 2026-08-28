<?php

namespace App\Http\Controllers;

use App\Http\Requests\Litige\LitigeArchiveRequest;
use App\Http\Requests\Litige\LitigeCreateRequest;
use App\Http\Requests\Litige\LitigeGetRequest;
use App\Http\Requests\Litige\LitigeUpdateRequest;
use App\Http\Resources\LitigeResource;
use App\Models\Litige;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Litiges / Litiges
 *
 * Gestion des Litiges
 */
class LitigeController extends BaseController
{
    /**
     * Afficher la liste des litiges
     *
     * @queryParam isAnonymous boolean Filtre par anonymat. Example: true
     * @queryParam user_id integer Filtre par ID d'utilisateur. Example: 1
     * @queryParam filter_value string Recherche sur le nom ou la description. Example: paiement
     * @queryParam pageItems integer Numéro de page. Example: 1
     * @queryParam nbreItems integer Nombre d'éléments par page. Example: 50
     * @authenticated
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(LitigeGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $filter_value = $request->filter_value ?? null;

            $litiges = Litige::query();

            if ($request->filled('isAnonymous')) {
                $litiges->where('is_anonymous', $request->isAnonymous);
            }

            if ($request->filled('date_start') && $request->filled('date_end')) {
                $litiges->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }

            if ($request->filled('user_id')) {
                $litiges->where('user_id', $request->user_id);
            }

            if ($request->filled('filter_value')) {
                $litiges->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('name', 'like', '%' . $request->filter_value . '%');
                });
            }

            return LitigeResource::collection(
                $litiges
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Créer un litige
     *
     * @bodyParam name string Nom du litige. Example: Problème de facturation
     * @bodyParam description string required Description détaillée du litige. Example: Le montant facturé ne correspond pas au montant convenu.
     * @bodyParam answer string Réponse au litige. Example: Le montant sera ajusté dans la prochaine facture.
     * @bodyParam user_id integer ID de l'utilisateur concerné. Example: 2
     * @bodyParam is_anonymous boolean Si le litige est anonyme. Example: false
     * @bodyParam statut string Statut du litige. Example: nouveau
     * @authenticated
     * @return JsonResponse
     */
    public function store(LitigeCreateRequest $request)
    {
        try {
            $litige = Litige::create([
                'name' => $request['name'] ?? null,
                'description' => $request['description'],
                'answer' => $request['answer'] ?? null,
                'user_id' => $request['user_id'] ?? auth()->id(),
                'is_anonymous' => $request['is_anonymous'] ?? false,
                'created_by' => auth()->id(),
            ]);

            Log::info('Ajout réussi du litige', ['author' => auth()->id(), 'litige' => $litige]);
            return $this->sendResponse(new LitigeResource($litige), 'Litige créé avec succès');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Afficher un litige
     *
     * @urlParam litige integer required ID du litige. Example: 12
     * @authenticated
     * @return LitigeResource|JsonResponse
     */
    public function show(Litige $litige)
    {
        try {
            return new LitigeResource($litige);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Mettre à jour un litige
     *
     * @urlParam litige integer required ID du litige. Example: 12
     * @bodyParam name string Nom du litige. Example: Problème de facturation
     * @bodyParam description string Description détaillée du litige. Example: Le montant facturé ne correspond pas au montant convenu.
     * @bodyParam answer string Réponse au litige. Example: Le montant sera ajusté dans la prochaine facture.
     * @bodyParam user_id integer ID de l'utilisateur concerné. Example: 2
     * @bodyParam is_anonymous boolean Si le litige est anonyme. Example: false
     * @bodyParam statut string Statut du litige. Example: en_cours
     * @authenticated
     * @return JsonResponse
     */
    public function update(LitigeUpdateRequest $request, Litige $litige)
    {
        try {


            $litige->update([
                'name' => $request['name'] ?? $litige->name,
                'description' => $request['description'] ?? $litige->description,
                'answer' => $request['answer'] ?? $litige->answer,
                'user_id' => $request['user_id'] ?? $litige->user_id,
                'is_anonymous' => $request->has('is_anonymous') ? $request['is_anonymous'] : $litige->is_anonymous,
                'updated_by' => auth()->id(),
            ]);

            return $this->sendResponse(LitigeResource::make($litige), 'Litige mis à jour avec succès');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Archiver des litiges (soft delete)
     *
     * @bodyParam ids array required Liste des IDs à archiver. Example: [1,2,3]
     * @bodyParam ids.* integer ID d'un litige existant. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function trash(LitigeArchiveRequest $request)
    {
        try {
            $ids = $request['ids'];

            // Vérifier que l'utilisateur a le droit d'archiver ces litiges
            $userId = auth()->id();
            /*
            $litiges = Litige::whereIn('id', $ids)->get();

            // Vérifier que l'utilisateur est le créateur de tous les litiges
            $unauthorized = $litiges->contains(function ($litige) use ($userId) {
                return $litige->user_id !== $userId && !auth()->user()->hasRole(['admin', 'staff', 'direction']);
            });

            if ($unauthorized) {
                return $this->sendError(__('app.unauthorized'), null, 403);
            }*/

            // Archiver les litiges
            Litige::whereIn('id', $ids)->update([
                'deleted_by' => $userId
            ]);
            Litige::whereIn('id', $ids)->delete();

            Log::info('Litiges archivés', ['user_id' => $userId, 'litige_ids' => $ids]);
            return $this->sendResponse([], 'Litiges archivés avec succès', 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'archivage des litiges', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer des litiges archivés
     *
     * @bodyParam ids array required Liste des IDs à restaurer. Example: [1,2,3]
     * @bodyParam ids.* integer ID d'un litige existant. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function restore(LitigeArchiveRequest $request)
    {
        try {
            $ids = $request['ids'];
            $userId = auth()->id();

            /*/ Vérifier que l'utilisateur a le droit de restaurer ces litiges
            $litiges = Litige::withTrashed()->whereIn('id', $ids)->get();

            // Vérifier que l'utilisateur est admin ou staff
            if (!auth()->user()->hasRole(['admin', 'staff', 'direction'])) {
                return $this->sendError(__('app.unauthorized'), null, 403);
            }*/

            // Restaurer les litiges
            Litige::withTrashed()
                ->whereIn('id', $ids)
                ->update([
                    'deleted_by' => null,
                    'updated_by' => $userId
                ]);

            Litige::withTrashed()->whereIn('id', $ids)->restore();

            Log::info('Litiges restaurés', ['user_id' => $userId, 'litige_ids' => $ids]);
            return $this->sendResponse([], 'Litiges restaurés avec succès', 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des litiges', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement des litiges
     *
     * @bodyParam ids array required Liste des IDs à supprimer définitivement. Example: [1,2,3]
     * @bodyParam ids.* integer ID d'un litige existant. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function destroy(LitigeArchiveRequest $request)
    {
        try {
            $ids = $request['ids'];
            $userId = auth()->id();

            /*// Vérifier que l'utilisateur a le droit de supprimer ces litiges
            $litiges = Litige::withTrashed()->whereIn('id', $ids)->get();

            // Uniquement les admins peuvent supprimer définitivement
            if (!auth()->user()->hasRole('admin')) {
                return $this->sendError(__('app.unauthorized'), null, 403);
            }*/

            // Supprimer définitivement les litiges
            Litige::withTrashed()->whereIn('id', $ids)->forceDelete();

            Log::info('Litiges supprimés définitivement', ['user_id' => $userId, 'litige_ids' => $ids]);
            return $this->sendResponse([], 'Litiges supprimés définitivement', 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des litiges', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
