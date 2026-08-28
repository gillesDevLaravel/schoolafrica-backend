<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequeteRequest;
use App\Http\Requests\TypeRequete\TypeRequeteArchiveRequest;
use App\Http\Resources\Staffs\TypeRequeteResource;
use App\Models\Requete;
use App\Models\TypeRequete;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Type Requete
 */
class TypeRequeteController extends BaseController
{
    /**
     * Lister tous les types de requêtes créés
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return TypeRequeteResource::collection(TypeRequete::orderBy('name')->get());
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un type de requête
     *
     * @urlParam id int required
     * @return TypeRequeteResource|\Illuminate\Http\Response
     */
    public function show($idTypeRequete)
    {
        try {
            return TypeRequeteResource::make(TypeRequete::findOrFail($idTypeRequete));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un nouveau type de requête
     *
     * @param TypeRequeteRequest $request
     * @return TypeRequeteResource|\Illuminate\Http\Response
     */
    public function store(TypeRequeteRequest $request)
    {
        try {
            $type_requete = TypeRequete::create([
                'name' => $request->name,
                'created_by' => auth()->user()->id
            ]);

            return TypeRequeteResource::make($type_requete);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour le nom d'un type de requête
     *
     * @urlParam $idTypeRequete int required
     * @param TypeRequeteRequest $request
     * @return TypeRequeteResource|\Illuminate\Http\Response
     */
    public function update(TypeRequeteRequest $request, $idTypeRequete)
    {
        try {
            $type_requete = TypeRequete::findOrFail($idTypeRequete);
            $type_requete->name = $request->name ?? $type_requete->name;
            $type_requete->updated_by = auth()->user()->id;
            $type_requete->save();

            return TypeRequeteResource::make($type_requete);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un type de requête (NB: Seulement si il n'a pas de requete associé)
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $type_requete = TypeRequete::findOrFail($id);

            $requetes = Requete::where('idTypeRequete', $id)->count();

            if($requetes != 0){
                return $this->sendError("Impossible de supprimer ce type de requête, car il contient des requetes!");
            }

            $type_requete->delete();

            return response()->json([], 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des types de requêtes à la corbeille (soft delete).
     *
     * @param  TypeRequeteArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(TypeRequeteArchiveRequest $request): JsonResponse
    {
        try {
            TypeRequete::whereIn('id', $request->ids)->delete();
            Log::info('TypeRequetes mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des types de requêtes supprimés (soft delete).
     *
     * @param  TypeRequeteArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(TypeRequeteArchiveRequest $request): JsonResponse
    {
        try {
            TypeRequete::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('TypeRequetes restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des types de requêtes (hard delete).
     *
     * @param  TypeRequeteArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(TypeRequeteArchiveRequest $request): JsonResponse
    {
        try {
            TypeRequete::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('TypeRequetes supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
