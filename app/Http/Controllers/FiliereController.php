<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiliereRequest;
use App\Http\Resources\Admin\FiliereResource;
use App\Models\Filiere;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Filiere
 */
class FiliereController extends BaseController
{
    /**
     * Lister les filières
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $filieres = Filiere::query();

            if(!is_null($request->idSchool)) $filieres = $filieres->where('idSchool', $request->idSchool);
            if(!is_null($request->idSection)) $filieres = $filieres->where('idSection', $request->idSection);

            return FiliereResource::collection(
                $filieres
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une filière
     *
     * @urlParam id int required
     * @return FiliereResource|\Illuminate\Http\Response
     */
    public function show($idFiliere)
    {
        try {
            return FiliereResource::make(Filiere::findOrFail($idFiliere));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter une nouvelle filière
     *
     * @param FiliereRequest $request
     * @return FiliereResource|JsonResponse
     */
    public function store(FiliereRequest $request)
    {
        try {
            $filiere = Filiere::create([
                'name' => $request->name,
                'description' => $request->description,
                'idSection' => $request->idSection,
                'idSchool' => $request->idSchool,
                'created_by' => auth()->user()->id
            ]);

            $filiere->cycles()->attach($request->cycles);

            return FiliereResource::make($filiere);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une filière
     *
     * @urlParam id int required
     *
     * @param FiliereRequest $request
     * @return FiliereResource|\Illuminate\Http\Response
     */
    public function update(FiliereRequest $request, $idFiliere)
    {
        try {
            $filiere = Filiere::findOrfail($idFiliere);
            $filiere->update([
                'name' => $request->name ?? $filiere->name,
                'description' => $request->description ?? $filiere->description,
                'idSection' => $request->idSection ?? $filiere->idSection,
                'idSchool' => $request->idSchool ?? $filiere->idSchool,
                'updated_by' => auth()->user()->id
            ]);

            if(!is_null($request->cycles)){
                $filiere->cycles()->sync($request->cycles);
            }

            return FiliereResource::make($filiere);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une filière
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response|void
     */
    public function destroy($idFiliere)
    {
        try {
            $filiere = Filiere::findOrfail($idFiliere);

            $filiere->cycles()->detach();

            $filiere->delete();
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
