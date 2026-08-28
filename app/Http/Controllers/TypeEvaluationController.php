<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Admin\TypeEvaluationGetRequest;
use App\Http\Requests\Admin\TypeEvaluationStoreRequest;
use App\Http\Requests\TypeEvaluation\TypeEvaluationArchiveRequest;
use App\Http\Resources\Staffs\TypeEvaluationResource;
use App\Models\TypeEvaluation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Type Evaluation
 */
class TypeEvaluationController extends BaseController
{
    /**
     * Afficher la liste des Types d'évaluations
     *
     * @param TypeEvaluationGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(TypeEvaluationGetRequest $request)
    {
        try {
            $name = $request['name'] ?? null;

            $typesEval = TypeEvaluation::where('idSchool', $request['idSchool'])
                ->when(!is_null($request['idSection']), function($query) use ($request) {
                    $query->where('idSection', $request['idSection']);
                });
            if(!is_null($name)){
                $typesEval->where('name',$request['name']);
            }

            return TypeEvaluationResource::collection(
                $typesEval
                    ->orderBy("id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un type d'évaluation
     *
     * @param Request $request
     * @return TypeEvaluationResource|\Illuminate\Http\Response
     */
    public function store(TypeEvaluationStoreRequest $request)
    {
        try {
            $typeEvaluation = TypeEvaluation::create([
                'name' => $request['name'],
                'libelle' => $request['libelle'] ?? null,
                'idSchool' => $request['idSchool'] ?? null,
                'idSection' => $request['idSection'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            return new TypeEvaluationResource($typeEvaluation);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'un type d'évaluation
     *
     * @param TypeEvaluation $typeEvaluation
     * @param $id
     * @return TypeEvaluationResource|\Illuminate\Http\Response
     */
    public function show(TypeEvaluation $typeEvaluation,$id)
    {
        try {
            $typeEvaluation = TypeEvaluation::find($id);
            return new TypeEvaluationResource($typeEvaluation);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un type d'évaluation
     *
     * @param Request $request
     * @param TypeEvaluation $typeEvaluation
     * @param $id
     * @return TypeEvaluationResource|\Illuminate\Http\Response
     */
    public function update(Request $request,TypeEvaluation $typeEvaluation, $id)
    {
        try {
            $typeEvaluation = TypeEvaluation::find($id);
            $typeEvaluation->name = $request['name'];
            $typeEvaluation->libelle = $request['libelle'] ?? $typeEvaluation->libelle;
            $typeEvaluation->idSchool = $request['idSchool'];
            $typeEvaluation->idSection = $request['idSection'];
            $typeEvaluation->updated_by = auth()->user()->id;

            $typeEvaluation->save();
            return new TypeEvaluationResource($typeEvaluation);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un type d'évaluation
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $typeEvaluation = TypeEvaluation::findOrFail($id);
            $typeEvaluation->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des types d'évaluation à la corbeille (soft delete).
     *
     * @param  TypeEvaluationArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(TypeEvaluationArchiveRequest $request): JsonResponse
    {
        try {
            TypeEvaluation::whereIn('id', $request->ids)->delete();
            Log::info('Types d\'évaluation mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des types d\'évaluation : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des types d'évaluation supprimés (soft delete).
     *
     * @param  TypeEvaluationArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(TypeEvaluationArchiveRequest $request): JsonResponse
    {
        try {
            TypeEvaluation::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Types d\'évaluation restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des types d\'évaluation : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des types d'évaluation (hard delete).
     *
     * @param  TypeEvaluationArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(TypeEvaluationArchiveRequest $request): JsonResponse
    {
        try {
            TypeEvaluation::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Types d\'évaluation supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des types d\'évaluation : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
