<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\SectionResource;
use App\Http\Requests\Admin\SectionRequest;
use App\Http\Requests\Section\SectionArchiveRequest;
use App\Models\Section;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Section
 *
 * Gestion des sections
 */
class SectionController extends BaseController
{
    /**
     * Afficher la liste des sections
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idPrincipal = $request['idPrincipal'] ?? null;
            $lang = $request['lang'] ?? null;

            $sections = Section::query();

            if(!is_null($idSchool)) $sections = $sections->where('idSchool', $idSchool);
            if(!is_null($idPrincipal)) $sections = $sections->where('idPrincipal', $idPrincipal);
            if(!is_null($lang)) $sections = $sections->where('lang', $lang);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $sections->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%")
                        ->where('lang', 'like', "%$filter_value%");
                });
            }

            return SectionResource::collection(
                $sections->orderBy("id", "desc")->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    /**
     * Ajouter une section
     *
     * @param SectionRequest $request
     * @return SectionResource|\Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        try {
            $section = $request->validated();

            $section = Section::create([
                'name' => $section['name'],
                'description' => $section['description'],
                'lang' => $section['lang'],
                'idSchool' => $section['idSchool'],
                'idPrincipal' => $request['idPrincipal'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            return new SectionResource($section);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'une section
     *
     * @param Section $section
     * @param $id
     * @return SectionResource|\Illuminate\Http\Response
     */
    public function show(Section $section,$id)
    {
        try {
            $section = Section::find($id);
            return new SectionResource($section);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une section
     *
     * @param SectionRequest $request
     * @param Section $section
     * @param $id
     * @return SectionResource|\Illuminate\Http\Response
     */
    public function update(SectionRequest $request,Section $section, $id)
    {
        try {
            $section = Section::find($id);
            $section->name = $request['name'];
            $section->description = $request['description'];
            $section->lang = $request['lang'];
            $section->idSchool = $request['idSchool'];
            $section->idPrincipal = $request['idPrincipal'] ?? null;
            $section->updated_by = auth()->user()->id;

            $section->save();
            return new SectionResource($section);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une section
     *
     * @param Section $section
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Section $section,$id)
    {
        try {
            $section = Section::find($id);
            $section->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Met des sections à la corbeille (soft delete).
     *
     * @param  SectionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(SectionArchiveRequest $request): JsonResponse
    {
        try {
            Section::whereIn('id', $request->ids)->delete();
            Log::info('Sections mises à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des sections supprimées (soft delete).
     *
     * @param  SectionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(SectionArchiveRequest $request): JsonResponse
    {
        try {
            Section::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Sections restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des sections (hard delete).
     *
     * @param  SectionArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(SectionArchiveRequest $request): JsonResponse
    {
        try {
            Section::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Sections supprimées définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
