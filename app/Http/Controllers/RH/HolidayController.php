<?php

namespace App\Http\Controllers\RH;

use App\Enums\StatusEnum;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Holiday\HolidayDestroyRequest;
use App\Http\Requests\Holiday\HolidayGetRequest;
use App\Http\Requests\Holiday\HolidayRestoreRequest;
use App\Http\Requests\Holiday\HolidayStoreRequest;
use App\Http\Requests\Holiday\HolidayTrashRequest;
use App\Http\Requests\Holiday\HolidayUpdateRequest;
use App\Http\Resources\HolidayResource;
use App\Models\Contract;
use App\Models\Holiday;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HolidayController extends BaseController
{
    /**
     * Lister les congés enregistrés
     *
     * @param HolidayGetRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(HolidayGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $holidays = Holiday::query();

            $assessment_filters = [
                'idUser' => $request->idUser,
                'idUserApprove' => $request->idUserApprove,
                'date' => $request->date,
                'status' => $request->status,
                'type' => $request->type,
                'deleted' => (boolean) $request->trashed,
            ];
            foreach ($assessment_filters as $column => $value) {
                if (!is_null($value)) {
                    $holidays->where($column, $value);
                }
            }

            // Filtres par plage de dates (start_date et end_date du congé)
            if ($request->filled('start_date')) {
                $holidays->whereDate('start_date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $holidays->whereDate('end_date', '<=', $request->end_date);
            }

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $holidays->where(function ($holidays) use ($filter_value) {
                    $holidays->where('reason', 'like', '%' . $filter_value . '%')
                        ->orWhere('status', 'like', '%' . $filter_value . '%')
                        ->orWhere('type', 'like', '%' . $filter_value . '%')
                        ->orWhere('reason', 'like', '%' . $filter_value . '%')
                        ->orWhere('comments', 'like', '%' . $filter_value . '%')
                        ->orwhereHas('user', function($holidays) use ($filter_value) {
                            $holidays->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('userApprove', function($holidays) use ($filter_value) {
                            $holidays->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            // Comptages par statut
            $statusCounts = [
                'pending' => (clone $holidays)->where('status', 'pending_approval')->count(),
                'approved' => (clone $holidays)->where('status', 'approved')->count(),
                'rejected' => (clone $holidays)->where('status', 'rejected')->count(),
                'in_progress' => (clone $holidays)->where('status', 'in_progress')->count(),
            ];

            $paginated = $holidays
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            return response()->json([
                'data' => HolidayResource::collection($paginated),
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
     * Afficher les détails d'une retenue sur salaire
     *
     * @param Holiday $holiday
     * @return HolidayResource|\Illuminate\Http\JsonResponse
     */
    public function show(Holiday $holiday)
    {
        try {
            return new HolidayResource($holiday);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une demande de congé
     *
     * @param HolidayStoreRequest $request
     * @return HolidayResource|\Illuminate\Http\JsonResponse
     */
    public function store(HolidayStoreRequest $request)
    {
        try {
            $user = auth()->user();

            $contract = Contract::where("idUser", auth()->id())
                ->where('status', 'approved')
                ->first();

            // Vérification qu'un contrat existe ou qu'il a encore des jours de congé
            if (!$contract || ($contract->number_days_off ?? 0) < $request->days_taken) {
                return $this->sendError(__('holiday.days_taken_impossible', [
                    'days_taken' => $request->days_taken,
                    'number_days_off' => $contract->number_days_off ?? 0
                ]));
            }


            $holiday = Holiday::create([
                'idUser' => auth()->user()->id,
                'idUserApprove' => $request->idUserApprove,
                'type' => $request->type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'days_taken' => $request->days_taken,
//                'status' => StatusEnum::PENDING_APPROVAL,
                'reason' => $request->reason,
            ]);

            Notification::create([
                'notificationable_type' => Holiday::class,
                'notificationable_id' => $holiday->id,
                'title' => __('holiday.notif_title'),
                'description' => __('holiday.notif_to_verif_description'),
                'user_id' => $request["idUserApprove"],
                'grouped_users' => null
            ]);

            Log::info(__('holiday.create.success'), ['holiday_id' => $holiday->id, 'author' => auth()->user()->id]);

            return (HolidayResource::make($holiday));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier une demande de congé
     *
     * @param HolidayUpdateRequest $request
     * @param Holiday $holiday
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(HolidayUpdateRequest $request, Holiday $holiday)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user(); // Récupère l'utilisateur connecté
            $contract = Contract::where("idUser", auth()->id())->first();

            // Empêcher de modifier un congé déjà approuvé
            if ($holiday->status === StatusEnum::APPROVED) {
                return $this->sendError(__('holiday.update.impossible'));
            }

            // Mettre à jour les informations de base
            $holiday->updated_by = auth()->user()->id;
            $holiday->type = $request->type ?? $holiday->type;
            $holiday->start_date = $request->start_date ?? $holiday->start_date;
            $holiday->end_date = $request->end_date ?? $holiday->end_date;
            $holiday->reason = $request->reason ?? $holiday->reason;
            $holiday->comments = $request->comments ?? $holiday->comments;
            $holiday->days_taken = $request->days_taken ?? $holiday->days_taken;
            $holiday->save(); // fait exprès de mettre ça ici d'abord

            // Vérifier si l'utilisateur tente d'approuver
            if ($request->status === StatusEnum::APPROVED) {
                // Vérifier que l'utilisateur a le droit d'approuver
                if ($user->id !== $holiday->idUserApprove) {
                    Log::critical("Utilisateur non authorisé a essayé d'approuver une demande de congé sans autorisation adéquate", ['author' => auth()->user()->id]);
                    return $this->sendError(__('holiday.update.unauthorized'));
                }

                // Vérifier que l'utilisateur a encore assez de jours disponibles
                if ($contract->number_days_off < $holiday->days_taken) {
                    return $this->sendError(__('holiday.days_taken_impossible', ['days_taken' => $holiday->days_taken, 'number_days_off' => $contract->number_days_off]));
                }

                // Approuver le congé
                $holiday->approval_date = now();
                $holiday->status = StatusEnum::APPROVED;

                // Décrémenter les jours de congé disponibles de l'utilisateur
                $contract->decrement('number_days_off', $holiday->days_taken);

                //TODO: Ajouter une notification pour idUser
                $holiday_status = __('holiday.approved');
            }else{
                //si le statut envoyé n'est pas APPROVED, on le garde quand même mais rien d'autre n'est effectué
                $holiday->status = $request->status ?? $holiday->status;

                if ($request->status === StatusEnum::REJECTED) $holiday_status = __('holiday.rejected'); // on se servira de ceci pour notifier le propriétaire
            }

            // on enregistre les modifications
            $holiday->save();

            DB::commit();

            if(isset($holiday_status)){
                Notification::create([
                    'notificationable_type' => Holiday::class,
                    'notificationable_id' => $holiday->id,
                    'title' => __('holiday.notif_title'),
                    'description' => __('holiday.notif_updated_description', ['holiday_status' => $holiday_status]),
                    'user_id' => $holiday->idUser,
                    'grouped_users' => null
                ]);
            }

            return $this->sendResponse($holiday, __('Le congé a été mis à jour avec succès.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver une ou plusieurs demandes de congés
     *
     * @param HolidayTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash(HolidayTrashRequest $request)
    {
        try {
            Holiday::whereIn('id', $request->idHolidays)->each(function ($holiday) {
                $holiday->update([
                    'deleted' => true,
                    'deleted_by' => auth()->user()->id,
                ]);

                Log::critical("Demande de congé mise en corbeille.", ['holiday' => $holiday->id, 'author' => auth()->user()->id]);
            });

            return $this->sendResponse([],  'Demande de congé(s) mise en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une ou plusieurs demandes de congés
     *
     * @param HolidayTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(HolidayRestoreRequest $request)
    {
        try {
            Holiday::whereIn('id', $request->idHolidays)->each(function ($holiday) {
                $holiday->update([
                    'deleted' => false
                ]);

                Log::critical("Demande de congé restaurée.", ['holiday' => $holiday->id, 'author' => auth()->user()->id]);
            });

            return $this->sendResponse([],  'Demande de congé(s) restaurée.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une ou plusieurs demandes de congés
     *
     * @param HolidayDestroyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(HolidayDestroyRequest $request)
    {
        try {
            Holiday::whereIn('id', $request->idHolidays)->each(function ($holiday) {
                Log::critical("Demande de congé supprimée.", ['holiday' => $holiday->id, 'author' => auth()->user()->id]);
                $holiday->delete();
            });

            return $this->sendResponse([],  'Demande de congé(s) supprimée.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
