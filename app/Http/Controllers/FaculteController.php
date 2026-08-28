<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\FaculteRequest;
use App\Http\Resources\FaculteResource;
use App\Models\Faculte;
use Illuminate\Support\Facades\Log;

class FaculteController extends BaseController
{
//    public function index(FaculteRequest $request)
//    {
//        try {
//            $pageItems = $request['pageItems'] ?? 1; // page de pagination
//            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
//
//            $facultes = Faculte::where('idCampus', $request->idCampus);
//
//            if(!is_null($request->idSchool)) $facultes = $facultes->where('idSchool', $request->idSchool);
//            if(!is_null($request->idSection)) $facultes = $facultes->where('idSection', $request->idSection);
//
//            return FaculteResource::collection(
//                $facultes
//                    ->orderBy('name')
//                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
//            );
//        } catch (\Throwable $th) {
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//        }
//    }
//
//    public function show($idFaculte)
//    {
//        try {
//            return FaculteResource::make(
//                Faculte::findOrFail($idFaculte)
//            );
//        }  catch (\Throwable $th) {
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//        }
//    }
//
//    public function store(FaculteRequest $request)
//    {
//        try {
//            $faculte = Faculte::create([
//                'name' => $request->name,
//                'idCampus' => $request->idCampus,
//                'idSchool' => $request->idSchool,
//                'idSection' => $request->idSection,
//                'created_by' => auth()->user()->id
//            ]);
//
//            Log::info("Ajout d'une faculté", ['auteur' => auth()->user()->id, 'faculte' => $faculte->id]);
//
//            return FaculteResource::make($faculte);
//        } catch (\Throwable $th) {
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//        }
//    }
//
//    public function update(FaculteRequest $request, $idFaculte)
//    {
//        try {
//            $faculte = Faculte::findOrFail($idFaculte);
//            $faculte->update([
//                'name' => $request->name ?? $faculte->name,
//                'idCampus' => $request->idCampus ?? $faculte->idCampus,
//                'idSchool' => $request->idSchool ?? $faculte->idSchool,
//                'idSection' => $request->idSection ?? $faculte->idSection,
//                'updated_by' => auth()->user()->id
//            ]);
//
//            Log::info("maj d'une faculté", ['auteur' => auth()->user()->id, 'faculte' => $faculte->id]);
//
//            return FaculteResource::make($faculte);
//        } catch (\Throwable $th) {
//            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
//        }
//    }
}
