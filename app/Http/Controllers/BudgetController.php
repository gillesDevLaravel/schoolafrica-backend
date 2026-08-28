<?php

namespace App\Http\Controllers;

use App\Enums\BudgetTypeEnum;
use App\Http\Requests\Budget\BudgetArchiveRequest;
use App\Http\Requests\Budget\BudgetCreateRequest;
use App\Http\Requests\Budget\BudgetGetRequest;
use App\Http\Requests\Budget\BudgetUpdateRequest;
use App\Http\Resources\BudgetResource;
use App\Http\Resources\TypeOfRecipeProgressResource;
use App\Models\Budget;
use App\Models\CashIn;
use App\Models\FeeUser;
use App\Models\Pension;
use App\Models\PensionUser;
use App\Models\TypeOfRecipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BudgetController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param BudgetGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(BudgetGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $filter_value = $request->get('filter_value', null);

            $type = $request->get('type', null);
            $idSchool = $request->get('idSchool', null);

            $budgets = Budget::query();

            $budgets = $budgets->when($type, function ($query) use ($type){
                return $query->where('type', $type);
            });
            $budgets = $budgets->when($idSchool, function ($query) use ($idSchool){
                return $query->where('school_id', $idSchool);
            });

            return BudgetResource::collection($budgets
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param BudgetCreateRequest $request
     * @return JsonResponse
     */
    public function create(BudgetCreateRequest $request)
    {
        try {
            $budget = Budget::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'description' => $request['description'] ?? null,
                'realisation' => $request['realisation'] ?? null,
                'school_id' => $request['idSchool'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $items = $request->input('type_invoice_or_type_recipe_items', []);

            if ($budget->type === BudgetTypeEnum::RECIPE) {
                foreach ($items as $item) {
                    $budget->typeOfRecipes()->attach($item['item_id'], [
                        'quantity' => $item['quantity'] ?? 1,
                        'number' => $item['number'] ?? 1,
                        'amount' => $item['amount'],
                    ]);
                }
            } elseif ($budget->type === BudgetTypeEnum::INVOICE) {
                foreach ($items as $item) {
                    $budget->typeInvoices()->attach($item['item_id'], [
                        'quantity' => $item['quantity'] ?? 1,
                        'number' => $item['number'] ?? 1,
                        'amount' => $item['amount'],
                    ]);
                }
            }

            Log::info('Ajout réussi du budget', ['author' => auth()->id(), 'budget' => $budget]);

            return $this->sendResponse(new BudgetResource($budget), __('budget.create.success'));

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     * @param Budget $budget
     * @return BudgetResource|JsonResponse
     */
    public function show(Budget $budget)
    {
        try {
            return new BudgetResource($budget);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BudgetUpdateRequest $request
     * @param Budget $budget
     * @return JsonResponse
     */
    public function update(BudgetUpdateRequest $request, Budget $budget)
    {
        try {
            $budget->update([
                'name' => $request['name'] ?? $budget['name'],
                'type' => $request['type'] ?? $budget['type'],
                'description' => $request['description'] ?? $budget['description'],
                'realisation' => $request['realisation'] ?? $budget['realisation'],
                'school_id' => $request['idSchool'] ?? $budget['school_id'],
                'updated_by' => auth()->id(),
            ]);

            $items = $request['type_invoice_or_type_recipe_items'] ?? [];

            $pivotData = [];
            foreach ($items as $item) {
                $pivotData[$item['item_id']] = [
                    'quantity' => $item['quantity'] ?? 1,
                    'number' => $item['number'] ?? 1,
                    'amount' => $item['amount'] ?? 0,
                ];
            }

            if ($budget->type === BudgetTypeEnum::RECIPE) {
                $budget->typeOfRecipes()->sync($pivotData);
            } else {
                $budget->typeInvoices()->sync($pivotData);
            }

            Log::info('Modification réussie du budget', ['author' => auth()->id(), 'budget' => $budget]);
            return $this->sendResponse(BudgetResource::make($budget), __('budget.update.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }


    /**
     * Fonction pour le multiple archivage des budgets
     * @param BudgetArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(BudgetArchiveRequest $request): JsonResponse
    {
        try {
            $budget_ids = $request['ids'] ?? null;

            // Désactiver les budgets
            Budget::whereIn('id', $budget_ids)->delete();

            return $this->sendResponse([], __('budget.trashed.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de restauration multiples des budgets
     * @param BudgetArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(BudgetArchiveRequest $request): JsonResponse
    {
        try {
            $budget_ids = $request['ids'] ?? null;

            // Restaurer les budgets
            Budget::withTrashed()->whereIn('id', $budget_ids)->restore();

            return $this->sendResponse([], __('budget.restore.success'), 200);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des budgets
     *
     * @param BudgetArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(BudgetArchiveRequest $request): JsonResponse
    {
        try {
            $budget_ids = $request['ids'] ?? null;

            // Suppression définitive
            Budget::withTrashed()->whereIn('id', $budget_ids)->forceDelete();

            return $this->sendResponse([], __('budget.delete.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }


    public function progress(Request $request)
    {
        try {
            // On récupère tous les types de recettes existants avec leur école
            $types = TypeOfRecipe::with('school')->get();

            $result = collect();

            foreach ($types as $type) {
                $typeId = $type->id;

                $pensionIds = Pension::where('type_of_recipe_id', $typeId)->pluck('id');

                $pensions = PensionUser::whereIn('idPension', $pensionIds)
                    ->sum('advancePayment');

                $fees = FeeUser::whereHas('fee', function ($q) use ($typeId) {
                    $q->where('type_of_recipe_id', $typeId);
                })->sum('advancePayment');

                $cashins = CashIn::where('type_of_recipe_id', $typeId)
                    ->sum('amount_received');

                $budgets = Budget::whereHas('typeOfRecipes', function ($query) use ($typeId){
                    $query->where('type_of_recipes.id', $typeId);
                })->get();

                $budget = Budget::whereHas('typeOfRecipes', function ($query) use ($typeId){
                    $query->where('type_of_recipes.id', $typeId);
                })->first();

                if ($budget) {
                    $item = $budget->getRecipeOrInvoiceItemByTypeId($typeId);

                    $total = $pensions + $fees + $cashins;

                    $result->push([
                        'idTypeOfRecipe' => $typeId,
                        'typeOfRecipe' => TypeOfRecipeProgressResource::make($item ?? null),
                        'typeRecipe' => $type->name,
                        'pensions' => $pensions,
                        'fees' => $fees,
                        'cashins' => $cashins,
                        'total' => $total,

                        'percentage' => ($total / $item['sub_total_amount']) / 100
                    ]);
                }
            }

            return $this->sendResponses($result);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

}
