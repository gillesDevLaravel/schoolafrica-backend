<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ParentalMonitoringGetRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\ParentalMonitoringResource;
use App\Http\Requests\Staffs\ParentalMonitoringRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\ParentalMonitoring;
use Illuminate\Support\Facades\Log;

/**
 * @group Parental Monitoring
 */
class ParentalMonitoringController extends BaseController
{
    /**
     * Lister les contrôles parentaux
     *
     * @param ParentalMonitoringGetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(ParentalMonitoringGetRequest $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idStudent = $request['idStudent'] ?? null;

            $parentalMonitoring = ParentalMonitoring::where('idSchool', $idSchool);

            if(!is_null($idSection)) $parentalMonitoring = $parentalMonitoring->where('idSection',$request['idSection']);
            if(!is_null($idClasse)) $parentalMonitoring = $parentalMonitoring->where('idClasse',$request['idClasse']);
            if(!is_null($idStudent)) $parentalMonitoring = $parentalMonitoring->where('idStudent',$request['idStudent']);

            return ParentalMonitoringResource::collection(
                $parentalMonitoring
                    ->orderBy("id", "desc")
                    ->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParentalMonitoringRequest $request)
    {
        try {
            $parentalMonitoring = $request->validated();

            $parentalMonitoring = ParentalMonitoring::create([
                'name' => $request['name'],
                'type' => $request['type'],
                'comment' => $request['comment'],
                'answer' => $request['answer'],
                'idParent' => $request['idParent'],
                'idStudent' => $request['idStudent'],
                'idClasse' => $request['idClasse'],
                'idSchool' => $request['idSchool'],
                'idSection' => $request['idSection'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            return new ParentalMonitoringResource($parentalMonitoring);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ParentalMonitoring $parentalMonitoring,$id)
    {
        try {
            $parentalMonitoring = ParentalMonitoring::find($id);
            return new ParentalMonitoringResource($parentalMonitoring);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParentalMonitoringRequest $request,ParentalMonitoring $parentalMonitoring, $id)
    {
        try {
            $parentalMonitoring = ParentalMonitoring::find($id);
            $parentalMonitoring->name = $request['name'];
            $parentalMonitoring->type = $request['type'];
            $parentalMonitoring->comment = $request['comment'];
            $parentalMonitoring->answer = $request['answer'];
            $parentalMonitoring->idParent = $request['idParent'];
            $parentalMonitoring->idStudent = $request['idStudent'];
            $parentalMonitoring->idClasse = $request['idClasse'];
            $parentalMonitoring->idSchool = $request['idSchool'];
            $parentalMonitoring->idSection = $request['idSection'];
            $parentalMonitoring->updated_by = auth()->user()->id;

            $parentalMonitoring->save();
            return new ParentalMonitoringResource($parentalMonitoring);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParentalMonitoring $parentalMonitoring,$id)
    {
        try {
            $parentalMonitoring = ParentalMonitoring::find($id);
            $parentalMonitoring->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
