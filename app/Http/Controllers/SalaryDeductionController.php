<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\SalaryDeduction\SalaryDeductionDeleteRequest;
use App\Http\Requests\SalaryDeduction\SalaryDeductionGetRequest;
use App\Http\Requests\SalaryDeduction\SalaryDeductionRestoreRequest;
use App\Http\Requests\SalaryDeduction\SalaryDeductionStoreRequest;
use App\Http\Requests\SalaryDeduction\SalaryDeductionTrashRequest;
use App\Http\Requests\SalaryDeduction\SalaryDeductionUpdateRequest;
use App\Http\Resources\SalaryDeductionResource;
use App\Models\SalaryDeduction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Retenus sur salaire
 *
 * Gestion des retenus sur salaires
 */
class SalaryDeductionController extends BaseController
{
    /**
     * Lister les retenus sur salaire
     *
     * @param SalaryDeductionGetRequest $request
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SalaryDeductionGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $salary_deductions = SalaryDeduction::query()
                ->where('deleted', (boolean) $request->trashed);


            if ($request->idUser) $salary_deductions->where('idUser', $request->idUser);
            if ($request->date) $salary_deductions->where('date', $request->date);
            if ($request->idUserApprove) $salary_deductions->where('idUserApprove', $request->idUserApprove); //qui doivent être approuvé par un utilisateur
            if ($request->status) $salary_deductions->where('status', $request->status); //filtrer par status

            // Filtres par plage de dates
            if ($request->filled('start_date')) {
                $salary_deductions->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $salary_deductions->whereDate('date', '<=', $request->end_date);
            }

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $salary_deductions->where(function ($query) use ($filter_value) {
                    $query->where('reason', 'like', '%' . $filter_value . '%')
                        ->orwhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('userApprove', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            // Comptages par statut
            $statusCounts = [
                'pending_approval' => (clone $salary_deductions)->where('status', 'pending_approval')->count(),
                'approved' => (clone $salary_deductions)->where('status', 'approved')->count(),
                'rejected' => (clone $salary_deductions)->where('status', 'rejected')->count(),
                'in_progress' => (clone $salary_deductions)->where('status', 'in_progress')->count(),
            ];

            $paginated = $salary_deductions
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            return response()->json([
                'data' => SalaryDeductionResource::collection($paginated),
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
     * @param SalaryDeduction $salary_deduction
     * @return SalaryDeductionResource|JsonResponse
     */
    public function show(SalaryDeduction $salary_deduction)
    {
        try {
            return new SalaryDeductionResource($salary_deduction);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajout d'une ou plusieurs retenues sur salaire
     *
     * @param SalaryDeductionStoreRequest $request
     * @return JsonResponse
     */
    public function store(SalaryDeductionStoreRequest $request)
    {
        try {
            $salary_deductions = array();

            $author = auth()->user();

            foreach ($request->salary_deductions as $salary_deduction) {

                $tmp_salary_deduction = SalaryDeduction::create([
                    'idUser' => $salary_deduction['idUser'],
                    'idUserApprove' => $salary_deduction['idUserApprove'],
                    'reason' => $salary_deduction['reason'],
                    'amount' => $salary_deduction['amount'],
                    'date' => $salary_deduction['date'] ,
                    'status' => $salary_deduction['status'] ?? StatusEnum::PENDING_APPROVAL,
                    'created_by' => $author->id,
                ]);

                $salary_deductions[] = $tmp_salary_deduction;
                Log::info("Ajout d'une retenue sur salaire ", ['salary_deduction' => $tmp_salary_deduction->id, 'author' => $author->id]);
            }

            return $this->sendResponse(SalaryDeductionResource::collection($salary_deductions), 'Retenu(s) sur salaire ajouté(s) avec succès.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier les détails d'une retenue sur salaire
     *
     * @param SalaryDeductionUpdateRequest $request
     * @param SalaryDeduction $salary_deduction
     * @return JsonResponse
     */
    public function update(SalaryDeductionUpdateRequest $request, SalaryDeduction $salary_deduction)
    {
        try {
            $salary_deduction->update([
                'idUser' => $request->idUser ?? $salary_deduction->idUser,
                'idUserApprove' => $request->idUserApprove ?? $salary_deduction->idUserApprove,
                'amount' => $request->amount ?? $salary_deduction->amount,
                'reason' => $request->reason ?? $salary_deduction->reason,
                'date' => $request->date ?? $salary_deduction->date,
                'status' => (!is_null($request->status) && auth()->id() === $salary_deduction->idUserApprove)
                    ? $request->status
                    : $salary_deduction->status,
                'updated_by' => auth()->user()->id,
            ]);
            $salary_deduction->save();

            return $this->sendResponse(
                new SalaryDeductionResource($salary_deduction),
                "Retenue sur salaire mise à jour avec succès."
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archiver une ou plusieurs retenues sur salaires
     *
     * @param SalaryDeductionTrashRequest $request
     * @return JsonResponse
     */
    public function trash(SalaryDeductionTrashRequest $request)
    {
        try {
            SalaryDeduction::whereIn('id', $request->idSalaryDeductions)->each(function ($salary_deduction) {
                $salary_deduction->update([
                    'deleted' => true,
                    'deleted_by' => auth()->user()->id,
                ]);

                Log::critical("Retenue sur salaire mise en corbeille.", ['salary_deduction' => $salary_deduction->id, 'author' => auth()->user()->id]);
            });

            return $this->sendResponse([],  'Retenu(s) sur salaire mis en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer un ou plusisuers retenues sur salaires
     *
     * @param SalaryDeductionRestoreRequest $request
     * @return JsonResponse
     */
    public function restore(SalaryDeductionRestoreRequest $request)
    {
        try {
            $salary_deductions = SalaryDeduction::whereIn('id', $request->idSalaryDeductions)
                ->get();

            foreach ($salary_deductions as $salary_deduction) {
                $salary_deduction->update([
                    'deleted' => false,
                    'deleted_by' => auth()->user()->id,
                ]);

                Log::info("Restauration de retenue(s) sur salaire de la corbeille.", ['salary_deduction' => $salary_deduction->id, 'author' => auth()->user()->id]);
            }

            return $this->sendResponse(SalaryDeductionResource::collection($salary_deductions), 'Retenue(s) sur salaire restaurée(s) avec succès.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une ou plusieurs retenues sur salaire
     *
     * @param SalaryDeductionDeleteRequest $request
     * @return JsonResponse
     */
    public function destroy(SalaryDeductionDeleteRequest $request)
    {
        try {
            SalaryDeduction::whereIn('id', $request->idSalaryDeductions)->each(function ($salary_deduction) {
                Log::critical("Retenue sur salaire supprimé.", ['salary_deduction' => $salary_deduction->id, 'author' => auth()->user()->id]);

                $salary_deduction->delete();
            });

            return $this->sendResponse([],  'Retenue(s) sur salaire supprimées avec succès.');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
