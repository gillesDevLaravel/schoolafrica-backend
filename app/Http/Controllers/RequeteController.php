<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteRequest;
use App\Http\Requests\TypeRequeteGetAllRequest;
use App\Http\Requests\Requete\RequeteArchiveRequest;
use App\Http\Resources\Staffs\RequeteResource;
use App\Models\Establishment;
use App\Models\Notification;
use App\Models\Requete;
use App\Models\Sanction;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Requete
 */
class RequeteController extends BaseController
{
    /**
     * Lister les requêtes
     *
     * @param Request $request
     *
     * @bodyParam idSchool int
     * @bodyParam idSection int
     * @bodyParam categorie string
     * @bodyParam idStudent int
     * @bodyParam idParent int
     * @bodyParam created_at string La date de création de la requête (format: Y-m-d)
     * @bodyParam type string Le type de requêtes à sélectionner
     * @bodyParam statut enum:en_cours,valide,rejected Le statut de requêtes à sélectionner
     * @bodyParam pageItems int Le numéro de la page de pagination
     * @bodyParam nbreItems int Le nombre de résultats pour la page de pagination
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(TypeRequeteGetAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $date_start = $request->date_start;
            $date_end = $request->date_end;
            $filter_value = $request->filter_value;

            $requetes = Requete::query();

            if(!is_null($request->idTypeRequete)){
                $requetes = $requetes->where('idTypeRequete', $request->idTypeRequete);
            }
            if(!is_null($request->statut)){
                $requetes = $requetes->where('statut', $request->statut);
            }
            if(!is_null($request->idSchool)){
                $requetes = $requetes->where('idSchool', $request->idSchool);
            }
            if(!is_null($request->idSection)){
                $requetes = $requetes->where('idSection', $request->idSection);
            }
            if(!is_null($request->idUser)){
                $requetes = $requetes->where('idUser', $request->idUser);
            }
            if(!is_null($request->categorie)){
                $requetes = $requetes->where('categorie', $request->categorie);
            }
            if(!is_null($date_start) && !is_null($date_end)) {
                $requetes = $requetes->whereBetween('created_at', [$date_start, $date_end]);
            } elseif (!is_null($date_start)) {
                $requetes = $requetes->whereDate('created_at', '>=', $date_start);
            } elseif (!is_null($date_end)) {
                $requetes = $requetes->whereDate('created_at', '<=', $date_end);
            }

            if(!is_null($filter_value)){
                $requetes->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhere('statut', 'like', "%$filter_value%")
                        ->orWhereHas('typeRequete', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }
            // Calculer les totaux
            $total_en_cours = (clone $requetes)->where('statut', 'en_cours')->count();
            $total_valide = (clone $requetes)->where('statut', 'valide')->count();
            $total_rejected = (clone $requetes)->where('statut', 'rejected')->count();

            return RequeteResource::collection(
                $requetes
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            )->additional([
                'total_en_cours' => $total_en_cours,
                'total_valide' => $total_valide,
                'total_rejected' => $total_rejected
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'une requête
     *
     * @urlParam id int required
     * @return RequeteResource|\Illuminate\Http\Response
     */
    public function show($idRequete)
    {
        try {
            return RequeteResource::make(Requete::findOrFail($idRequete));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une nouvelle requête
     *
     * @param RequeteRequest $request
     * @return RequeteResource|\Illuminate\Http\Response
     */
    public function store(RequeteRequest $request)
    {
        try {
            $user = User::find($request->idUser);

            $request['idSchool'] = $user->idSchool;
            $request['idSection'] = $user->idSection;

            $requete = Requete::create([
                'categorie' => $request->categorie,
                'description' => $request->description,
                'idTypeRequete' => $request->idTypeRequete,
                'reponse' => $request->reponse,
                'idUser' => $request->idUser,
                'idSection' => $request->idSection,
                'idSchool' => $request->idSchool,
                'statut' => $request->statut ?? 'en_cours',
                'created_by' => auth()->user()->id
            ]);

            $school = School::find($request->idSchool);

            if($school->scholar_level == "CF"){
                //TODO: Notifier le fondateur (et principal heun)

                $idFounder = Establishment::first()->idFounder;
                $idPrincipal = $school->idPrincipal;

                $student = User::find($requete->idUser);

                //TODO: envoyer une notif à idUser ;...
                Notification::create([
                    'notificationable_type' => Requete::class,
                    'notificationable_id' => $requete->id,
                    'title' => __('notifs.req_title', ['student_name' => $student->name]),
                    'description' => $requete['description'],
                    'grouped_users' => json_encode(array_unique([$idFounder, $idPrincipal]))
                ]);
            }

            return RequeteResource::make($requete);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une requête
     *
     * @urlParam id int required
     *
     * @bodyParam categorie string
     * @bodyParam description string
     * @bodyParam statut string
     * @bodyParam idTypeRequete int
     * @bodyParam reponse string
     * @bodyParam idStudent int
     * @bodyParam idParent int
     * @bodyParam idSection int
     * @bodyParam idSchool int
     * @return RequeteResource|\Illuminate\Http\Response
     */
    public function update(Request $request, $idRequete)
    {
        try {
            $req = Requete::findOrFail($idRequete);

            $req->update([
                'categorie' => $request->categorie ?? $req->categorie,
                'description' => $request->description ?? $req->description,
                'statut' => $request->statut ?? $req->statut,
                'idTypeRequete' => $request->idTypeRequete ?? $req->idTypeRequete,
                'reponse' => $request->reponse ?? $req->reponse,
                'idUser' => $request->idUser ?? $req->idUser,
                'idSection' => $request->idSection ?? $req->idSection,
                'idSchool' => $request->idSchool ?? $req->idSchool,
                'updated_by' => auth()->user()->id
            ]);

            $student = User::find($req->idUser);
            $author = Auth::user()->name;

            //TODO: envoyer une notif à idUser ;...
            Notification::create([
                'notificationable_type' => Requete::class,
                'notificationable_id' => $req->id,
                'title' => __('notifs.req_up_title'),
                'description' => $req['reponse'] ?? $req['description'],
                'grouped_users' => json_encode([$req['idUser'], $student->idParent])
            ]);

            return RequeteResource::make($req);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des requêtes à la corbeille (soft delete).
     *
     * @param RequeteArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(RequeteArchiveRequest $request): JsonResponse
    {
        try {
            Requete::whereIn('id', $request->ids)->delete();
            Log::info('Requêtes mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('requete.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des requêtes : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des requêtes supprimés (soft delete).
     *
     * @param RequeteArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(RequeteArchiveRequest $request): JsonResponse
    {
        try {
            Requete::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Requêtes restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('requete.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des requêtes : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des requêtes (hard delete).
     *
     * @param RequeteArchiveRequest $request
     * @return JsonResponse
     */
    public function destroyBulk(RequeteArchiveRequest $request): JsonResponse
    {
        try {
            Requete::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Requêtes supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('requete.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des requêtes : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une requête (ancienne méthode conservée pour compatibilité)
     *
     * @param $idRequete
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($idRequete)
    {
        try {
            $requete = Requete::findOrFail($idRequete);

            $requete->delete();

            return response()->json([], 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
