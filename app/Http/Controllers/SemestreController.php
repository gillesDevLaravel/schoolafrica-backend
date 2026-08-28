<?php

namespace App\Http\Controllers;

use App\Http\Requests\Semestre\SemestreCreateRequest;
use App\Http\Requests\Semestre\SemestreGetRequest;
use App\Http\Requests\Semestre\SemestreArchiveRequest;
use App\Http\Requests\Semestre\SemestreUpdateRequest;
use App\Http\Resources\SemestreResource;
use App\Models\Semestre;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Semestres
 */
class SemestreController extends BaseController
{
    /**
     * Afficher la liste des semestres
     * @param SemestreGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(SemestreGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $semestres = Semestre::query()
                ->when($request->filter_value, function ($query) use ($request){
                    return $query->where('name', 'like', '%' . $request->filter_value . '%');
                })
                ->orderBy("id", "desc")
                ->get();

            return SemestreResource::collection($semestres);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un semestre
     * @param SemestreCreateRequest $request
     * @return JsonResponse
     */
    public function store(SemestreCreateRequest $request)
    {
        try {
            $semestres = [];
            foreach ($request->semestres as $semestre) {
                $semestres []= Semestre::create([
                    'name' => $semestre['name'],
                    'created_by' => auth()->user()->id
                ]);
            }

            return $this->sendResponse(SemestreResource::collection($semestres), "Semestres créés avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Aficher les informations d'un semestre
     * @param Semestre $semestre
     * @param $id
     * @return SemestreResource|JsonResponse
     */
    public function show(Semestre $semestre, $id)
    {
        try {
            $semestre = Semestre::find($id);
            return new SemestreResource($semestre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour les informations d'un semestre
     * @param Request $request
     * @param $id
     * @return SemestreResource|JsonResponse
     */
    public function update(SemestreUpdateRequest $request, $id)
    {
        try {
            $semestre = Semestre::findOrFail($id);
            $semestre->name = $request['name'] ?? $semestre->name;
            $semestre->updated_by = auth()->user()->id;

            $semestre->save();
            return new SemestreResource($semestre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un semestre
     * @param $id
     * @return Application|ResponseFactory|JsonResponse|Response
     */
    public function destroy($id)
    {
        try {
            $semestre = Semestre::findOrFail($id);
            $semestre->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des semestres à la corbeille (soft delete).
     *
     * @param  SemestreArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(SemestreArchiveRequest $request): JsonResponse
    {
        try {
            Semestre::whereIn('id', $request->ids)->delete();
            Log::info('Semestres mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des semestres : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des semestres supprimés (soft delete).
     *
     * @param  SemestreArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(SemestreArchiveRequest $request): JsonResponse
    {
        try {
            Semestre::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Semestres restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des semestres : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des semestres (hard delete).
     *
     * @param  SemestreArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(SemestreArchiveRequest $request): JsonResponse
    {
        try {
            Semestre::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Semestres supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('app.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des semestres : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
