<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryComponent\SalaryComponentArchivageRequest;
use App\Http\Requests\SalaryComponent\SalaryComponentGetRequest;
use App\Http\Requests\SalaryComponent\SalaryComponentStoreRequest;
use App\Http\Requests\SalaryComponent\SalaryComponentUpdateRequest;
use App\Http\Resources\SalaryComponentResource;
use App\Models\SalaryComponent;
use Illuminate\Support\Facades\Log;

/**
 * @group Composants de salaire
 */
class SalaryComponentController extends BaseController
{
    /**
     * Liste des composants de salaire
     * @param SalaryComponentGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SalaryComponentGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1;
            $nbreItems = $request['nbreItems'] ?? 1000000;
            $filter_value = $request->filter_value;

            $salary_components = SalaryComponent::query();
            if ($request->filled('filter_value')) {
                $salary_components->where(function ($q) use ($filter_value) {
                    $q->where('name', 'like', '%' . $filter_value . '%')
                        ->orWhere('type', 'like', '%' . $filter_value . '%');
                });
            }

            return SalaryComponentResource::collection(
                $salary_components
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Détails d'un composant de salaire
     * @param SalaryComponent $salary_component
     * @return SalaryComponentResource
     */
    public function show(SalaryComponent $salary_component)
    {
        try {
            return SalaryComponentResource::make($salary_component);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Création d'un composant de salaire
     * @param SalaryComponentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SalaryComponentStoreRequest $request)
    {
        try {
            $salary_components = [];

            foreach ($request->salary_components as $salary_component) {
                $salary_components[] = SalaryComponent::create([
                    'name' => $salary_component['name'],
                    'code' => $salary_component['code'] ?? null,
                    'type' => $salary_component['type'] ?? null,
                    'order' => $salary_component['order'] ?? null,
                    'created_by' => auth()->id(),
                ]);
            }

            return $this->sendResponse(SalaryComponentResource::collection($salary_components), 'Composant(s) de salaire ajouté(s) avec succès.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * 
     * @param SalaryComponentUpdateRequest $request
     * @param SalaryComponent $salary_component
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SalaryComponentUpdateRequest $request, SalaryComponent $salary_component)
    {
        try {
            $salary_component->name = $request->name ?? $salary_component->name;
            $salary_component->code = $request->code ?? $salary_component->code;
            $salary_component->type = $request->type ?? $salary_component->type;
            $salary_component->order = $request->order ?? $salary_component->order;
            $salary_component->updated_by = auth()->id();
            $salary_component->save();

            return SalaryComponentResource::make($salary_component);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mise en corbeille d'un composant de salaire
     * @param SalaryComponentArchivageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash(SalaryComponentArchivageRequest $request)
    {
        try {
            SalaryComponent::whereIn('id', $request->ids)->each(function ($salary_component) {
                $salary_component->update([
                    'deleted_by' => auth()->id(),
                ]);
                $salary_component->delete();
            });

            return $this->sendResponse([], 'Composant(s) de salaire mis en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restauration d'un composant de salaire
     * @param SalaryComponentArchivageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(SalaryComponentArchivageRequest $request)
    {
        try {
            SalaryComponent::withTrashed()
                ->whereIn('id', $request->ids)
                ->each(function ($salary_component) {
                    $salary_component->restore();
                    $salary_component->update([
                        'deleted_by' => null,
                        'updated_by' => auth()->id(),
                    ]);
                });

            return $this->sendResponse([], 'Composant(s) de salaire restauré(s).');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Suppression définitive d'un composant de salaire 
     * @param SalaryComponentArchivageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SalaryComponentArchivageRequest $request)
    {
        try {
           $salary_component_ids = $request['ids'] ?? null;

            // Suppression définitive
            SalaryComponent::withTrashed()->whereIn('id', $salary_component_ids)->forceDelete();

            return $this->sendResponse([], 'Composant(s) de salaire supprimé(s).');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
