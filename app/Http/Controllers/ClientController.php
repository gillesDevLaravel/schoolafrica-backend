<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ClientsAllRequest;
use App\Http\Requests\Admin\ClientStoreRequest;
use App\Http\Requests\Admin\ClientUpdateRequest;
use App\Http\Resources\Admin\ClientResource;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClientController extends BaseController
{
    /**
     * Récupérer la liste des clients
     *
     * @param ClientsAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ClientsAllRequest $request)
    {
        try {
            $filter_value = $request->filter_value;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $clients = Client::query();

            if(!is_null($request->type)) $clients = $clients->where('type', $request->type);

            if(!is_null($filter_value)){
                $clients->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('type', 'like', "%$filter_value%");
                });
            }

            return ClientResource::collection(
                $clients
                    ->orderBy('name')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems));

        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les informations d'un client
     *
     * @param $idClient
     * @return ClientResource|\Illuminate\Http\JsonResponse
     */
    public function show($idClient)
    {
        try {
            return ClientResource::make(Client::findOrFail($idClient));
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer un nouveau client
     *
     * @param ClientStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClientStoreRequest $request)
    {
        try {
            foreach ($request->clients as $client) {
                $cust = Client::create([
                    'name' => $client['name'],
                    'adresse' => $client['adresse'] ?? null,
                    'website' => $client['website'] ?? null,
                    'niu' => $client['niu'] ?? null,
                    'type' => $client['type'],
                    'phone' => $client['phone'],
                    'mobile' => $client['mobile'],
                    'email' => $client['email'],
                    'cni' => $client['cni'] ?? null,
                    'country' => $client['country'] ?? null,
                    'city' => $client['city'] ?? null,
                    'rc' => $client['rc'] ?? null,
                    'created_by' => auth()->user()->id
                ]);

//            if(!is_null($request->rc)){
//                $file = $request->file('rc');
//                $uploadPath = "public/clients/rc";
//                $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                $file->move($uploadPath,$originalImage);
//
//                $cust->rc = $originalImage;
//            }
                if(isset($invoice['image']) && !is_null($invoice['image'])){
                    $file = $client['image'];
                    $uploadPath = "public/clients";
                    $originalImage = Str::uuid().".".$file->getClientOriginalExtension();

                    $file->move($uploadPath,$originalImage);

                    $cust->image = $originalImage;
                    $cust->save();
                }

                Log::info("Ajout d'un client", ['auteur' => auth()->user()->id, 'client' => $cust->id]);
            }

            return $this->sendResponse([], "Clients créés avec succès");
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour les infos d'un client
     *
     * @param ClientUpdateRequest $request
     * @param $idClient
     * @return ClientResource|\Illuminate\Http\JsonResponse
     */
    public function update(ClientUpdateRequest $request, $idClient)
    {
        try {
            $client = Client::findOrFail($idClient);

            $client->name = $request->name ?? $client->name;
            $client->type = $request->type ?? $client->type;
            $client->adresse = $request->adresse ?? $client->adresse;
            $client->website = $request->website ?? $client->website;
            $client->niu = $request->niu ?? $client->niu;
            $client->type = $request->type ?? $client->type;
            $client->rc = $request->rc ?? $client->rc;
            $client->phone = $request->phone ?? $client->phone;
            $client->mobile = $request->mobile ?? $client->mobile;
            $client->email = $request->email ?? $client->email;
            $client->cni = $request->cni ?? $client->cni;
            $client->country = $request->country ?? $client->country;
            $client->city = $request->city ?? $client->city;
            $client->updated_by = auth()->user()->id;

            if(!is_null($request->image)){
                $file = $request->file('image');
                $uploadPath = "public/clients";
                $originalImage = Str::uuid().".".$file->getClientOriginalExtension();

                $file->move($uploadPath,$originalImage);

                $client->image = $originalImage;
            }

            $client->save();

            Log::info("maj d'un client", ['auteur' => auth()->user()->id, 'client' => $client->id]);

            return ClientResource::make($client);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer un client à la corbeille
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash($id)
    {
        try {
            $client = Client::findOrFail($id);

            //TODO: On vérifie que ce client n'a aucun paiement (table CashIn) avant de le supprimer

            $client->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            Log::critical("Mise en corbeille d'un client", ['auteur' => auth()->user()->id, 'client' => $client->id]);

            return $this->sendResponse([], "Client supprimé avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer un client de la corbeille-B: Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return ClientResource|\Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        try {
            $client = Client::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $client->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);
            Log::critical("Restauration d'un client de la corbeille", ['auteur' => auth()->user()->id, 'client' => $client->id]);

            return ClientResource::make($client);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
