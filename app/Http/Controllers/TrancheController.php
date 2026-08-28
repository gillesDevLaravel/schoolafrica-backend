<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Staffs\TrancheResource;
use App\Http\Requests\Staffs\TrancheRequest;
use App\Http\Requests\Staffs\TrancheGetAllRequest;
use App\Models\Tranche;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Pension;
use App\Models\PensionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Tranche
 */
class TrancheController extends BaseController
{
    /**
     * Listing des tranches
     *
     * @param TrancheGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(TrancheGetAllRequest $request)
    {
        try {
            $tranche = $request->validated();
            $idSection = $request['idSection'] ?? null;
            $idPension = $request['idPension'] ?? null;

            $tranches = Tranche::where('idSchool',$tranche['idSchool']);

            if(!is_null($idSection)) $tranches = $tranches->where('idSection',$tranche['idSection']);
            if(!is_null($idPension)) $tranches = $tranches->where('idPension',$tranche['idPension']);

            return TrancheResource::collection(
                $tranches
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
//    public function store(TrancheRequest $request)
    public function store(Request $request)
    {
        try {
            $tranches = $request->tranches;

            $results = [];

            foreach ($tranches as $tranche) {
                $pension = DB::table('pensions')
                    ->select('price', 'idSchool', 'idSection')
                    ->where('id',$tranche['idPension'])
                    ->first();
                
                $reqTranche = DB::table('tranches')
                    ->select(DB::raw('SUM(price) as totalTranche'))
                    ->where('idPension',$tranche['idPension'])
                    ->first();

                if($tranche['price'] >= 0){
                    switch ($reqTranche) {
                        case null:
                            if($tranche['price'] > $pension->price){
                                return json_encode(array('message' => 'La tranche depasse la pension'));
                            }else{
                                $tranche = Tranche::create([
                                    'name' => $tranche['name'],
                                    'price' => $tranche['price'],
                                    'deadline' => $tranche['deadline'],
                                    'idPension' => $tranche['idPension'],
                                    'idSchool' => $pension->idSchool,
                                    'idSection' => $pension->idSection,
                                    'created_by' => auth()->user()->id
                                ]);

                                $results[] = $tranche;
                            }
                            break;

                        default:
                            if($tranche['price'] > ($pension->price - $reqTranche->totalTranche)){
                                if(($pension->price - $reqTranche->totalTranche) == 0){
                                    return json_encode(array('message' => __('tranche.message')));
                                }else{
                                    return json_encode(array('message' => __('tranche.message2').($pension->price - $reqTranche->totalTranche).__('tranche.message3')));
                                }

                            }else{
                                $tranche = Tranche::create([
                                    'name' => $tranche['name'],
                                    'price' => $tranche['price'],
                                    'deadline' => $tranche['deadline'],
                                    'idPension' => $tranche['idPension'],
                                    'idSchool' => $pension->idSchool, //$request['idSchool'],
                                    'idSection' => $pension->idSection, //$request['idSection'],
                                    'created_by' => auth()->user()->id
                                ]);

                                $results[] = $tranche;
                            }
                            break;
                    }
                }else{
                    return json_encode(array('message' => __('tranche.message4')));
                }
            }

            return TrancheResource::collection($results);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

//    public function bulkStore(Request $request)
//    {
////        $this->validate($request, [
////            'tranches' => 'required|array'
////        ]);
//
////        $tranches = $request->tranches;
//
//        $tranches = [
//            [
//                'name' => "1",
//                'price' => 250000,
//                'deadline' => date("Y-m-d", strtotime("+30 day")),
//                'idPension' => 33,
//            ],
//            [
//                'name' => "2",
//                'price' => 250000,
//                'deadline' => date("Y-m-d", strtotime("+90 day")),
//                'idPension' => 33,
//            ],
//        ];
//
//        $results = [];
////        foreach ($tranches as $tranche) {
////            $tmp_request = new TrancheRequest();
////
////            $tmp_request->name = $tranche['name'];
////            $tmp_request->price = $tranche['price'];
////            $tmp_request->deadline = $tranche['deadline'];
////            $tmp_request->idPension = $tranche['idPension'];
////
////            $results[] = $this->store($tmp_request);
////        }
//
//        return $results;
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tranche $tranche,$id)
    {
        try {
            $tranche = Tranche::find($id);
            return new TrancheResource($tranche);
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
    public function update(TrancheRequest $request,Tranche $tranche, $id)
    {
        try {
            $tranche = Tranche::findOrFail($id);

            $pension = Pension::select('price', 'idSchool', 'idSection')
                ->where('id', $request['idPension'])
                ->firstOrFail();

            $tranche->name = $request['name'];
            $tranche->price = $request['price'];
            $tranche->deadline = $request['deadline'];
            $tranche->idPension = $request['idPension'];
            $tranche->idSchool = $pension->idSchool;
            $tranche->idSection =  $pension->idSection;
            $tranche->updated_by = auth()->user()->id;

            $tranche->save();
            return new TrancheResource($tranche);
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
    public function destroy(Tranche $tranche,$id)
    {
        try {
            $tranche = Tranche::findOrFail($id);

            $nbrePensionUser = PensionUser::where('idPension',$tranche->idPension)
                ->where('idTranche',$id)
                ->count();

            if($nbrePensionUser != 0){
                return $this->sendError('impossible, paiement tranche existant');
            }else{
//                $tranche->delete();
                $tranche->update([
                    'deleted' => true,
                    'deleted_by' => auth()->user()->id,
                ]);
                return $this->sendResponses(null);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
