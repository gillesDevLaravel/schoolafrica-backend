<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExplanationRequest\ExplanationRequestArchiveRequest;
use App\Http\Requests\ExplanationRequest\ExplanationRequestCreateRequest;
use App\Http\Requests\ExplanationRequest\ExplanationRequestGetRequest;
use App\Http\Requests\ExplanationRequest\ExplanationRequestUpdateRequest;
use App\Http\Resources\ExplanationRequestResource;
use App\Models\ExplanationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;


/**
 * @group Explanation Requests
 *
 * Ce contrôleur gère toutes les opérations CRUD et d'archivage
 * concernant les demandes d'explication.
 */
class ExplanationRequestController extends BaseController
{
    /**
     * Lister les demandes d'explication.
     *
     * Retourne la liste paginée des demandes d'explication avec filtres optionnels.
     *
     * @bodyParam name string Filtre par nom. Example: Jean
     * @bodyParam idUser integer Filtre par utilisateur concerné. Example: 15
     * @bodyParam idResponsable integer Filtre par responsable. Example: 3
     * @bodyParam date string Filtre par date métier. Example: 2026-03-11
     * @bodyParam date_start string Filtre sur created_at à partir de cette date. Example: 2026-03-01
     * @bodyParam date_end string Filtre sur created_at jusqu'à cette date. Example: 2026-03-31
     * @bodyParam pageItems integer Numéro de page. Example: 1
     * @bodyParam nbreItems integer Nombre d'éléments par page. Example: 20
     *
     * @param  ExplanationRequestGetRequest  $request
     * @return AnonymousResourceCollection<ExplanationRequestResource>
     */
    public function index(ExplanationRequestGetRequest $request): AnonymousResourceCollection
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $query = ExplanationRequest::query();

            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('idUser')) {
                $query->where('idUser', $request->idUser);
            }
            if ($request->filled('idResponsable')) {
                $query->where('idResponsable', $request->idResponsable);
            }
            if ($request->filled('date')) {
                $query->where('date', $request->date);
            }
            if ($request->filled('date_start')) {
                $query->whereDate('created_at', '>=', $request->date_start);
            }
            if ($request->filled('date_end')) {
                $query->whereDate('created_at', '<=', $request->date_end);
            }
            return ExplanationRequestResource::collection(
                $query->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical('Erreur lors de la récupération des demandes d\'explication : ' . $th->getMessage());
            return ExplanationRequestResource::collection(collect());
        }
    }

    /**
     * Créer une ou plusieurs demandes d'explication.
     *
     * @bodyParam explanation_requests array required Liste des demandes à créer.
     * @bodyParam explanation_requests[].name string required Nom affiché sur la demande. Example: Jean Dupont
     * @bodyParam explanation_requests[].description string required Description de la demande. Example: Absence non justifiée
     * @bodyParam explanation_requests[].date string Date métier associée à la demande. Example: 2026-03-11
     * @bodyParam explanation_requests[].idUser integer required Identifiant de l'utilisateur concerné. Example: 15
     * @bodyParam explanation_requests[].idResponsable integer required Identifiant du responsable. Example: 3
     * @bodyParam explanation_requests[].image string URL ou chemin de l'image jointe. Example: https://example.com/image.jpg
     * @bodyParam explanation_requests[].comments string Commentaires additionnels. Example: Demande envoyée par le parent
     *
     * Exemple payload attendu :
     * {
     *   "explanation_requests": [
     *     {
     *       "name": "Jean Dupont",
     *       "description": "Retard répété",
     *       "idUser": 1,
     *       "idResponsable": 2
     *     }
     *   ]
     * }
     */
    public function create(ExplanationRequestCreateRequest $request): JsonResponse
    {
    try {
        $data = [];
        foreach ($request->explanation_requests as $explanationRequest) {
            $data[] = [
                'name' => $explanationRequest['name'],
                'description' => $explanationRequest['description'],
                'date' => $explanationRequest['date'] ?? null,
                'idUser' => $explanationRequest['idUser'],
                'idResponsable' => $explanationRequest['idResponsable'],
                'image' => $explanationRequest['image'] ?? null,
                'comments' => $explanationRequest['comments'] ?? null,
                'created_by' => auth()->id(),
                'created_at' => now(),
            ];
        }
        ExplanationRequest::insert($data);
        Log::info('Demandes d\'explication créées avec succès', ['explanation_requests' => $data]);
        return $this->sendResponse($data, __('explanation_request.create.success'));
    } catch (\Throwable $th) {
        Log::error('Erreur lors de la création des demandes d\'explication : ' . $th->getMessage());
        return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
    }
   }

    /**
     * Afficher une demande d'explication.
     *
     * @urlParam explanationRequest integer required ID de la demande d'explication. Example: 12
     * @param  ExplanationRequest  $explanationRequest
     * @return ExplanationRequestResource|JsonResponse
     */
    public function show(ExplanationRequest $explanationRequest)
    {
        try {
            return new ExplanationRequestResource($explanationRequest);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'affichage de la demande d\'explication : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour une demande d'explication.
     *
     * Tous les champs sont optionnels, mais ceux envoyés doivent être valides.
     *
     * @urlParam explanationRequest integer required ID de la demande d'explication. Example: 12
     * @bodyParam name string Nom affiché sur la demande. Example: Jean Dupont
     * @bodyParam description string Description de la demande. Example: Retard répété
     * @bodyParam date string Date métier associée à la demande. Example: 2026-03-11
     * @bodyParam idUser integer Identifiant de l'utilisateur concerné. Example: 15
     * @bodyParam idResponsable integer Identifiant du responsable. Example: 3
     * @bodyParam image string URL ou chemin de l'image jointe. Example: https://example.com/image.jpg
     * @bodyParam comments string Commentaires additionnels. Example: Pièce justificative ajoutée
     */
    public function update(ExplanationRequestUpdateRequest $request, ExplanationRequest $explanationRequest): JsonResponse
    {
        try {
            $explanationRequest->update([
                'name' => $request['name'] ?? $explanationRequest['name'],
                'description' => $request['description'] ?? $explanationRequest['description'],
                'date' => $request['date'] ?? $explanationRequest['date'],
                'idUser' => $request['idUser'] ?? $explanationRequest['idUser'],
                'idResponsable' => $request['idResponsable'] ?? $explanationRequest['idResponsable'],
                'image' => $request['image'] ?? $explanationRequest['image'],
                'comments' => $request['comments'] ?? $explanationRequest['comments'],
                'updated_by' => auth()->id(),
            ]);
            Log::info('Demande d\'explication mise à jour avec succès', ['explanation_request' => $explanationRequest]);
            return $this->sendResponse(new ExplanationRequestResource($explanationRequest), __('explanation_request.update.success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour de la demande d\'explication : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver des demandes d'explication.
     *
     * @bodyParam ids array required Liste des IDs à archiver. Example: [1,2,3]
     * @bodyParam ids.* integer required ID d'une demande existante. Example: 1
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trash(ExplanationRequestArchiveRequest $request): JsonResponse
    {
        try {
            ExplanationRequest::whereIn('id', $request->ids)->delete();
            Log::info('Demandes d\'explication mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('explanation_request.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des demandes d\'explication : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer des demandes d'explication archivées.
     *
     * @bodyParam ids array required Liste des IDs à restaurer. Example: [1,2,3]
     * @bodyParam ids.* integer required ID d'une demande existante. Example: 1
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restore(ExplanationRequestArchiveRequest $request): JsonResponse
    {
        try {
            ExplanationRequest::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Demandes d\'explication restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('explanation_request.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des demandes d\'explication : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement des demandes d'explication.
     *
     * @bodyParam ids array required Liste des IDs à supprimer définitivement. Example: [1,2,3]
     * @bodyParam ids.* integer required ID d'une demande existante. Example: 1
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroy(ExplanationRequestArchiveRequest $request): JsonResponse
    {
        try {
            ExplanationRequest::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Demandes d\'explication supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('explanation_request.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des demandes d\'explication : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
