<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LocationAllRequest;
use App\Http\Requests\Admin\LocationStoreRequest;
use App\Http\Requests\Location\LocationArchiveRequest;
use App\Http\Resources\Admin\LocationResource;
use App\Models\Book;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Location
 */
class LocationController extends BaseController
{
    /**
     * Lister les locations
     *
     * @param LocationAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(LocationAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $locations = Location::query();

            if(!is_null($request->idSchool)) $locations = $locations->where('idSchool', $request->idSchool);
            if(!is_null($request->idSection)) $locations = $locations->where('idSection', $request->idSection);
            if(!is_null($request->idUser)) $locations = $locations->where('idUser', $request->idUser);
            if(!is_null($request->status)) $locations = $locations->where('status', $request->status);

            if(!is_null($filter_value)){
                $locations->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhereHas('book', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return LocationResource::collection(
                $locations
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une location
     *
     * @urlParam $id integer required
     * @return LocationResource|\Illuminate\Http\Response
     */
    public function show($idLocation)
    {
        try {
            $location = Location::findOrFail($idLocation);
            return LocationResource::make($location);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une nouvelle location de livre
     *
     * @param LocationStoreRequest $request
     * @return LocationResource|\Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        try {
            $book = Book::where([
                'id' => $request->idBook,
                'status' => 'available'
            ])->first();

            if(is_null($book)){
                return $this->sendError("Erreur lors de la récupération du livre", "");
            }

            $location = Location::create([
                'idUser' => $request->idUser,
                'idBook' => $request->idBook,
                'date_sortie' => $request->date_sortie,
                'date_retour' => $request->date_retour ?? null,
                'reason' => $request->reason,
                'status' => "in_progress",
                'observation' => $request->observation ?? null,
                'idSchool' => $request->idSchool ?? null,
                'idSection' => $request->idSection ?? null,
                'created_by' => auth()->user()->id,
            ]);

            $book->update([
                'status' => 'unavailable'
            ]);

            return LocationResource::make($location);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un location
     *
     * @param LocationStoreRequest $request
     * @urlParam $id integer
     * @return LocationResource|\Illuminate\Http\Response
     */
    public function update(LocationStoreRequest $request, $id)
    {
        try {
            $location = Location::findOrFail($id);
            $book = $location->book;

            $location->update([
                'date_sortie' => $request->date_sortie,
                'date_retour' => $request->date_retour ?? null,
                'reason' => $request->reason,
                'status' => $request->status ?? $location->status,
                'observation' => $request->observation ?? null,
                'idSchool' => $request->idSchool ?? null,
                'idSection' => $request->idSection ?? null,
                'updated_by' => auth()->user()->id,
            ]);

            // On remet le livre à 'disponible'
            if($request->status == "finished"){
                $book->update([
                    'status' => 'available'
                ]);
            }

            return LocationResource::make($location);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une location de livres
     *
     * @urlParam $id int required
     * @return \Illuminate\Http\Response|void
     */
    public function destroy($id)
    {
        try {
            $location = Location::findOrFail($id);
            $location->book->update([
                'status' => 'available'
            ]);
            $location->delete();

            return $this->sendResponse([], "Suppression effectuée avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des locations à la corbeille (soft delete).
     *
     * @param  LocationArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(LocationArchiveRequest $request): JsonResponse
    {
        try {
            Location::whereIn('id', $request->ids)->delete();
            Log::info('Locations mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des locations supprimées (soft delete).
     *
     * @param  LocationArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(LocationArchiveRequest $request): JsonResponse
    {
        try {
            Location::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Locations restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des locations (hard delete).
     *
     * @param  LocationArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(LocationArchiveRequest $request): JsonResponse
    {
        try {
            Location::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Locations supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
