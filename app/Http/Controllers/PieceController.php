<?php

namespace App\Http\Controllers;

use App\Http\Requests\Piece\PieceArchiveRequest;
use App\Http\Requests\Piece\PieceCreateRequest;
use App\Http\Requests\Piece\PieceGetRequest;
use App\Http\Requests\Piece\PieceUpdateRequest;
use App\Http\Resources\PieceResource;
use App\Models\Piece;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;


/**
 * @group Gestion des Pieces
 *
 * Ce contrôleur gère toutes les opérations CRUD et d’archivage
 * concernant les pièces (ex: salles, espaces).
 */
class PieceController extends BaseController
{
    /**
     * Affiche la liste des pièces avec possibilité de filtrage.
     *
     * Filtres disponibles :
     * - name (recherche partielle)
     * - etage (exact)
     * - status (exact)
     *
     * @param  PieceGetRequest  $request
     * @return AnonymousResourceCollection<PieceResource>
     */
    public function index(PieceGetRequest $request): AnonymousResourceCollection
    {
        try {
            $query = Piece::query();
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('etage')) {
                $query->where('etage', $request->etage);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            return PieceResource::collection($query->orderBy('id', 'desc')->paginate(1000000));
        } catch (\Throwable $th) {
            Log::critical('Erreur lors de la récupération des pièces : ' . $th->getMessage());
            return PieceResource::collection(collect());
        }
    }

    /**
     * Crée une nouvelle pièce.
     *
     * @param  PieceCreateRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "name": "Salle Informatique",
     *   "etage": "2ème étage",
     *   "description": "Salle équipée de 20 ordinateurs",
     *   "status": "Disponible"
     * }
     */
    public function create(PieceCreateRequest $request): JsonResponse
    {
    try {
        $data = [];
        foreach ($request->pieces as $piece) {
            $data[] = [
                'name'        => $piece['name'],
                'etage'       => $piece['etage'],
                'description' => $piece['description'] ?? null,
                'status'      => $piece['status'],
                'created_by'  => auth()->id(),
            ];
        }
        Piece::insert($data);
        Log::info('Pièces créées avec succès', ['pieces' => $data]);
        return $this->sendResponse($data, __('piece.create.success'));
    } catch (\Throwable $th) {
        Log::error('Erreur lors de la création des pièces : ' . $th->getMessage());
        return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
    }
   }

    /**
     * Affiche une pièce spécifique.
     *
     * @param  Piece  $piece
     * @return PieceResource|JsonResponse
     */
    public function show(Piece $piece): PieceResource
    {
        try {
            return new PieceResource($piece);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour de la pièce : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met à jour une pièce existante.
     *
     * @param  PieceUpdateRequest  $request
     * @param  Piece               $piece
     * @return JsonResponse
     */
    public function update(PieceUpdateRequest $request, Piece $piece): JsonResponse
    {
        try {
            $piece->update([
                'name'        => $request['name'] ?? $piece['name'],
                'etage'       => $request['etage'] ?? $piece['etage'],
                'description' => $request['description'] ?? $piece['description'],
                'status'      => $request['status'] ?? $piece['status'],
                'updated_by'  => auth()->id(),
            ]);
            Log::info('Pièce mise à jour avec succès', ['piece' => $piece]);
            return $this->sendResponse(new PieceResource($piece), __('piece.update.success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour de la pièce : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des pièces à la corbeille (soft delete).
     *
     * @param  PieceArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trash(PieceArchiveRequest $request): JsonResponse
    {
        try {
            Piece::whereIn('id', $request->ids)->delete();
            Log::info('Pièces mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('piece.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des pièces : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des pièces supprimées (soft delete).
     *
     * @param  PieceArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restore(PieceArchiveRequest $request): JsonResponse
    {
        try {
            Piece::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Pièces restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('piece.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des pièces : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des pièces (hard delete).
     *
     * @param  PieceArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroy(PieceArchiveRequest $request): JsonResponse
    {
        try {
            Piece::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Pièces supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('piece.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des pièces : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
