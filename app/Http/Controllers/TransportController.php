<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transport\TransportArchiveRequest;
use App\Http\Requests\Transport\TransportCreateRequest;
use App\Http\Requests\Transport\TransportGetRequest;
use App\Http\Requests\Transport\TransportUpdateRequest;
use App\Http\Resources\TransportResource;
use App\Models\Transport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * Contrôleur de gestion des transports
 *
 * Ce contrôleur permet de gérer les opérations CRUD sur les entités Transport :
 * - Liste des transports
 * - Création d'un transport
 * - Consultation d'un transport
 * - Mise à jour d'un transport
 * - Suppression temporaire (mise à la corbeille)
 * - Restauration d'un transport supprimé
 * - Suppression définitive
 *
 * @group Transports
 */
class TransportController extends BaseController
{
    /**
     * Récupère la liste paginée des transports.
     *
     * Permet de filtrer par nom ou description via le paramètre `filter_value`.
     * La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).
     *
     * @param TransportGetRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(TransportGetRequest $request): AnonymousResourceCollection
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $query = Transport::query();

            // Application du filtre si fourni
            if ($request->filled('filter_value')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('description', 'like', '%' . $request->filter_value . '%');
                });
            }

            // Retourne les résultats paginés
            return TransportResource::collection(
                $query->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical('Erreur lors de la récupération des transports : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée un nouveau transport.
     *
     * @param TransportCreateRequest $request
     * @return JsonResponse
     */
    public function create(TransportCreateRequest $request): JsonResponse
    {
        try {
            $transport = Transport::create($request->validated());

            Log::info('Transport créé avec succès', ['author' => auth()->id(), 'transport' => $transport]);

            return $this->sendResponse(
                new TransportResource($transport),
                __('transport.create.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création du transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'un transport.
     *
     * @param Transport $transport
     * @return TransportResource
     */
    public function show(Transport $transport): TransportResource
    {
        return new TransportResource($transport);
    }

    /**
     * Met à jour un transport existant.
     *
     * @param TransportUpdateRequest $request
     * @param Transport $transport
     * @return JsonResponse
     */
    public function update(TransportUpdateRequest $request, Transport $transport): JsonResponse
    {
        try {
            $transport->update($request->validated() + ['updated_by' => auth()->id()]);

            Log::info('Transport mis à jour avec succès', ['author' => auth()->id(), 'transport' => $transport]);

            return $this->sendResponse(
                new TransportResource($transport),
                __('transport.update.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime temporairement un ou plusieurs transports (mise à la corbeille).
     *
     * @param TransportArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(TransportArchiveRequest $request): JsonResponse
    {
        try {
            Transport::whereIn('id', $request->ids)->delete();
            return $this->sendResponse([], __('transport.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des transports : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure un ou plusieurs transports supprimés.
     *
     * @param TransportArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(TransportArchiveRequest $request): JsonResponse
    {
        try {
            Transport::withTrashed()->whereIn('id', $request->ids)->restore();
            return $this->sendResponse([], __('transport.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des transports : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement un ou plusieurs transports.
     *
     * @param TransportArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(TransportArchiveRequest $request): JsonResponse
    {
        try {
            Transport::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            return $this->sendResponse([], __('transport.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des transports : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
