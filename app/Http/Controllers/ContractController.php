<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractArchiveRequest;
use App\Http\Requests\ContractCreateRequest;
use App\Http\Requests\ContractGetRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Contracts / Contrats
 *
 * Gestion des contrats
 */
class ContractController extends BaseController
{
    /**
     * Lister les contrats avec option de filtre et de pagination
     *
     * @param ContractGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ContractGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1;
            $nbreItems = $request['nbreItems'] ?? 1000;
            $filter_value = $request['filter_value'] ?? null;
            $position = $request['position'] ?? null;
            $status = $request['status'] ?? null;
            $idUser = $request->idUser ?? null;
            $idUserApprove = $request->idUserApprove ?? null;

            $query = Contract::query()
                ->where('deleted', (boolean) $request->trashed);

            if ($filter_value){
                $query->where(function ($q) use ($filter_value){
                    $q->whereHas('user', function ($userQuery) use ($filter_value){
                        $userQuery->where('name', 'LIKE', "%$filter_value%"); // Filtrer par nom d'utilisateur
                    })
                        ->orWhere('type', 'LIKE', "%$filter_value%") // Filtrer par type de contrat
                        ->orWhere('description', 'LIKE', "%$filter_value%") // Filtrer par description
                        ->orWhere('position', 'LIKE', "%$filter_value%")// Filtrer par position
                        ->orWhere('reference', 'LIKE', "%$filter_value%"); // Filtrer par position
                });
            }

            if ($position) {
                $query->where('position', 'LIKE', "%$position%");
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($idUser) {
                $query->where('idUser', $idUser);
            }

            if ($idUserApprove) {
                $query->where('idUserApprove', $idUserApprove);
            }

            // Filtres par plage de dates
            if ($request->filled('start_date')) {
                $query->whereDate('start_date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('start_date', '<=', $request->end_date);
            }

            // Comptages par statut
            $statusCounts = [
            
                'pending_approval' => (clone $query)->where('status', 'pending_approval')->count(),
                'approved' => (clone $query)->where('status', 'approved')->count(),
                'terminated' => (clone $query)->where('status', 'terminated')->count(),
            ];

            $contracts = $query
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            return response()->json([
                'data' => ContractResource::collection($contracts),
                'counts_by_status' => $statusCounts,
                'meta' => [
                    'current_page' => $contracts->currentPage(),
                    'last_page' => $contracts->lastPage(),
                    'per_page' => $contracts->perPage(),
                    'total' => $contracts->total(),
                ],
            ]);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Création de contrat
     *
     * @param ContractCreateRequest $request
     * @return JsonResponse
     */
    public function create(ContractCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            if(Contract::where('idUser', $request['idUser'])->where('status', '!=', 'terminated')->count() > 0){
                return $this->sendError(__("contracts.create.error"));
            }

            //Generer un numéro de référence unique
            $reference = generateReferenceNumber(Contract::class, 'reference', 6);
            $contract = Contract::create([
                'reference' => $reference,
                'idUser' => $request['idUser'],
                'idUserApprove' => $request['idUserApprove'],
                'type' => $request['type'],
                'description' => $request['description'] ?? null,
                'start_date' => $request['start_date'],
                'duration' => $request['duration'],
                'working_hours' => $request['working_hours'],
                'position' => $request['position'],
                'gross_salary' => $request['gross_salary'],
                'status' => $request['status'] ?? "pending_approval",
                'service_benefits' => $request['service_benefits'] ?? null,
                'bonus' => $request['bonus'] ?? null,
                "file_link" => $request['file'],
                'number_days_off' => $request['number_days_off'] ?? 0,
                'created_by' => auth()->id(),
            ]);
            DB::commit();
            return $this->sendResponse(new ContractResource($contract), __("contracts.create.success"));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

//    /**
//     * Sauvegarder des contrats signés
//     * @param ContractUploadRequest $request
//     * @return JsonResponse
//     */
//    public function upload(ContractUploadRequest $request) {
//        try {
//            $contract = Contract::find($request->input("idContract"));
//            $file = $request->file("contract_file");
//
//            // Définir le chemin cible
//            $contractDirectoryPath = public_path('public/contracts');
//
//            // Vérifier si le répertoire existe, sinon le créer
//            if (!File::exists($contractDirectoryPath)) {
//                File::makeDirectory($contractDirectoryPath, 0755, true);
//            }
//
//            // Générer un nom de fichier unique si aucun fichier n'est associé à ce contrat
//            if (!$contract->file_link) {
//                // Générer un nom unique pour le fichier
//                $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
//            } else {
//                // Si un fichier est déjà associé, on récupère uniquement le nom du fichier sans le chemin
//                $fileName = basename($contract->file_link);
//            }
//
//            // Déplacer le fichier vers le dossier public
//            $file->move($contractDirectoryPath, $fileName);
//
//            // Générer le chemin relatif pour l'URL
//            $path = "public/contracts/$fileName";
//
//            // Mettre à jour le lien du fichier dans le contrat
//            $contract->update([
//                "file_link" => $path
//            ]);
//
//            // Retourner une réponse avec le contrat mis à jour
//            return $this->sendResponse(new ContractResource($contract), __("contracts.upload.success"));
//
//        } catch (\Throwable $th) {
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return response()->json(['error' => __('app.error_occured')], 500);
//        }
//    }



    /**
     * Afficher les informations spécifiques a un contrat
     * @param $id
     * @return ContractResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $contract = Contract::findOrFail($id);
            return new ContractResource($contract);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier les informations d'un contrat
     * @param ContractUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ContractUpdateRequest $request, $id)
    {
        try {
            $contract = Contract::findOrFail($id);

            if($contract->status === 'terminated'){
                return $this->sendError(__("contracts.update.error"));
            }
            else if($request->idUser !== $contract->idUser && Contract::where('idUser', $request['idUser'])->where('status', '!=', 'terminated')->count() > 0){
                return $this->sendError(__("contracts.update.user_change_error"));
            }

            $contract->update([
                'idUser' => $request['idUser'] ?? $contract['idUser'],
                'idUserApprove' => $request['idUserApprove'] ?? $contract['idUserApprove'],
                'type' => $request['type'] ?? $contract['type'],
                'description' => $request['description'] ?? $contract['description'],
                'start_date' => $request['start_date'] ?? $contract['start_date'],
                'duration' => $request['duration'] ?? $contract['duration'],
                'working_hours' => $request['working_hours'] ?? $contract['working_hours'],
                'position' => $request['position'] ?? $contract['position'],
                'gross_salary' => $request['gross_salary'] ?? $contract['gross_salary'],
                'status' => (auth()->id() == $contract->idUserApprove && $request->status) ? $request->status : $contract->status,
                'service_benefits' => $request['service_benefits'] ?? $contract['service_benefits'],
                'bonus' => $request['bonus'] ?? $contract['bonus'],
                'number_days_off' => $request['number_days_off'] ?? $contract['number_days_off'],
                'file_link' => $request['file'] ?? $contract['file_link'],
                'updated_by' => auth()->id(),
            ]);

            if (auth()->id() !== $contract->idUserApprove && !is_null($request->status) && $request->status != $contract->status){
                return $this->sendResponse(new ContractResource($contract), __("contracts.update.user_unauthorize_change_status"));
            }

            return $this->sendResponse(new ContractResource($contract), __("contracts.update.success"));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     *Mise en corbeille multiple des contrats (Archivage)
     * @param ContractArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(ContractArchiveRequest $request)
    {
        try {
            Contract::whereIn('id', $request['ids'])->each(function ($contrat) {
                $contrat->update([
                    'deleted_by' => auth()->id(),
                    'deleted' => true
                ]);
            });

            return $this->sendResponse(null, __("contracts.trash.success"));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     *Restauration multiple des contrats avec une liste d'ids
     * @param ContractArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(ContractArchiveRequest $request)
    {
        try {
            $contrats = Contract::whereIn('id', $request['ids'])->each(function ($contrat) {
                $contrat->update([
                    'deleted' => false
                ]);
            });

            if ($contrats){
                return $this->sendResponse(ContractResource::collection(Contract::whereIn('id', $request['ids'])->get()), __("contracts.restore.success"));
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Suppression définitive des contrats déjà archivés
     *
     * @param ContractArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(ContractArchiveRequest $request)
    {
        try {
            Contract::whereIn('id', $request['ids'])
                ->where('deleted', true)
                ->each(function ($contrat) {
                    $contrat->forceDelete(); // suppression définitive
                });

            return $this->sendResponse(null, __("contracts.destroy.success"));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
