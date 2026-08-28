<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\SalaryAdvance\SalaryAdvanceDestroyRequest;
use App\Http\Requests\SalaryAdvance\SalaryAdvanceGetRequest;
use App\Http\Requests\SalaryAdvance\SalaryAdvanceRestoreRequest;
use App\Http\Requests\SalaryAdvance\SalaryAdvanceStoreRequest;
use App\Http\Requests\SalaryAdvance\SalaryAdvanceTrashRequest;
use App\Http\Requests\SalaryAdvance\SalaryAdvanceUpdateRequest;
use App\Http\Resources\Staffs\SalaryAdvanceResource;
use App\Models\Notification;
use App\Models\SalaryAdvance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Avance de salaire
 * Gestion des avances sur salaire
 */
class SalaryAdvanceController extends BaseController
{
    /**
     * Lister les avances de salaires
     *
     * @param SalaryAdvanceGetRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SalaryAdvanceGetRequest $request)
    {
        try {
            $filter_value = $request->filter_value;
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $salary_advances = SalaryAdvance::query();

            $assessment_filters = [
                'idUser' => $request->idUser,
                'idUserApprove' => $request->idUserApprove,
                'status' => $request->status,
                'deleted' => (boolean) $request->trashed,
            ];
            foreach ($assessment_filters as $column => $value) {
                if (!is_null($value)) {
                    $salary_advances->where("salary_advances.$column", $value);
                }
            }

            // Filtres par date
            if ($request->filled('start_date')) {
                $salary_advances->whereDate('salary_advances.created_at', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $salary_advances->whereDate('salary_advances.created_at', '<=', $request->end_date);
            }

            if ($request->filled('filter_value')) {
                $salary_advances->where(function ($salary_advances) use ($filter_value) {
                    $salary_advances->where('reason', 'like', '%' . $filter_value . '%')
                        ->orwhereHas('user', function($salary_advances) use ($filter_value) {
                            $salary_advances->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('userApprove', function($salary_advances) use ($filter_value) {
                            $salary_advances->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            // Comptages par statut
            $statusCounts = [
                'pending' => (clone $salary_advances)->where('status', StatusEnum::PENDING_APPROVAL)->count(),
                'approved' => (clone $salary_advances)->where('status', StatusEnum::APPROVED)->count(),
                'rejected' => (clone $salary_advances)->where('status', StatusEnum::REJECTED)->count(),
                'in_progress' => (clone $salary_advances)->where('status', StatusEnum::IN_PROGRESS)->count(),
            ];

            $paginated = $salary_advances
                ->orderBy("salary_advances.id", "desc")
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            return response()->json([
                'data' => SalaryAdvanceResource::collection($paginated),
                'counts_by_status' => $statusCounts,
                'meta' => [
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                ],
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'unn avance de salaire
     *
     * @param SalaryAdvance $salary_advance
     * @return SalaryAdvanceResource|\Illuminate\Http\JsonResponse
     */
    public function show(SalaryAdvance $salary_advance)
    {
        try {
            return SalaryAdvanceResource::make($salary_advance);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Initier une ou plusieurs avances de salaire
     *
     * @param SalaryAdvanceStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SalaryAdvanceStoreRequest $request)
    {
        try {
            $advances = array();

            foreach ($request->salary_advances as $advance){
                $advances[] = $sal_ad = SalaryAdvance::create([
                    'idUser' => auth()->id(),
                    'idUserApprove' => $advance['idUserApprove'],
                    'amount' => $advance['amount'],
                    'reason' => $advance['reason'],
                ]);

                Log::info("Ajout d'une avance de salaire à valider");

                $user = auth()->user();

                //TODO: Notifier celui qui doit approuver l'avance de salaire
                Notification::create([
                    'notificationable_id' => $sal_ad->id,
                    'notificationable_type' => SalaryAdvance::class,
                    'user_id' => $advance['idUserApprove'],
                    'title' => __('salary_advance.notif_title_created'),
                    'description' => __('salary_advance.notif_description_created', ['user' => $user->name, 'amount' => $advance['amount']]),
                    'grouped_users' => null
                ]);
            }

            return $this->sendResponse(SalaryAdvanceResource::collection($advances), "Avances créées avec succès.", 201);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour une demande d'avance de salaire
     *
     * @param SalaryAdvanceUpdateRequest $request
     * @param SalaryAdvance $salary_advance
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SalaryAdvanceUpdateRequest $request, SalaryAdvance $salary_advance)
    {
        try {
            DB::beginTransaction();

            // Empêcher de modifier un congé déjà approuvé
            if ($salary_advance->status === StatusEnum::APPROVED) {
                return $this->sendError(__('update.impossible'));
            }

            $user = auth()->user(); // Récupère l'utilisateur connecté
            $salary_advance->updated_by = auth()->user()->id;
            $salary_advance->idUserApprove = $request->idUserApprove ?? $salary_advance->idUserApprove;
            $salary_advance->amount = $request->amount ?? $salary_advance->amount;
            $salary_advance->status = $request->status ?? $salary_advance->status;
            $salary_advance->reason = $request->reason ?? $salary_advance->reason;
            $salary_advance->comments = $request->comments ?? $salary_advance->comments;
            $salary_advance->save();

            if($request->status === StatusEnum::APPROVED){
                // Vérifier que l'utilisateur a le droit d'approuver
                if ($user->id !== $salary_advance->idUserApprove) {
                    Log::critical("Utilisateur non authorisé a essayé d'approuver une avance de salaire sans autorisation adéquate", ['author' => auth()->user()->id]);
                    return $this->sendError(__('salary_advance.update.unauthorized'));
                }

                // Approuver le congé
                $salary_advance->approval_date = now();
                $salary_advance->status = StatusEnum::APPROVED;

                //TODO: Ajouter une notification pour idUser
                $salary_advance_status = __('salary_advance.approved');
            }else{
                //si le statut envoyé n'est pas APPROVED, on le garde quand même mais rien d'autre n'est effectué
                $salary_advance->status = $request->status ?? $salary_advance->status;

                if ($request->status === StatusEnum::REJECTED) $salary_advance_status = __('salary_advance.rejected'); // on se servira de ceci pour notifier le propriétaire
            }

            // on enregistre les modifications
            $salary_advance->save();

            DB::commit();

            if(isset($salary_advance_status)){
                Notification::create([
                    'notificationable_type' => SalaryAdvance::class,
                    'notificationable_id' => $salary_advance->id,
                    'title' => __('salary_advance.notif_title_updated'),
                    'description' => __('salary_advance.notif_description_updated', ['salary_advance_status' => $salary_advance_status]),
                    'user_id' => $salary_advance->idUser,
                    'grouped_users' => null
                ]);
            }

            return $this->sendResponse($salary_advance, __("L'avance de salaire a été mise à jour avec succès."));
        } catch (\Throwable $th) {
            DB::rollback();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver une ou plusieurs avances de salaire
     *
     * @param SalaryAdvanceTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash(SalaryAdvanceTrashRequest $request)
    {
        try {
            $user = auth()->user();

            SalaryAdvance::whereIn('id', $request->ids)->each(function ($salary_advance) use ($user) {
                // si l'avance de salaire ne t'appartient pas tu ne dois pas la supprimer

                if($user->id === $salary_advance->idUser){
                    $salary_advance->update([
                        'deleted' => true,
                        'deleted_by' => auth()->user()->id,
                    ]);

                    Log::critical("Avance de salaire mise en corbeille.", ['salary_advance' => $salary_advance->id, 'author' => $user->id]);
                }
            });

            return $this->sendResponse([],  'Avance(s) de salaire mise en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une ou plusieurs avances de salaire
     *
     * @param SalaryAdvanceRestoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(SalaryAdvanceRestoreRequest $request)
    {
        try {
            $user = auth()->user();

            SalaryAdvance::whereIn('id', $request->ids)->each(function ($salary_advance) use ($user) {
                if($user->id === $salary_advance->idUser){
                    $salary_advance->update([
                        'deleted' => false
                    ]);

                    Log::critical("Avance de salaire restaurée.", ['salary_advance' => $salary_advance->id, 'author' => $user->id]);
                }
            });

            return $this->sendResponse([],  'Avance(s) de salaire restaurée.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une ou plusieurs avances de salaire
     *
     * @param SalaryAdvanceDestroyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SalaryAdvanceDestroyRequest $request)
    {
        try {
            SalaryAdvance::whereIn('id', $request->ids)->each(function ($salary_advance) {
                Log::critical("Avance de salaire supprimée.", ['salary_advance' => $salary_advance->id, 'author' => auth()->user()->id]);
                $salary_advance->delete();
            });

            return $this->sendResponse([],  'Avance(s) de salaire supprimée(s).');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
