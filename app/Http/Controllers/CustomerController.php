<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staffs\CustomerRequest;
use App\Http\Resources\Staffs\CustomerResource;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @group Customer
 */
class CustomerController extends BaseController
{
    /**
     * Récupérer la liste des customers
     *
     * @bodyParam type string personnel/entreprise
     * @bodyParam filter_value string
     * @bodyParam pageItems int Le numéro de la page de pagination
     * @bodyParam nbreItems int Le nombre de résultats pour la page de pagination
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $filter_value = $request->filter_value;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $customers = Customer::query();

            if(!is_null($request->type)) $customers = $customers->where('type', $request->type);

            if(!is_null($filter_value)){
                $customers->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->orWhere('type', 'like', "%$filter_value%");
                });
            }

            return CustomerResource::collection(
                $customers
                    ->orderBy('name')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems));

        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les informations d'un customer
     *
     * @urlParam id int required
     * @return CustomerResource|\Illuminate\Http\Response
     */
    public function show($idCustomer)
    {
        try {
            return CustomerResource::make(Customer::findOrFail($idCustomer));
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer un nouveau customer
     *
     * @param CustomerRequest $request
     * @return CustomerResource|\Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            foreach ($request->customers as $customer) {
                $cust = Customer::create([
                    'name' => $customer['name'],
                    'adresse' => $customer['adresse'] ?? null,
                    'website' => $customer['website'] ?? null,
                    'niu' => $customer['niu'] ?? null,
                    'type' => $customer['type'],
                    'phone' => $customer['phone'],
                    'mobile' => $customer['mobile'],
                    'email' => $customer['email'],
                    'cni' => $customer['cni'] ?? null,
                    'country' => $customer['country'] ?? null,
                    'city' => $customer['city'] ?? null,
                    'rc' => $customer['rc'] ?? null,
                    'created_by' => auth()->user()->id
                ]);

//            if(!is_null($request->rc)){
//                $file = $request->file('rc');
//                $uploadPath = "public/customers/rc";
//                $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                $file->move($uploadPath,$originalImage);
//
//                $cust->rc = $originalImage;
//            }
                if(isset($invoice['image']) && !is_null($invoice['image'])){
                    $file = $customer['image'];
                    $uploadPath = "public/customers";
                    $originalImage = Str::uuid().".".$file->getClientOriginalExtension();

                    $file->move($uploadPath,$originalImage);

                    $cust->image = $originalImage;
                    $cust->save();
                }

                Log::info("Ajout d'un customer", ['auteur' => auth()->user()->id, 'customer' => $cust->id]);
            }

            return $this->sendResponse([], "Customers créés avec succès");
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour les infos d'un customer
     *
     * @urlParam id int required
     * @param CustomerRequest $request
     * @return CustomerResource|\Illuminate\Http\Response
     */
    public function update($idCustomer, Request $request)
    {
        try {
            $customer = Customer::findOrFail($idCustomer);

            $customer->name = $request->name ?? $customer->name;
            $customer->type = $request->type ?? $customer->type;
            $customer->adresse = $request->adresse ?? $customer->adresse;
            $customer->website = $request->website ?? $customer->website;
            $customer->niu = $request->niu ?? $customer->niu;
            $customer->type = $request->type ?? $customer->type;
            $customer->rc = $request->rc ?? $customer->rc;
            $customer->phone = $request->phone ?? $customer->phone;
            $customer->mobile = $request->mobile ?? $customer->mobile;
            $customer->email = $request->email ?? $customer->email;
            $customer->cni = $request->cni ?? $customer->cni;
            $customer->country = $request->country ?? $customer->country;
            $customer->city = $request->city ?? $customer->city;
            $customer->updated_by = auth()->user()->id;

            if(!is_null($request->image)){
                $file = $request->file('image');
                $uploadPath = "public/customers";
                $originalImage = Str::uuid().".".$file->getClientOriginalExtension();

                $file->move($uploadPath,$originalImage);

                $customer->image = $originalImage;
            }

            $customer->save();

            Log::info("maj d'un customer", ['auteur' => auth()->user()->id, 'customer' => $customer->id]);

            return CustomerResource::make($customer);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un customer (si il n'a pas encore de invoice)
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response|void
     */
    public function destroy($idCustomer)
    {
        try {
            $customer = Customer::findOrFail($idCustomer);

            // On va supprimer ssi il n'a aucun invoice
            $invoices_cusomer = Invoice::where([
                'invoiceable_type' => Customer::class,
                'invoiceable_id' => $customer->id
            ])->count();

            if($invoices_cusomer > 0){
                return $this->sendError("Impossible de supprimer un client avec des invoices");
            }

            Log::critical("Suppression d'un customer", ['auteur' => auth()->user()->id, 'customer' => $customer->id]);

            $customer->delete();

            return response(null, 200);

        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
