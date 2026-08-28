<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\CoefficientResource;
use App\Http\Requests\Staffs\CoefficientRequest;
use App\Http\Requests\Staffs\CoefficientGetAllRequest;
use App\Models\Coefficient;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Coefficient
 */
class CoefficientController extends BaseController
{
    /**
     * Afficher la liste des coefficients
     *
     * @param CoefficientGetAllRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(CoefficientGetAllRequest $request)
    {
        try {
            $coefficient = $request->validated();

            $idSection = $request['idSection'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idMatter = $request['idMatter'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $coefficients = Coefficient::where('idSchool',$coefficient['idSchool']);

            if(!is_null($idSection)) $coefficients = $coefficients->where('idSection',$coefficient['idSection']);
            if(!is_null($idLevel)) $coefficients = $coefficients->where('idLevel',$coefficient['idLevel']);
            if(!is_null($idMatter)) $coefficients = $coefficients->where('idMatter',$coefficient['idMatter']);
            if(!is_null($idOptionLevel)) $coefficients = $coefficients->where('idOptionLevel',$coefficient['idOptionLevel']);

            return CoefficientResource::collection(
                $coefficients
                    ->orderBy("id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un coefficient
     *
     * @param CoefficientRequest $request
     * @return CoefficientResource|JsonResponse
     */
    public function store(CoefficientRequest $request)
    {
        try {
            $coefficient = $request->validated();

            $coefficient = Coefficient::updateOrCreate([
                'idSchool' => $request['idSchool'],
                'idSection' => $request['idSection'] ?? null,
                'value' => $request['value'],
                'idLevel' => $request['idLevel'] ?? null,
            ],[
                'idMatter' => $request['idMatter'] ?? null,
                'idOptionLevel' => $request['idOptionLevel'] ?? null,
                'description' => $request['description'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            if(!empty($request['levels'])){
                $coefficient->levels()->sync($request['levels']);
            }

            return new CoefficientResource($coefficient);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un coefficient
     *
     * @param Coefficient $coefficient
     * @param $id
     * @return CoefficientResource|\Illuminate\Http\Response
     */
    public function show(Coefficient $coefficient,$id)
    {
        try {
            $coefficient = Coefficient::find($id);
            return new CoefficientResource($coefficient);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un coefficient
     *
     * @param CoefficientRequest $request
     * @param Coefficient $coefficient
     * @param $id
     * @return CoefficientResource|\Illuminate\Http\Response
     */
    public function update(CoefficientRequest $request,Coefficient $coefficient, $id)
    {
        try {
            $coefficient = Coefficient::find($id);
            $coefficient->value = $request->value  ?? $coefficient->value;
            $coefficient->description = $request['description'] ?? $coefficient['description'];
            $coefficient->idMatter = $request->idMatter ?? null;
            $coefficient->idLevel = $request->idLevel  ?? $coefficient->idLevel;
            $coefficient->idOptionLevel = $request->idOptionLevel  ?? $coefficient->idOptionLevel;
            $coefficient->idSchool = $request->idSchool  ?? $coefficient->idSchool;
            $coefficient->idSection =  $request->idSection  ?? $coefficient->idSection;
            $coefficient->updated_by = auth()->user()->id;

            $coefficient->save();

            if(!empty($request['levels'])){
                $coefficient->levels()->sync($request['levels']);
            }
            return new CoefficientResource($coefficient);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un coefficient
     *
     * @param Coefficient $coefficient
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Coefficient $coefficient,$id)
    {
        try {
            $coefficient = Coefficient::find($id);
            $coefficient->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
