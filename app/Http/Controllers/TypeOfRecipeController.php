<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeOfRecipe\TypeOfRecipeArchiveRequest;
use App\Http\Requests\TypeOfRecipe\TypeOfRecipeCreateRequest;
use App\Http\Requests\TypeOfRecipe\TypeOfRecipeGetRequest;
use App\Http\Requests\TypeOfRecipe\TypeOfRecipeUpdateRequest;
use App\Http\Resources\TypeOfRecipeResource;
use App\Http\Resources\Staffs\TypeRequeteResource;
use App\Models\TypeOfRecipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TypeOfRecipeController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param TypeOfRecipeGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(TypeOfRecipeGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $typeOfRecipe = TypeOfRecipe::query();

            return TypeOfRecipeResource::collection(
                $typeOfRecipe
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param TypeOfRecipeCreateRequest $request
     * @return JsonResponse
     */
    public function create(TypeOfRecipeCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $typeOfRecipeDatas = $request['type_of_recipes'] ?? [];

            $typeOfRecipes = [];

            foreach ($typeOfRecipeDatas as $typeOfRecipeData){
                 $typeOfRecipe = TypeOfRecipe::create([
                    'name' => $typeOfRecipeData['name'],
                    'code' => $typeOfRecipeData['code'] ?? null,
                    'category' => $typeOfRecipeData['category'],
                    'school_id' => $typeOfRecipeData['idSchool'],
                    'created_by' => auth()->id()
                ]);

                 $typeOfRecipes [] = $typeOfRecipe;
            }

            DB::commit();

            Log::info('Ajout réussi des types de recette', ['author' => auth()->id(), 'type_of_recipes' => $typeOfRecipes]);

            return $this->sendResponse(TypeOfRecipeResource::collection($typeOfRecipes), __('type_of_recipe.create.success'), 201);
        } catch (\Throwable $th) {
            DB::beginTransaction();
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @param TypeOfRecipe $typeOfRecipe
     * @return TypeOfRecipeResource|JsonResponse
     */
    public function show(TypeOfRecipe $typeOfRecipe)
    {
        try {
            return TypeOfRecipeResource::make($typeOfRecipe);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param TypeOfRecipeUpdateRequest $request
     * @param TypeOfRecipe $typeOfRecipe
     * @return JsonResponse|void
     */
    public function update(TypeOfRecipeUpdateRequest $request, TypeOfRecipe $typeOfRecipe)
    {
        try {
            $typeOfRecipe->update([
                'name' => $request['name'] ?? $typeOfRecipe['name'],
                'code' => $request['code'] ?? $typeOfRecipe['code'],
                'category' => $request['category'] ?? $typeOfRecipe['category'],
                'school_id' => $request['idSchool'] ?? $typeOfRecipe['school_id'],
                'updated_by' => auth()->id()
            ]);

            Log::info('modification réussi du type de recette', ['author' => auth()->id(), 'type_of_recipe' => $typeOfRecipe]);

            return $this->sendResponse(TypeOfRecipeResource::make($typeOfRecipe), __('type_of_recipe.create.success'), 201);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction pour le multiple archivage des type_of_recipes
     * @param TypeOfRecipeArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(TypeOfRecipeArchiveRequest $request): JsonResponse
    {
        try {
            $type_of_recipe_ids = $request['ids'] ?? null;

            // Désactiver les type_of_recipes
            TypeOfRecipe::whereIn('id', $type_of_recipe_ids)->delete();

            return $this->sendResponse([], __('type_of_recipe.trashed.success'), 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de restauration multiples des type_of_recipes
     * @param TypeOfRecipeArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(TypeOfRecipeArchiveRequest $request): JsonResponse
    {
        try {
            $type_of_recipe_ids = $request['ids'] ?? null;

            // Restaurer les type_of_recipes
            TypeOfRecipe::withTrashed()->whereIn('id', $type_of_recipe_ids)->restore();

            return $this->sendResponse([], __('type_of_recipe.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des type_of_recipes
     *
     * @param TypeOfRecipeArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(TypeOfRecipeArchiveRequest $request): JsonResponse
    {
        try {
            $type_of_recipe_ids = $request['ids'] ?? null;

            // Suppression définitive
            TypeOfRecipe::withTrashed()->whereIn('id', $type_of_recipe_ids)->forceDelete();

            return $this->sendResponse([], __('type_of_recipe.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }
}
