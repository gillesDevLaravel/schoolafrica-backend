<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransportUser\TransportUserArchiveRequest;
use App\Http\Requests\TransportUser\TransportUserCreateRequest;
use App\Http\Requests\TransportUser\TransportUserGetRequest;
use App\Http\Requests\TransportUser\TransportUserUpdateRequest;
use App\Http\Resources\TransportUserResource;
use App\Models\TransportUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * Contrôleur de gestion des utilisateurs de transport
 *
 * Ce contrôleur permet de gérer les opérations CRUD sur les entités TransportUser :
 * - Liste des utilisateurs de transport
 * - Création d'un utilisateur de transport
 * - Consultation d'un utilisateur de transport
 * - Mise à jour d'un utilisateur de transport
 * - Suppression temporaire (mise à la corbeille)
 * - Restauration d'un utilisateur de transport supprimé
 * - Suppression définitive
 *
 * @group Gestion des Utilisateurs de Transport
 */
class TransportUserController extends BaseController
{
    /**
     *  Récupère la liste paginée des utilisateurs de transport.
     *
     *  Permet de filtrer par type et/ou student_id.
     *  La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).
     *
     * @param TransportUserGetRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(TransportUserGetRequest $request): AnonymousResourceCollection
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $query = TransportUser::query();

            // Filtrage par type si fourni
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            // Filtrage par student_id si fourni
            if ($request->filled('student_id')) {
                $query->where('student_id', $request->student_id);
            }

            // Retourne les résultats paginés
            return TransportUserResource::collection(
                $query->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical('Erreur lors de la récupération des utilisateurs de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée un nouvel utilisateur de transport.
     *
     * @param TransportUserCreateRequest $request
     * @return JsonResponse
     */
    public function create(TransportUserCreateRequest $request): JsonResponse
    {
        try {
            $transportUser = TransportUser::create($request->validated());

            Log::info('Utilisateur de transport créé avec succès', [
                'author' => auth()->id(),
                'transportUser' => $transportUser
            ]);

            return $this->sendResponse(
                new TransportUserResource($transportUser),
                __('transportUser.create.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création de l’utilisateur de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'un utilisateur de transport.
     *
     * @param TransportUser $transportUser
     * @return TransportUserResource
     */
    public function show(TransportUser $transportUser): TransportUserResource
    {
        return new TransportUserResource($transportUser);
    }

    /**
     * Met à jour un utilisateur de transport existant.
     *
     * @param TransportUserUpdateRequest $request
     * @param TransportUser $transportUser
     * @return JsonResponse
     */
    public function update(TransportUserUpdateRequest $request, TransportUser $transportUser): JsonResponse
    {
        try {
            $transportUser->update($request->validated() + ['updated_by' => auth()->id()]);

            Log::info('Utilisateur de transport mis à jour avec succès', [
                'author' => auth()->id(),
                'transportUser' => $transportUser
            ]);

            return $this->sendResponse(
                new TransportUserResource($transportUser),
                __('transportUser.update.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour de l’utilisateur de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime temporairement un ou plusieurs utilisateurs de transport (mise à la corbeille).
     *
     * @param TransportUserArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(TransportUserArchiveRequest $request): JsonResponse
    {
        try {
            TransportUser::whereIn('id', $request->ids)->delete();
            return $this->sendResponse([], __('transportUser.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des utilisateurs de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure un ou plusieurs utilisateurs de transport supprimés.
     *
     * @param TransportUserArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(TransportUserArchiveRequest $request): JsonResponse
    {
        try {
            TransportUser::withTrashed()->whereIn('id', $request->ids)->restore();
            return $this->sendResponse([], __('transportUser.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des utilisateurs de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement un ou plusieurs utilisateurs de transport.
     *
     * @param TransportUserArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(TransportUserArchiveRequest $request): JsonResponse
    {
        try {
            TransportUser::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            return $this->sendResponse([], __('transportUser.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des utilisateurs de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
