<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\FeeUserRequest;
use App\Http\Requests\Staffs\FeeUserRequestGetAll;
use App\Http\Resources\Staffs\FeeUserResource;
use App\Models\Fee;
use App\Models\FeeUser;

class FeeUserController_initial extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FeeUserRequestGetAll $request)
    {
        try {
            $feeUser = $request->validated();
            $idFee = $request['idFee'] ?? null;
            $idStudent = $request['idStudent'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $date = $request['date'] ?? null;
            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;
            $payment_mode = $request['payment_mode'] ?? null;
            if($idFee != null && $idStudent != null){
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                    ->where('idSection',$feeUser['idSection'])
                                    ->where('idFee',$request['idFee'])
                                    ->where('idStudent',$request['idStudent'])
                                    ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idFee != null && $idStudent == null){
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                    ->where('idSection',$feeUser['idSection'])
                                    ->where('idFee',$request['idFee'])
                                    ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idFee == null && $idStudent != null){
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                    ->where('idSection',$feeUser['idSection'])
                                    ->where('idStudent',$request['idStudent']) //j'ai enlevé $idStudent pour idStudent dans la condition
                                    ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idClasse != null){
                $feeUsers = FeeUser::select('fee_user.id as id','fee_user.advancePayment as advancePayment','fee_user.balancePayment as balancePayment','fee_user.payment_mode as payment_mode','fee_user.solvable as solvable','fee_user.idFee as idFee','fee_user.idStudent as idStudent','fee_user.idSchool as idSchool','fee_user.idSection as idSection','fee_user.created_at as created_at')
                                    ->join('users','fee_user.idStudent','=','users.id')
                                    ->where('fee_user.idSchool',$feeUser['idSchool'])
                                    ->where('fee_user.idSection',$feeUser['idSection'])
                                    ->where('users.idClasse',$request['idClasse'])
                                    ->orderBy("fee_user.id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($date != null){
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                    ->where('idSection',$feeUser['idSection'])
                                    ->whereDate('created_at', $request['date'])
                                    ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($date_start != null && $date_end){
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                    ->where('idSection',$feeUser['idSection'])
                                    ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [
                                        $request['date_start'],
                                        $request['date_end']
                                    ])
                                    ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($date_start != null && $date_end && $payment_mode != null){
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                ->where('idSection',$feeUser['idSection'])
                                ->where('payment_mode',$request['payment_mode'])
                                ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [
                                    $request['date_start'],
                                    $request['date_end']
                                ])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else{
                $feeUsers = FeeUser::where('idSchool',$feeUser['idSchool'])
                                    ->where('idSection',$feeUser['idSection'])
                                    ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $feeUsers->sum('advancePayment');

                return [
                    'data' => FeeUserResource::collection($feeUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeUserRequest $request)
    {
        try {
            $feeUser = $request->validated();

            $studentFee = FeeUser::where('idStudent',$request['idStudent'])
                                            ->where('idFee',$request['idFee'])
                                            ->latest('created_at')->first();


            $fee = Fee::select('fees.id as id','fees.name as name','fees.price as price','fees.deadline as deadline')
                                ->join('fee_has_level','fee_has_level.fee_id','=','fees.id')
                                ->join('levels','levels.id','=','fee_has_level.level_id')
                                ->where('fee_has_level.level_id',$request['idLevel'])
                                ->where('fees.idSchool',$request['idSchool'])
                                ->where('fees.idSection',$request['idSection'])
                                ->get();

            switch ($request['advancePayment']) {
                case null:
                        return json_encode(array('message' => 'Le montant d\'avance ne peut etre null'));
                    break;

                case 0:
                        return json_encode(array('message' => 'Le montant ne peut pas etre 0'));
                    break;

                default:

                    switch ($studentFee) {
                        case null:
                            $tabUser = array();
                            if($request['advancePayment'] < 0){
                                return json_encode(array('message' => 'Le montant ne peut pas etre negatif'));
                            }else if ($request['advancePayment'] > $fee[0]['price']) {
                                return json_encode(array('message' => 'Le montant depasse les frais'));
                            }else{

                                    for($i=0;$i<$fee->count();$i++){
                                            if($fee[$i]['id'] == $request['idFee']){
                                                $feeUser = new FeeUser();
                                                $feeUser->idStudent = $request['idStudent'];
                                                $feeUser->idFee = $fee[$i]['id'];
                                                $feeUser->idSchool = $request['idSchool'];
                                                $feeUser->idSection = $request['idSection'];
                                                if($request['advancePayment'] < $fee[$i]['price']){

                                                    $feeUser->advancePayment = $request['advancePayment'];
                                                    $feeUser->balancePayment = $fee[$i]['price'] - $request['advancePayment'];
                                                    $feeUser->payment_mode = $request['payment_mode'] ;
                                                    $feeUser->solvable = "avancé" ;
                                                    $feeUser->created_by = auth()->user()->id;
                                                    $feeUser->save();
                                                    $tabUser["FeePaye"] = new FeeUserResource($feeUser);
                                                    break;

                                                }else if($request['advancePayment'] > $fee[$i]['price']){
                                                    $feeUser->advancePayment = $fee[$i]['price'];
                                                    $feeUser->balancePayment = 0;
                                                    $feeUser->payment_mode = $request['payment_mode'] ;
                                                    $feeUser->solvable = "terminé" ;
                                                    $feeUser->created_by = auth()->user()->id;
                                                    $feeUser->save();
                                                    $tabUser["FeePaye"] = new FeeUserResource($feeUser);
                                                    $compteur = $request['advancePayment'] - $fee[$i]['price'];
                                                    $request['advancePayment'] = $compteur;

                                                }else{
                                                    $feeUser->advancePayment = $fee[$i]['price'];
                                                    $feeUser->balancePayment = 0;
                                                    $feeUser->payment_mode = $request['payment_mode'] ;
                                                    $feeUser->solvable = "terminé" ;
                                                    $feeUser->created_by = auth()->user()->id;
                                                    $feeUser->save();
                                                    $tabUser["FeePaye"] = new FeeUserResource($feeUser);
                                                    $compteur = $request['advancePayment'] - $fee[$i]['price'];
                                                    break;
                                            }
                                        }
                                    }

                                return FeeUserResource::collection($tabUser);
                            }
                            break;

                        default:
                            $tabPen = array();

                            $fee = Fee::find($studentFee['idFee']);
                            switch ($studentFee['balancePayment']) {
                                case 0:
                                        return json_encode(array('message' => 'La totalite des frais a deja ete payee'));
                                    break;

                                default:
                                    if ($request['advancePayment'] < 0) {
                                        return json_encode(array('message' => 'Le montant ne peut pas etre negatif'));
                                    }else{
                                            $feeUser = new FeeUser();
                                            $feeUser->idStudent = $request['idStudent'];
                                            $feeUser->idFee = $fee['id'];
                                            $feeUser->idSchool = $request['idSchool'];
                                            $feeUser->idSection = $request['idSection'];
                                            if($request['advancePayment'] > $studentFee['balancePayment']){

                                                return json_encode(array('message' => 'Le montant depasse les frais restant'));

                                            }else if($request['advancePayment'] < $studentFee['balancePayment']){
                                                $feeUser->advancePayment = $request['advancePayment'];
                                                $feeUser->balancePayment = $studentFee['balancePayment'] - $request['advancePayment'];
                                                $feeUser->payment_mode = $request['payment_mode'] ;
                                                $feeUser->solvable = "avancé" ;
                                                $feeUser->created_by = auth()->user()->id;
                                                $feeUser->save();
                                                $tabPen["FeePaye"] = new FeeUserResource($feeUser);

                                            }else{
                                                $feeUser->advancePayment = $request['advancePayment'];
                                                $feeUser->balancePayment = 0;
                                                $feeUser->payment_mode = $request['payment_mode'] ;
                                                $feeUser->solvable = "terminé" ;
                                                $feeUser->created_by = auth()->user()->id;
                                                $feeUser->save();
                                                $tabPen["FeePaye"] = new FeeUserResource($feeUser);
                                                $compteur = $request['advancePayment'] - $fee['price'];
                                                break;
                                            }
                                        }
                                    break;
                            }


                            return FeeUserResource::collection($tabPen);
                            break;
                    }

                    break;

            }


        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    public function balancefee(Request $request)
    {
        try {
            $fee = Fee::select('fees.id as id','fees.name as name','fees.price as price')
                                ->join('fee_has_level','fee_has_level.fee_id','=','fees.id')
                                ->join('levels','levels.id','=','fee_has_level.level_id')
                                ->where('fee_has_level.level_id',$request['idLevel'])
                                ->where('fees.idSchool',$request['idSchool'])
                                ->where('fees.idSection',$request['idSection'])
                                ->where('fees.id',$request['idFee'])
                                ->get();

            $sumstudentFeeUser = FeeUser::where('idStudent',$request['idStudent'])
                                         ->where('idFee',$request['idFee'])
                                                        ->sum('advancePayment');
            $montantRestant = $fee[0]['price'] - $sumstudentFeeUser;

            return json_encode(array('montantRestant' => $montantRestant));


        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $feeUser = FeeUser::find($id);
            return new FeeUserResource($feeUser);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeUser $feeUser,$id)
    {
        try {
            $feeUser = FeeUser::findOrFail($id);
            $feeUser->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

    }
}
