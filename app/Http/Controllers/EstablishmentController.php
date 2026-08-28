<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Establishment;
use App\Http\Requests\Admin\EstablishmentRequest;
use App\Http\Requests\Establishment\EstablishmentArchiveRequest;
use App\Http\Resources\Admin\EstablishmentResource;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\LicenceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * @group Establishment
 *
 * Gestion des établissements scolaire
 */
class EstablishmentController extends BaseController
{
    /**
     * Afficher la liste des établissements
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $establishment = $request['idFounder'] ?? null;
            switch ($establishment) {
                case null:
                    return EstablishmentResource::collection(
                        Establishment::orderBy("id", "desc")->get()
                    );
                    break;

                default:
                    return EstablishmentResource::collection(
                        Establishment::select('establishments.id as id','establishments.name as name','establishments.phone as phone','establishments.email as email','establishments.website as website','establishments.logo as logo','establishments.cle as cle','establishments.route as route','establishments.pay_om_fees as pay_om_fees','establishments.country as country','establishments.administrative_status as administrative_status','establishments.religious_status as religious_status','establishments.idFounder as idFounder','establishments.idPrefetEtude as idPrefetEtude','establishments.idSecretaire as idSecretaire','establishments.idPackage as idPackage', 'ministry', 'region', 'department')
                        ->join('establishments_has_users','establishments_has_users.establishment_id','=','establishments.id')
                        ->where('establishments_has_users.user_id',$request['idFounder'])
                        ->orderBy("establishments.id", "desc")->get()
                    );
                    break;
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    /**
     * Ajouter un établissement
     *
     * @param EstablishmentRequest $request
     * @return EstablishmentResource|\Illuminate\Http\Response
     */
    public function store(EstablishmentRequest $request)
    {
        try {
            $establishment = $request->validated();

            $establishment = new Establishment();

            $establishment->name = $request['name'];
            $establishment->ministry = $request['ministry'];
            $establishment->region = $request['region'];
            $establishment->department = $request['department'];
            $establishment->phone = $request['phone'];
            $establishment->mobile_money_number = $request['mobile_money_number'] ?? null;
            $establishment->rib = $request['rib'] ?? null;
            $establishment->om = $request['om'] ?? null;
            $establishment->cnps = $request['cnps'] ?? null;
            $establishment->idFounder = $request['idFounder'] ?? null;
            $establishment->idPrefetEtude = $request['idPrefetEtude'] ?? null;
            $establishment->idSecretaire = $request['idSecretaire'] ?? null;
            $establishment->country = $request['country'];
            $establishment->email = $request['email'];
            $establishment->idPackage = $request['idPackage'];
            $establishment->website = $request['website'] ?? null;
            $establishment->logo = $request['logo'] ?? null;
            $establishment->cle = substr($request['name'], -3)."-".rand(1000,9999)."-2023";
            $establishment->route = $request['route'] ?? null;
            $establishment->pay_om_fees = $request['pay_om_fees'];
            $establishment->code_couleur = $request['code_couleur'] ?? null;
            $establishment->administrative_status = $request['administrative_status'] ?? null;
            $establishment->religious_status = $request['religious_status'] ?? null;
            $establishment->created_by = auth()->user()->id;
            $establishment->save();

            if(!empty($request['founders'])){
                $establishment->users()->sync($request['founders']);
            }

            return new EstablishmentResource($establishment);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un établissement
     *
     * @param Establishment $establishment
     * @param $id
     * @return EstablishmentResource|\Illuminate\Http\Response
     */
    public function show(Establishment $establishment,$id)
    {
        try {
            $establishment = Establishment::find($id);
            return new EstablishmentResource($establishment);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un établissement
     *
     * @param EstablishmentRequest $request
     * @param Establishment $establishment
     * @param $id
     * @return EstablishmentResource|\Illuminate\Http\Response
     */
    public function update(EstablishmentRequest $request, Establishment $establishment,$id)
    {
        try {
            $establishment = Establishment::find($id);
            $establishment->name = $request['name'] ?? $establishment['name'];
            $establishment->ministry = $request['ministry'] ?? $establishment['ministry'];
            $establishment->region = $request['region'] ?? $establishment['region'];
            $establishment->department = $request['department'] ?? $establishment['department'];
            $establishment->phone = $request['phone'] ?? $establishment['phone'];
            $establishment->mobile_money_number = $request['mobile_money_number'] ?? $establishment['mobile_money_number'];
            $establishment->rib = $request['rib'] ?? null;
            $establishment->om = $request['om'] ?? null;
            $establishment->cnps = $request['cnps'] ?? null;
            $establishment->idFounder = $request['idFounder'] ?? null;
            $establishment->idPrefetEtude = $request['idPrefetEtude'] ?? null;
            $establishment->idSecretaire = $request['idSecretaire'] ?? null;
            $establishment->country = $request['country'] ?? $establishment['country'];
            $establishment->email = $request['email'] ?? $establishment['email'];
            $establishment->idPackage = $request['idPackage'] ?? $establishment['idPackage'];
            $establishment->website = $request['website'] ?? $establishment['website'];
            /*
            switch ($establishment->logo) {
                case null:
                    $establishment->logo = Storage::disk('local')->put('logo_etablishments', $request->file('logo')) ?? null;
                    break;

                default:
                    if(Storage::disk('local')->exists($establishment->logo) != true){
                        Storage::delete($establishment->logo);
                        $establishment->logo = Storage::disk('local')->put('logo_etablishments', $request->file('logo')) ?? null;
                    }
                    break;
            }
            if(!empty($request['cle'])){
                $establishment->cle = substr($request['name'], -3)."-".rand(1000,9999)."-2023";
            }else{
                $establishment->cle = $establishment['cle'];
            }
            */
            $establishment->logo = $request['logo'] ?? $establishment['logo'];
            $establishment->route = $request['route'] ?? $establishment['route'];
            $establishment->pay_om_fees = $request['pay_om_fees'] ?? $establishment['pay_om_fees'];
            $establishment->code_couleur = $request['code_couleur'] ?? $establishment['code_couleur'];
            $establishment->administrative_status = $request['administrative_status'] ?? $establishment['administrative_status'];
            $establishment->religious_status = $request['religious_status'] ?? $establishment['religious_status'];
            $establishment->updated_by = auth()->user()->id;
            $establishment->save();

            if(!empty($request['founders'])){
                $establishment->users()->sync($request['founders']);
            }

            return new EstablishmentResource($establishment);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un établissement
     *
     * @param Establishment $establishment
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Establishment $establishment,$id)
    {
        try {
            $establishment = Establishment::find($id);
            $establishment->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Match cle from the specified etablishment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findcle(LicenceRequest $request)
    {
        try {
                $establishment = $request->validated();
                $establishment = Establishment::select('route')
                                                ->where('cle',$request['cle'])
                                                ->first();

                switch ($establishment) {
                    case null:
                        return $this->sendError('Error',"UNAUTHORIZED");
                        break;

                    default:
                        return $this->sendResponse($establishment,'success');
                        break;
                }


        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
    /**
     * Met des établissements à la corbeille (soft delete).
     *
     * @param  EstablishmentArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(EstablishmentArchiveRequest $request): JsonResponse
    {
        try {
            Establishment::whereIn('id', $request->ids)->delete();
            Log::info('Establishments mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des établissements supprimés (soft delete).
     *
     * @param  EstablishmentArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(EstablishmentArchiveRequest $request): JsonResponse
    {
        try {
            Establishment::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Establishments restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des établissements (hard delete).
     *
     * @param  EstablishmentArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(EstablishmentArchiveRequest $request): JsonResponse
    {
        try {
            Establishment::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Establishments supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
