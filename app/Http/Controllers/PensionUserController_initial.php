<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Admin\InsolvableRequest;
use App\Http\Requests\Staffs\PensionUserGetAllRequest;
use App\Http\Requests\Staffs\PensionUserRequest;
use App\Http\Resources\Staffs\InscriptionResource;
use App\Http\Resources\Staffs\PensionUserResource;
use App\Models\PensionUser;
use App\Models\Tranche;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PensionUserController_initial extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PensionUserGetAllRequest $request)
    {
        try {
            $pensionUser = $request->validated();
            $idPension = $request['idPension'] ?? null;
            $idTranche = $request['idTranche'] ?? null;
            $idStudent = $request['idStudent'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $date = $request['date'] ?? null;
            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;
            $payment_mode = $request['payment_mode'] ?? null;
            if($idPension != null && $idStudent == null && $idTranche == null){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                            ->where('idSection',$pensionUser['idSection'])
                            ->where('idPension',$request['idPension'])
                            ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idPension == null && $idStudent != null && $idTranche == null){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                            ->where('idSection',$pensionUser['idSection'])
                            ->where('idStudent',$request['idStudent'])
                            ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idPension != null && $idStudent == null && $idTranche != null){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                                ->where('idSection',$pensionUser['idSection'])
                                ->where('idPension',$request['idPension'])
                                ->where('idTranche',$request['idTranche'])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idPension != null && $idStudent != null && $idTranche != null){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                                ->where('idSection',$pensionUser['idSection'])
                                ->where('idPension',$request['idPension'])
                                ->where('idTranche',$request['idTranche'])
                                ->where('idStudent',$request['idStudent'])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];
            }else if($idClasse != null && $idTranche != null){
                $pensionUsers = PensionUser::select('pension_users.id as id','pension_users.advancePayment as advancePayment','pension_users.balancePayment as balancePayment','pension_users.payment_mode as payment_mode','pension_users.solvable as solvable','pension_users.idTranche as idTranche','pension_users.idPension as idPension','pension_users.idStudent as idStudent','pension_users.idSchool as idSchool','pension_users.idSection as idSection','pension_users.created_at as created_at')
                                ->join('users','pension_users.idStudent','=','users.id')
                                ->where('pension_users.idSchool',$pensionUser['idSchool'])
                                ->where('pension_users.idSection',$pensionUser['idSection'])
                                ->where('users.idClasse',$request['idClasse'])
                                ->where('pension_users.idTranche',$request['idTranche'])
                                ->orderBy("pension_users.id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else if($idClasse != null && $date != null){
                $pensionUsers = PensionUser::select('pension_users.id as id','pension_users.advancePayment as advancePayment','pension_users.balancePayment as balancePayment','pension_users.payment_mode as payment_mode','pension_users.solvable as solvable','pension_users.idTranche as idTranche','pension_users.idPension as idPension','pension_users.idStudent as idStudent','pension_users.idSchool as idSchool','pension_users.idSection as idSection','pension_users.created_at as created_at')
                                ->join('users','pension_users.idStudent','=','users.id')
                                ->where('pension_users.idSchool',$pensionUser['idSchool'])
                                ->where('pension_users.idSection',$pensionUser['idSection'])
                                ->where('users.idClasse',$request['idClasse'])
                                ->whereDate('pension_users.created_at', $request['date'])
                                ->orderBy("pension_users.id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else if($idClasse != null){
                $pensionUsers = PensionUser::select('pension_users.id as id','pension_users.advancePayment as advancePayment','pension_users.balancePayment as balancePayment','pension_users.payment_mode as payment_mode','pension_users.solvable as solvable','pension_users.idTranche as idTranche','pension_users.idPension as idPension','pension_users.idStudent as idStudent','pension_users.idSchool as idSchool','pension_users.idSection as idSection','pension_users.created_at as created_at')
                                ->join('users','pension_users.idStudent','=','users.id')
                                ->where('pension_users.idSchool',$pensionUser['idSchool'])
                                ->where('pension_users.idSection',$pensionUser['idSection'])
                                ->where('users.idClasse',$request['idClasse'])
                                ->orderBy("pension_users.id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else if($date != null){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                                ->where('idSection',$pensionUser['idSection'])
                                ->whereDate('created_at', $request['date'])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else if($date_start != null && $date_end){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                                ->where('idSection',$pensionUser['idSection'])
                                ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [
                                    $request['date_start'],
                                    $request['date_end']
                                ])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else if($date_start != null && $date_end && $payment_mode != null){
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                                ->where('idSection',$pensionUser['idSection'])
                                ->where('payment_mode',$request['payment_mode'])
                                ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [
                                    $request['date_start'],
                                    $request['date_end']
                                ])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');

                return [
                    'data' => PensionUserResource::collection($pensionUsers),
                    'sommes' => $totalAdvancePayment,
                ];

            }else{
                $pensionUsers = PensionUser::where('idSchool',$pensionUser['idSchool'])
                                ->where('idSection',$pensionUser['idSection'])
                                ->orderBy("id", "desc")->get();

                $totalAdvancePayment = $pensionUsers->sum('advancePayment');


                return [
                    'data' => PensionUserResource::collection($pensionUsers),
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
    public function store(PensionUserRequest $request)
    {
        try {

            $pensionUser = $request->validated();

            $studentPension = PensionUser::where('idStudent',$request['idStudent'])
                                          ->where('idPension',$request['idPension'])
                                          ->latest('created_at')->first();


            $tranche = Tranche::select('id','name','price','deadline')
                                ->where('idPension',$request['idPension'])
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

            $sumtranche = Tranche::select('id','name','price')
                                ->where('idPension',$request['idPension'])
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->sum('price');

            $compteur = 1;



            switch ($studentPension) {
                case null:
                    $tabUser = array();
                    if ($request['advancePayment'] > $sumtranche) {
                        return json_encode(array('message' => 'Le montant depasse la pension'));
                    }else{
                        for ($i=0; $i < $tranche->count(); $i++) {
                            $pensionUser = new PensionUser();
                            $pensionUser->idStudent = $request['idStudent'];
                            $pensionUser->idPension = $request['idPension'];
                            $pensionUser->idTranche = $tranche[$i]['id'];
                            $pensionUser->idSchool = $request['idSchool'];
                            $pensionUser->idSection = $request['idSection'];
                            if($request['advancePayment'] < $tranche[$i]['price']){
                                if($compteur != 1){
                                    $request['advancePayment'] = $compteur;
                                }
                                $pensionUser->advancePayment = $request['advancePayment'];
                                $pensionUser->balancePayment = $tranche[$i]['price'] - $request['advancePayment'];
                                $pensionUser->payment_mode = $request['payment_mode'] ;
                                $pensionUser->solvable = "avancé" ;
                                $pensionUser->created_by = auth()->user()->id;
                                $pensionUser->save();
                                $tabUser[$i] = new PensionUserResource($pensionUser);
                                break;

                            }else if($request['advancePayment'] > $tranche[$i]['price']){
                                $pensionUser->advancePayment = $tranche[$i]['price'];
                                $pensionUser->balancePayment = 0;
                                $pensionUser->payment_mode = $request['payment_mode'] ;
                                $pensionUser->solvable = "terminé" ;
                                $pensionUser->created_by = auth()->user()->id;
                                $pensionUser->save();
                                $tabUser[$i] = new PensionUserResource($pensionUser);
                                $compteur = $request['advancePayment'] - $tranche[$i]['price'];
                                $request['advancePayment'] = $compteur;

                            }else{
                                $pensionUser->advancePayment = $tranche[$i]['price'];
                                $pensionUser->balancePayment = 0;
                                $pensionUser->payment_mode = $request['payment_mode'] ;
                                $pensionUser->solvable = "terminé" ;
                                $pensionUser->created_by = auth()->user()->id;
                                $pensionUser->save();
                                $tabUser[$i] = new PensionUserResource($pensionUser);
                                $compteur = $request['advancePayment'] - $tranche[$i]['price'];
                                break;
                            }


                        }
                        return PensionUserResource::collection($tabUser);

                    }

                    break;

                default:
                    $montant = 0;
                    $tabPen = array();
                    for ($i=0; $i < $tranche->count(); $i++) {
                        $studentPensions = PensionUser::where('idStudent',$request['idStudent'])
                                          ->where('idPension',$request['idPension'])
                                          ->where('idTranche',$tranche[$i]['id'])
                                          ->latest('created_at')->first();
                        $sumstudentPensions = PensionUser::where('idStudent',$request['idStudent'])
                                          ->where('idPension',$request['idPension'])
                                          ->sum('advancePayment');


                        if($request['advancePayment'] != 0){
                           switch ($studentPensions) {
                                case null :
                                    $tabUser = array();
                                    $montant = $sumtranche - $sumstudentPensions;
                                    if($request['advancePayment'] > $montant){
                                        return json_encode(array('message' => 'Le montant depasse le reste de la pension'));
                                    }else{
                                        $pensionUser = new PensionUser();
                                        $pensionUser->idStudent = $request['idStudent'];
                                        $pensionUser->idPension = $request['idPension'];
                                        $pensionUser->idTranche = $tranche[$i]['id'];
                                        $pensionUser->idSchool = $request['idSchool'];
                                        $pensionUser->idSection = $request['idSection'];
                                        if($request['advancePayment'] < $tranche[$i]['price']){

                                            $pensionUser->advancePayment = $request['advancePayment'];
                                            $pensionUser->balancePayment = $tranche[$i]['price'] - $request['advancePayment'];
                                            $pensionUser->payment_mode = $request['payment_mode'] ;
                                            $pensionUser->solvable = "avancé" ;
                                            $pensionUser->created_by = auth()->user()->id;
                                            $pensionUser->save();
                                            $tabPen[$i] = new PensionUserResource($pensionUser);
                                            $request['advancePayment'] = 0;
                                            break;

                                        }else if($request['advancePayment'] > $tranche[$i]['price']){
                                            $pensionUser->advancePayment = $tranche[$i]['price'];
                                            $pensionUser->balancePayment = 0;
                                            $pensionUser->payment_mode = $request['payment_mode'] ;
                                            $pensionUser->solvable = "terminé" ;
                                            $pensionUser->created_by = auth()->user()->id;
                                            $pensionUser->save();
                                            $tabPen[$i] = new PensionUserResource($pensionUser);
                                            $compteur = $request['advancePayment'] - $tranche[$i]['price'];
                                            $request['advancePayment'] = $request['advancePayment'] - $studentPensions['balancePayment'];

                                        }else{

                                            $pensionUser->advancePayment = $tranche[$i]['price'];
                                            $pensionUser->balancePayment = 0;
                                            $pensionUser->payment_mode = $request['payment_mode'] ;
                                            $pensionUser->solvable = "terminé" ;
                                            $pensionUser->created_by = auth()->user()->id;
                                            $pensionUser->save();
                                            $tabPen[$i] = new PensionUserResource($pensionUser);
                                            $compteur = 1;
                                            $request['advancePayment'] = 0;


                                            break;

                                        }

                                    }

                                    break;

                                default:
                                    $tabUser = array();
                                    $montant = $sumtranche - $sumstudentPensions;
                                    if($request['advancePayment'] > $montant){
                                        if($montant == 0 ){
                                            return $this->sendResponse(null, 'Tout a été payé');
                                        }else{
                                            return json_encode(array('message' => 'Le montant depasse le reste de la pension'));
                                        }

                                    }else{
                                        if($studentPensions['balancePayment'] != 0){
                                            $pensionUser = new PensionUser();
                                            $pensionUser->idStudent = $request['idStudent'];
                                            $pensionUser->idPension = $request['idPension'];
                                            $pensionUser->idTranche = $tranche[$i]['id'];
                                            $pensionUser->idSchool = $request['idSchool'];
                                            $pensionUser->idSection = $request['idSection'];
                                            if($request['advancePayment'] < $studentPensions['balancePayment']){
                                                if($compteur != 1){
                                                    $request['advancePayment'] = $compteur;
                                                }
                                                $pensionUser->advancePayment = $request['advancePayment'];
                                                $pensionUser->balancePayment = $studentPensions['balancePayment'] - $request['advancePayment'];
                                                $pensionUser->payment_mode = $request['payment_mode'] ;
                                                $pensionUser->solvable = "avancé" ;
                                                $pensionUser->created_by = auth()->user()->id;
                                                $pensionUser->save();
                                                $request['advancePayment'] = 0;
                                                $tabPen[$i] = new PensionUserResource($pensionUser);

                                            }else if($request['advancePayment'] > $studentPensions['balancePayment']){
                                                $pensionUser->advancePayment = $studentPensions['balancePayment'];
                                                $pensionUser->balancePayment = 0;
                                                $pensionUser->payment_mode = $request['payment_mode'] ;
                                                $pensionUser->solvable = "terminé" ;
                                                $pensionUser->created_by = auth()->user()->id;
                                                $pensionUser->save();
                                                $tabPen[$i] = new PensionUserResource($pensionUser);
                                                $compteur = $request['advancePayment'] - $studentPensions['balancePayment'];
                                                $request['advancePayment'] = $request['advancePayment'] - $studentPensions['balancePayment'];

                                            }else {
                                                $pensionUser->advancePayment = $studentPensions['balancePayment'];
                                                $pensionUser->balancePayment = $request['advancePayment'] - $studentPensions['balancePayment'];
                                                $pensionUser->payment_mode = $request['payment_mode'] ;
                                                $pensionUser->solvable = "terminé" ;
                                                $pensionUser->created_by = auth()->user()->id;
                                                $pensionUser->save();
                                                $tabPen[$i] = new PensionUserResource($pensionUser);
                                                $compteur = 1;
                                                $request['advancePayment'] = $request['advancePayment'] - $studentPensions['balancePayment'];
                                            }
                                        }
                                    }

                                    break;
                            }
                            /*
                            if(!empty($tabUser)){
                                $tabPen[$i] = $tabUser;
                            }
                            */
                        }



                    }

                    return PensionUserResource::collection($tabPen);
                    break;
            }


        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

    }

    public function balancePension(Request $request)
    {
        try {
            $sumtranche = Tranche::select('id','name','price')
                                ->where('idPension',$request['idPension'])
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->sum('price');

            $sumstudentPensionUser = PensionUser::where('idStudent',$request['idStudent'])
                                                        ->where('idPension',$request['idPension'])
                                                        ->sum('advancePayment');
            $montantRestant = $sumtranche - $sumstudentPensionUser;

            return json_encode(array('message' => $montantRestant));


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
            $pensionUser = PensionUser::find($id);
            return new PensionUserResource($pensionUser);
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
    public function update(PensionUserRequest $request, $id)
    {


    }

    /**
     * Insolvable the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insolvable(InsolvableRequest $request)
    {
        try {

            $insolvableUser = $request->validated();
            $idTranche = $request['idTranche'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            if(!empty($request['idSchool']) && !empty($request['idSchool'])){
                if(!empty($request['idTranche']) && !empty($request['idClasse'])){
                    $pensionUser = DB::table('pension_users')
                    ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                    ->where('idTranche',$request['idTranche'])
                    ->where('idSchool',$request['idSchool'])
                    ->where('idSection',$request['idSection'])
                    ->where('solvable','terminé')
                    ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                    $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                    $join->on('users.id', '=', 'pension_users.idStudent');
                                })
                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                ->join('roles','model_has_roles.role_id','=','roles.id')
                                ->where('roles.id',8)
                                ->where('users.idSchool',$request['idSchool'])
                                ->where('users.idSection',$request['idSection'])
                                ->whereNull('pension_users.idStudent')
                                ->where('users.idClasse',$request['idClasse'])
                                ->get();

                    return InscriptionResource::collection($users);
                }else if(!empty($request['idTranche'])){
                    $pensionUser = DB::table('pension_users')
                                            ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                            ->where('idTranche',$request['idTranche'])
                                            ->where('idSchool',$request['idSchool'])
                                            ->where('idSection',$request['idSection'])
                                            ->where('solvable','terminé')
                                            ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');


                    $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                                $join->on('users.id', '=', 'pension_users.idStudent');
                                })
                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                ->join('roles','model_has_roles.role_id','=','roles.id')
                                ->where('roles.id',8)
                                ->where('users.idSchool',$request['idSchool'])
                                ->where('users.idSection',$request['idSection'])
                                ->whereNull('pension_users.idStudent')
                                ->get();

                    return InscriptionResource::collection($users);
                }else if(!empty($request['idClasse'])){
                    $pensionUser = DB::table('pension_users')
                                                ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                                ->where('idSchool',$request['idSchool'])
                                                ->where('idSection',$request['idSection'])
                                                ->where('solvable','terminé')
                                                ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                    $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                                $join->on('users.id', '=', 'pension_users.idStudent');
                                })
                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                ->join('roles','model_has_roles.role_id','=','roles.id')
                                ->where('roles.id',8)
                                ->where('users.idSchool',$request['idSchool'])
                                ->where('users.idSection',$request['idSection'])
                                ->whereNull('pension_users.idStudent')
                                ->where('users.idClasse',$request['idClasse'])
                                ->get();

                    return InscriptionResource::collection($users);
                }

                $pensionUser = DB::table('pension_users')
                                                ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                                ->where('idSchool',$request['idSchool'])
                                                ->where('idSection',$request['idSection'])
                                                ->where('solvable','terminé')
                                                ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                            ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                $join->on('users.id', '=', 'pension_users.idStudent');
                            })
                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                            ->join('roles','model_has_roles.role_id','=','roles.id')
                            ->where('roles.id',8)
                            ->where('users.idSchool',$request['idSchool'])
                            ->where('users.idSection',$request['idSection'])
                            ->whereNull('pension_users.idStudent')
                            ->get();

                return InscriptionResource::collection($users);
            }
            /*
            switch ($idTranche) {
                case null:
                        switch ($idClasse) {
                            case null:
                                    $pensionUser = DB::table('pension_users')
                                                ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                                ->where('idSchool',$request['idSchool'])
                                                ->where('idSection',$request['idSection'])
                                                ->where('solvable','terminé')
                                                ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                                    $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                                ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                                    $join->on('users.id', '=', 'pension_users.idStudent');
                                                })
                                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                                ->join('roles','model_has_roles.role_id','=','roles.id')
                                                ->where('roles.id',8)
                                                ->whereNull('pension_users.idStudent')
                                                ->get();

                                    return InscriptionResource::collection($users);
                                break;

                            default:
                                    $pensionUser = DB::table('pension_users')
                                                ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                                ->where('idSchool',$request['idSchool'])
                                                ->where('idSection',$request['idSection'])
                                                ->where('solvable','terminé')
                                                ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                                    $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                                ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                                                $join->on('users.id', '=', 'pension_users.idStudent');
                                                })
                                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                                ->join('roles','model_has_roles.role_id','=','roles.id')
                                                ->where('roles.id',8)
                                                ->whereNull('pension_users.idStudent')
                                                ->where('users.idClasse',$request['idClasse'])
                                                ->get();

                                    return InscriptionResource::collection($users);
                                break;
                        }

                    break;

                default:
                    switch ($idClasse) {
                        case null:
                                $pensionUser = DB::table('pension_users')
                                            ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                            ->where('idTranche',$request['idTranche'])
                                            ->where('idSchool',$request['idSchool'])
                                            ->where('idSection',$request['idSection'])
                                            ->where('solvable','terminé')
                                            ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                                $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                            ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                                            $join->on('users.id', '=', 'pension_users.idStudent');
                                            })
                                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                            ->join('roles','model_has_roles.role_id','=','roles.id')
                                            ->where('roles.id',8)
                                            ->whereNull('pension_users.idStudent')
                                            ->get();

                                return InscriptionResource::collection($users);
                            break;

                        default:
                            $pensionUser = DB::table('pension_users')
                                        ->select('idStudent','idPension','idTranche','idSchool','idSection','advancePayment','balancePayment','payment_mode','solvable','created_by')
                                        ->where('idTranche',$request['idTranche'])
                                        ->where('idSchool',$request['idSchool'])
                                        ->where('idSection',$request['idSection'])
                                        ->where('solvable','terminé')
                                        ->groupBy('idStudent', 'idPension', 'idTranche', 'idSchool', 'idSection', 'advancePayment', 'balancePayment', 'payment_mode', 'solvable', 'created_by');

                            $users = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse')
                                        ->leftjoinSub($pensionUser, 'pension_users', function (JoinClause $join) {
                                            $join->on('users.id', '=', 'pension_users.idStudent');
                                        })
                                        ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->join('roles','model_has_roles.role_id','=','roles.id')
                                        ->where('roles.id',8)
                                        ->whereNull('pension_users.idStudent')
                                        ->where('users.idClasse',$request['idClasse'])
                                        ->get();

                            return InscriptionResource::collection($users);

                            break;
                    }

                    break;
            }
            */
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PensionUser $pensionUser,$id)
    {
        try {
            $pensionUser = PensionUser::findOrFail($id);
            $pensionUser->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

    }

    public function getsumtransaction(Request $request)
    {
        try {
                $idStudent = $request['idStudent'] ?? null;
                $sumTransac = null;
                switch ($idStudent) {
                    case null:
                        $sumTransac = DB::table('pension_users')
                                        ->select(DB::raw('SUM(advancePayment) as sumTransaction'))
                                        ->where('idSection',$request['idSection'])
                                        ->where('idSchool',$request['idSchool'])
                                        ->get();
                        break;

                    default:
                        $sumTransac = DB::table('pension_users')
                                        ->select(DB::raw('SUM(advancePayment) as sumTransaction'))
                                        ->where('idSection',$request['idSection'])
                                        ->where('idSchool',$request['idSchool'])
                                        ->where('idStudent',$request['idStudent'])
                                        ->get();
                        break;
                }


                return json_encode($sumTransac);

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

    }

    public function getpensiontransaction(Request $request)
    {
        try {
                $date = $request['date'] ?? null;
                $idSchool = $request['idSchool'] ?? null;
                $idSection = $request['idSection'] ?? null;
                if(!empty($request['idSchool']) && !empty($request['idSection']) && !empty($request['date'])){
                    $transactions = PensionUser::whereDate('created_at', $date)
                                        ->where('idSchool', 2)
                                        ->where('idSection', 2)
                                        ->orderBy("id", "desc")
                                        ->get();


                    $sommes = PensionUser::select(
                            DB::raw('SUM(CASE WHEN payment_mode = "Mtn Money" THEN advancePayment ELSE 0 END) AS momo_total'),
                            DB::raw('SUM(CASE WHEN payment_mode = "Cash" THEN advancePayment ELSE 0 END) AS cash_total'),
                            DB::raw('SUM(CASE WHEN payment_mode = "Orange Money" THEN advancePayment ELSE 0 END) AS om_total'),
                            DB::raw('SUM(CASE WHEN payment_mode = "Credit card" THEN advancePayment ELSE 0 END) AS creditcard_total')
                        )
                        ->whereDate('created_at', $date)
                        ->where('idSchool', 2)
                        ->where('idSection', 2)
                        ->first();


                    $response = [
                        'transactions' => $transactions,
                        'sommes' => [
                            'momo' => $sommes->momo_total,
                            'cash' => $sommes->cash_total,
                            'om' => $sommes->om_total,
                            'creditcard' => $sommes->creditcard_total,
                        ],
                    ];


                    return response()->json($response);
                }


        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

    }
}
