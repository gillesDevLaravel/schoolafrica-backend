<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ProjectAllRequest;
use App\Http\Requests\Admin\ProjectStoreRequest;
use App\Http\Requests\Admin\ReglementInterieurAllRequest;
use App\Http\Requests\Admin\ReglementInterieurStoreRequest;
use App\Http\Requests\Admin\ReglementInterieurUpdateRequest;
use App\Http\Resources\Admin\LocationResource;
use App\Http\Resources\Admin\ProjectResource;
use App\Http\Resources\Admin\ReglementInterieurResource;
use App\Models\Project;
use App\Models\ReglementInterieur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Règlement Intérieur
 */
class ReglementInterieurController extends BaseController
{
    /**
     * Lister les éléments du règlement intérieur non supprimés
     *
     * @queryParam type string nullable Filtre par type de règlement. Example: discipline
     * @queryParam filter_value string nullable Filtre par titre ou description. Example: règle
     * @queryParam pageItems int nullable Numéro de la page. Example: 1
     * @queryParam nbreItems int nullable Nombre d'éléments par page. Example: 20
     *
     * @param ReglementInterieurAllRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ReglementInterieurAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $type = $request->type;

            $regles = ReglementInterieur::query();

            if(!is_null($filter_value)){
                $regles->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhere('title', 'like', "%$filter_value%");
                });
            }
            if ($request->filled('type')) {
                $regles->where('type', $request->type);
            }

            return ReglementInterieurResource::collection(
                $regles
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un élément du règlement intérieur
     *
     * @param $idReglementInterieur
     * @return ReglementInterieurResource|JsonResponse
     */
    public function show($idReglementInterieur)
    {
        try {
            $reglementInterieur = ReglementInterieur::findOrFail($idReglementInterieur);
            return ReglementInterieurResource::make($reglementInterieur);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une ou plusieurs éléments du règlement intérieur
     *
     * @bodyParam reglements_interieurs array required Tableau des règlements intérieurs à créer. Example: [{"title": "Règle 1", "description": "Description", "type": "discipline", "image": "url.jpg", "idSchool": 1}]
     * @bodyParam reglements_interieurs.*.title string required Titre du règlement. Example: Règle 1
     * @bodyParam reglements_interieurs.*.description string required Description du règlement. Example: Description de la règle
     * @bodyParam reglements_interieurs.*.type string nullable Type du règlement. Example: discipline
     * @bodyParam reglements_interieurs.*.image string nullable URL de l'image associée. Example: https://example.com/image.jpg
     * @bodyParam reglements_interieurs.*.idSchool int required ID de l'école. Example: 1
     * @bodyParam reglements_interieurs.*.idSection int nullable ID de la section. Example: 1
     *
     * @param ReglementInterieurStoreRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function store(ReglementInterieurStoreRequest $request)
    {
        try {
            $reglements_interieurs = $request->reglements_interieurs;
            $regles = array();

            foreach ($reglements_interieurs as $reglement_interieur) {
                $regles[] = ReglementInterieur::firstOrCreate([
                    'title' => $reglement_interieur['title'],
                    'description' => $reglement_interieur['description'],
                ],[
                    'title' => $reglement_interieur['title'],
                    'type' => $reglement_interieur['type'],
                    'image' => $reglement_interieur['image'],
                    'description' => $reglement_interieur['description'],
                    'idSchool' => $reglement_interieur['idSchool'],
                    'idSection' => $reglement_interieur['idSection'] ?? null,
                    'created_by' => auth()->user()->id,
                ]);
            }

            return ReglementInterieurResource::collection($regles);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un projet
     *
     * @bodyParam title string nullable Titre du règlement. Example: Règle modifiée
     * @bodyParam description string nullable Description du règlement. Example: Description modifiée
     * @bodyParam type string nullable Type du règlement. Example: discipline
     * @bodyParam image string nullable URL de l'image associée. Example: https://example.com/image.jpg
     * @bodyParam idSchool int nullable ID de l'école. Example: 1
     * @bodyParam idSection int nullable ID de la section. Example: 1
     *
     * @param ReglementInterieurUpdateRequest $request
     * @param $id
     * @return JsonResponse|ReglementInterieurResource
     */
    public function update(ReglementInterieurUpdateRequest $request, $id)
    {
        try {
            $reglement_interieur = ReglementInterieur::findOrFail($id);

            $reglement_interieur->update([
                'title' => $request->title ?? $reglement_interieur->title,
                'type' => $request->type ?? $reglement_interieur->type,
                'image' => $request->image ?? $reglement_interieur->image,
                'description' => $request->description ?? $reglement_interieur->description,
                'idSchool' => $request->idSchool ?? $reglement_interieur->idSchool,
                'idSection' => $request->idSection ?? $reglement_interieur->idSection,
                'updated_by' => auth()->user()->id,
            ]);

            return ReglementInterieurResource::make($reglement_interieur);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer un élément du règlement intérieur à la corbeille
     *
     * @param $id
     * @return JsonResponse
     */
    public function trash($id)
    {
        try {
            $reglement_interieur = ReglementInterieur::findOrFail($id);

            $reglement_interieur->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return $this->sendResponse([], "Reglement intérieur supprimé avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer un élément du règlement intérieur de la corbeille
     * NB: Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return ReglementInterieurResource|JsonResponse
     */
    public function restore($id)
    {
        try {
            $reglement_interieur = ReglementInterieur::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $reglement_interieur->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);

            return ReglementInterieurResource::make($reglement_interieur);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
