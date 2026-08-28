<?php

namespace App\Services;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Classes;
use App\Models\FeeUser;
use App\Http\Resources\Staffs\FeeUserResource;
use App\Exceptions\ServiceException;
use App\Models\Fee;
use App\Models\FeeUserArchive;
use App\Models\Notification;
use App\Models\PensionUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Log;

class FeeUserService
{
    public function getAllFeeUsers(array $requestData, $archives = false)
    {
        try {
            $feeUser = $requestData;
            $idFee = $requestData['idFee'] ?? null;
            $idSection = $requestData['idSection'] ?? null;
            $idSchool = $requestData['idSchool'] ?? null;
            $idStudent = $requestData['idStudent'] ?? null;
            $idClasse = $requestData['idClasse'] ?? null;
            $date = $requestData['date'] ?? null;
            $date_start = $requestData['date_start'] ?? null;
            $date_end = $requestData['date_end'] ?? null;
            $payment_mode = $requestData['payment_mode'] ?? null;
            $telephone = $requestData['telephone'] ?? null;
            $reference = $requestData['reference'] ?? null;
            $operator = $requestData['operator'] ?? null;

        //    $feeUsers = FeeUser::where('fee_user.idSchool', $feeUser['idSchool']);
            $feeUsers = FeeUser::query();
            if($archives){
                $feeUsers
                    ->withoutGlobalScope('isDeleted')
                    ->where('fee_user.deleted', 1);
            }
            if(!is_null($idSchool)) $feeUsers = $feeUsers->where('fee_user.idSchool', $feeUser['idSchool']);
            if(!is_null($idSection)) $feeUsers = $feeUsers->where('fee_user.idSection', $feeUser['idSection']);
            if(!is_null($telephone)) $feeUsers = $feeUsers->where('fee_user.telephone', $telephone);
            if(!is_null($reference)) $feeUsers = $feeUsers->where('fee_user.reference', $reference);
            if(!is_null($idFee)) $feeUsers = $feeUsers->where('idFee', $idFee);
            if (!is_null($operator)) {
                $feeUsers = $feeUsers->where('fee_user.operator', 'LIKE', '%' . $operator . '%');
            }

            if ($idClasse != null) {
                $feeUsers = $feeUsers->select('fee_user.id as id', 'fee_user.advancePayment as advancePayment', 'fee_user.balancePayment as balancePayment', 'fee_user.payment_mode as payment_mode', 'fee_user.solvable as solvable', 'fee_user.idFee as idFee', 'fee_user.idStudent as idStudent', 'fee_user.idSchool as idSchool', 'fee_user.idSection as idSection', 'fee_user.created_at as created_at')
                    ->join('users', 'fee_user.idStudent', '=', 'users.id')
                    ->where('users.idClasse', $requestData['idClasse']);
            }
            if ($date != null) {
                $feeUsers = $feeUsers
                    ->whereDate('fee_user.created_at', $requestData['date']);
            }
            if ($date_start != null && $date_end != null) {
                $date_start = Carbon::createFromFormat('Y-m-d', $requestData['date_start'])->format('Y-m-d 0:0:0');
                $date_end = Carbon::createFromFormat('Y-m-d', $requestData['date_end'])->format('Y-m-d 23:59:59');

                if ($idStudent != null){
                    $feeUsers = $feeUsers->where('fee_user.idStudent', $requestData['idStudent'])
                            ->whereBetween('fee_user.created_at', [
                                $date_start,
                                $date_end
                            ]);
                }else if($payment_mode != null){
                    $feeUsers = $feeUsers->where('fee_user.payment_mode', $requestData['payment_mode'])
                            ->whereBetween('fee_user.created_at', [
                                $date_start,
                                $date_end
                            ]);
                }else{
                    $feeUsers = $feeUsers->whereBetween('fee_user.created_at', [
                        $date_start,
                        $date_end
                    ]);
                }
            }

            if($payment_mode != null){
                $feeUsers = $feeUsers->where('fee_user.payment_mode', $requestData['payment_mode']);
            }

            else if($idStudent != null){
                $feeUsers = $feeUsers->where('fee_user.idStudent', $requestData['idStudent']);
            }

            $filter_value = $requestData['filter_value'] ?? null;
            if(!is_null($filter_value)){
                $feeUsers->where(function($query) use ($filter_value) {
                    $query->where('payment_mode', 'like', "%$filter_value%")
                        ->orWhere('created_at', 'like', "%$filter_value%")
                        ->orWhere('telephone', 'like', "%$filter_value%")
                        ->orWhere('reference', 'like', "%$filter_value%")
                        ->orWhereHas('fee', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            $feeUsers = $feeUsers->orderBy("fee_user.id", "desc")->get();

            // à la fin de tous les IF
            $totalAdvancePayment = $feeUsers->sum('advancePayment');
            $totalAdvancePaymentOM = $feeUsers->where('payment_mode','Orange Money')->sum('advancePayment');
            $totalAdvancePaymentMOMO = $feeUsers->whereIn('payment_mode', ['Mobile Money', 'MOMO'])->sum('advancePayment');
            $totalAdvancePaymentCash = $feeUsers->where('payment_mode','Cash')->sum('advancePayment');
            $totalAdvancePaymentBank = $feeUsers->where('payment_mode','Bank')->sum('advancePayment');
//            $totalAdvancePaymentMoMo = $feeUsers->where('payment_mode','MTN Money')->sum('advancePayment');

            $meta = [
                'current_page' => 0,
                'last_page' => 0,
                'to' => 0,
                'total' => 0,
            ];

            if(count($feeUsers) != 0){
                $pageItems = $requestData['pageItems'] ?? 1; // page de pagination
                $nbreItems = $requestData['nbreItems'] ?? 1000000; // nbre de résultats de la page

                $feeUsers = $feeUsers
                    ->toQuery()
                    ->orderBy("fee_user.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems);

                $meta = [
                    'current_page' => $feeUsers->currentPage(),
                    'last_page' => $feeUsers->lastPage(),
                    'to' => $feeUsers->lastItem(),
                    'total' => $feeUsers->total(),
                ];
            }

            $group_by = !empty($requestData['group_by']) ? $requestData['group_by'] : null;

            $date_start = !empty($requestData['date_start'])
                ? Carbon::createFromFormat('Y-m-d', $requestData['date_start'])->startOfDay()
                : null;

            $date_end = !empty($requestData['date_end'])
                ? Carbon::createFromFormat('Y-m-d', $requestData['date_end'])->endOfDay()
                : null;

            if (in_array($group_by, ['day', 'week', 'month'])) {
                // 1. Regrouper les données existantes
                $grouped = $feeUsers->groupBy(function ($item) use ($group_by) {
                    $date = $item->paymentDate ?? $item->created_at;
                    $date = $date instanceof Carbon ? $date : Carbon::parse($date);

                    if ($group_by === 'day') {
                        return $date->toDateString(); // Y-m-d
                    } elseif ($group_by === 'week') {
                        return $date->format('Y') . '-W' . $date->format('W');
                    } elseif ($group_by === 'month') {
                        return $date->format('Y-m');
                    }

                    return 'unknown';
                });

                // 2. Générer toutes les périodes
                $allPeriods = [];
                $current = $date_start->copy();

                while ($current->lte($date_end)) {
                    if ($group_by === 'day') {
                        $key = $current->toDateString();
                        $label = $key;
                        $current->addDay();
                    } elseif ($group_by === 'week') {
                        $key = $current->format('Y') . '-W' . $current->format('W');
                        $start = $current->copy()->startOfWeek();
                        $end = $current->copy()->endOfWeek();
                        $label = 'Du ' . $start->format('Y-m-d') . ' au ' . $end->format('Y-m-d');
                        $current->addWeek();
                    } elseif ($group_by === 'month') {
                        $key = $current->format('Y-m');
                        $start = $current->copy()->startOfMonth();
                        $end = $current->copy()->endOfMonth();
                        $label = 'Du ' . $start->format('Y-m-d') . ' au ' . $end->format('Y-m-d');
                        $current->addMonth();
                    }

                    $allPeriods[$key] = $label;
                }

                // 3. Fusionner avec les données groupées
                $feeUsers = collect();
                foreach ($allPeriods as $periodKey => $label) {
                    $items = isset($grouped[$periodKey]) ? $grouped[$periodKey] : collect();

                    $feeUsers->push([
                        'period' => $label,
                        'pensionUsers' => FeeUserResource::collection($items->values()),
                        'total_advancePayment' => $items->sum('advancePayment'),
                    ]);
                }
            }


            return [
                'data' => $group_by == null
                    ? FeeUserResource::collection($feeUsers)
                    : $feeUsers,
                'meta' => $meta,
                'sommes' => number_format($totalAdvancePayment),
                'om' => number_format($totalAdvancePaymentOM),
                'momo' => number_format($totalAdvancePaymentMOMO),
                'cash' => number_format($totalAdvancePaymentCash),
                'bank' => number_format($totalAdvancePaymentBank),
//                'momo' => number_format($totalAdvancePaymentMoMo),
            ];
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service getFeeUser '. $th->getMessage());
        }
    }


    protected function hasPaidRequiredFee($userId,  $classId, $feeId): bool
    {
        $fee = Fee::find($feeId);
        if ($fee){
            $requiredFees = Classes::find($classId)->level->fees()
                ->where('order', '<', (int) $fee->order)  // Convertir en entier pour être sûr
                ->where('required', true)
                ->get();
        }
        foreach ($requiredFees as $requiredFee){
            $feeId = $requiredFee->id;

            $isSolvable = $requiredFee->price == FeeUser::where('idStudent', $userId)
                    ->where('idFee', $feeId)
                    ->sum('advancePayment');

            if (! $isSolvable){
                return false;
            }
        }

        return true;
    }

    public function storeFeeUser(array $requestData)
    {
        try {
            $feeUser = $requestData;
            $montant_total = number_format($requestData['advancePayment']);

            $studentFee = FeeUser::where('idStudent', $requestData['idStudent'])
                ->where('idFee', $requestData['idFee'])
                ->latest('created_at')->first();

            $student = User::findOrFail($requestData['idStudent']);

            //On verifi si l'utilisateur a payer tous les frais necessaires avant de continuer
            if (!$this->hasPaidRequiredFee($student->id, $student->idClasse, $requestData['idFee'])){
                return __('pension_user.unpaid_fees');
            }


            ### surcharge ... On récupère les infos qui se trouvent sur le student
            $requestData['idSchool'] = $student['idSchool'];
            $requestData['idSection'] = $student['idSection'];
            $requestData['idLevel'] = $student['idLevel'];
            //dd($requestData);

            $fee = Fee::select('fees.id as id', 'fees.name as name', 'fees.price as price', 'fees.deadline as deadline')
                ->where('fees.id', $requestData['idFee'])
                ->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
                ->join('levels', 'levels.id', '=', 'fee_has_level.level_id')
                ->where('fee_has_level.level_id', $requestData['idLevel'])
                ->where('fees.idSchool', $requestData['idSchool'])
                ->where('fees.idSection', $requestData['idSection'])
                ->firstOrFail();

            $concernedStudent = User::find($requestData['idStudent']); // on va prendre son idSchool & idSection pour mettre sur la table FeeUser

            switch ($requestData['advancePayment']) {
                case null:
                    return response()->json(['message' => 'Le montant d\'avance ne peut être null'], 500);
                    break;

                case 0:
                    return response()->json(['message' => 'Le montant ne peut pas être 0'], 500);
                    break;

                default:
                    $student = User::find($requestData['idStudent']); // TODO: Pour envoyer une notification à l'étudiant et son parent

                    switch ($studentFee) {
                        case null:
                            $tabUser = array();
                            if($requestData['advancePayment'] < 0){
                                return response()->json(['message' => 'Le montant ne peut pas être négatif'], 500);
                            }
                            else if ($requestData['advancePayment'] > $fee->price) {
                                return response()->json(['message' => 'Le montant dépasse les frais'], 500);
                            }
                            else{
                                $feeUser = new FeeUser();

//                                if(!is_null($requestData['photo'])){
//                                    $file = $requestData['photo'];
//                                    $uploadPath = "public/feeUsers";
//                                    $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                                    $file->move($uploadPath,$originalImage);
//
//                                    $feeUser->photo = $originalImage;
//                                }

                                $feeUser->idTransaction = $requestData['idTransaction'] ?? null;
                                $feeUser->idStudent = $requestData['idStudent'];
                                $feeUser->idFee = $fee->id;
                                $feeUser->receiptNumber = $requestData['receiptNumber'] ?? null;
                                $feeUser->scanReceipt = $requestData['scanReceipt'] ?? null;
                                $feeUser->operator = $requestData['operator'] ?? null;
                                $feeUser->paymentDate = $requestData['paymentDate'] ?? null;
                                $feeUser->idSchool = $concernedStudent->idSchool;
                                $feeUser->idSection = $concernedStudent->idSection;
                                $feeUser->telephone = $requestData["telephone"]?? null;
                                $feeUser->reference = $requestData["reference"]?? null;

                                if($requestData['advancePayment'] < $fee->price){
                                    $feeUser->advancePayment = $requestData['advancePayment'];
                                    $feeUser->balancePayment = $fee->price - $requestData['advancePayment'];
                                    $feeUser->payment_mode = $requestData['payment_mode'] ;
                                    $feeUser->solvable = "avancé" ;
                                }
                                else if($requestData['advancePayment'] > $fee->price){
                                    $feeUser->advancePayment = $fee->price;
                                    $feeUser->balancePayment = 0;
                                    $feeUser->payment_mode = $requestData['payment_mode'] ;
                                    $feeUser->solvable = "terminé" ;
                                    $compteur = $requestData['advancePayment'] - $fee->price;
                                    $request['advancePayment'] = $compteur;
                                }
                                else{
                                    $feeUser->advancePayment = $fee->price;
                                    $feeUser->balancePayment = 0;
                                    $feeUser->payment_mode = $requestData['payment_mode'] ;
                                    $feeUser->solvable = "terminé" ;
                                    $compteur = $requestData['advancePayment'] - $fee->price;
                                }

                                $feeUser->created_by = auth()->user()->id;
                                $feeUser->save();

                                $feeUser->remainingFees = $fee->price; //By Ibrah (add)


                                $tabUser["FeePaye"] = new FeeUserResource($feeUser);

                                Notification::create([
                                    'notificationable_type' => FeeUser::class,
                                    'notificationable_id' => end($tabUser)['id'],
                                    'title' => __('notifs.feeuser_title', ['montant_total' => $montant_total, 'frais' => $fee->name]) ,//"{$montant_total} XAF de frais de {$fee[0]['name']} versés",
                                    'description' => __('notifs.feeuser_desc', ['montant_total' => $montant_total, 'frais' => $fee->name, 'student_name' => $student->name]),
                                    'grouped_users' => json_encode([$requestData['idStudent'], $student->idParent])
                                ]);

                                return FeeUserResource::collection($tabUser);
                            }

                            break;

                        default:
                            $tabPen = array();

                            $fee = Fee::find($studentFee['idFee']);


                            switch ($studentFee['balancePayment']) {
                                case 0:
                                    return response()->json(['message' => 'La totalite des frais a déjà été payée'], 500);
                                    break;
                                default:
                                    if ($requestData['advancePayment'] < 0) {
                                        return response()->json(['message' => 'Le montant ne peut pas être négatif'], 500);
                                    }
                                    else{
                                        $feeUser = new FeeUser();

//                                        if(!is_null($requestData['photo'])){
//                                            $file = $requestData['photo'];
//                                            $uploadPath = "public/feeUsers";
//                                            $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                                            $file->move($uploadPath,$originalImage);
//
//                                            $feeUser->photo = $originalImage;
//                                        }

                                        $feeUser->idTransaction = $requestData['idTransaction'] ?? null;
                                        $feeUser->idStudent = $requestData['idStudent'];
                                        $feeUser->idFee = $fee->id;
                                        $feeUser->scanReceipt = $requestData['scanReceipt'] ?? null;
                                        $feeUser->receiptNumber = $requestData['receiptNumber'] ?? null;
                                        $feeUser->operator = $requestData['operator'] ?? null;
                                        $feeUser->paymentDate = $requestData['paymentDate'] ?? null;
                                        $feeUser->idSchool = $concernedStudent->idSchool;
                                        $feeUser->idSection = $concernedStudent->idSection;
                                        $feeUser->telephone = $requestData["telephone"]?? null;
                                        $feeUser->reference = $requestData["reference"]?? null;



                                        if($requestData['advancePayment'] > $studentFee['balancePayment']){
                                            return response()->json(['message' => 'Le montant depasse les frais restants'], 500);
                                        }
                                        else if($requestData['advancePayment'] < $studentFee['balancePayment']){
                                            $feeUser->advancePayment = $requestData['advancePayment'];
                                            $feeUser->balancePayment = $studentFee['balancePayment'] - $requestData['advancePayment'];
                                            $feeUser->payment_mode = $requestData['payment_mode'] ;
                                            $feeUser->solvable = "avancé" ;
                                            $feeUser->created_by = auth()->user()->id;
                                            $feeUser->save();

                                            $feeUser->remainingFees = $studentFee['balancePayment']; //By Ibrah (add)

                                            $tabPen["FeePaye"] = new FeeUserResource($feeUser);
                                        }
                                        else{
                                            $feeUser->advancePayment = $requestData['advancePayment'];
                                            $feeUser->balancePayment = 0;
                                            $feeUser->payment_mode = $requestData['payment_mode'] ;
                                            $feeUser->solvable = "terminé" ;
                                            $feeUser->created_by = auth()->user()->id;
                                            $feeUser->save();

                                            $feeUser->remainingFees = $studentFee['balancePayment']; //By Ibrah (add)

                                            $tabPen["FeePaye"] = new FeeUserResource($feeUser);
                                            $compteur = $requestData['advancePayment'] - $fee->price;
                                            break;
                                        }
                                    }
                                    break;
                            }

                            Notification::create([
                                'notificationable_type' => FeeUser::class,
                                'notificationable_id' => end($tabPen)['id'],
                                'title' => __('notifs.feeuser_title', ['montant_total' => $montant_total, 'frais' => $fee->name]),
                                'description' => __('notifs.feeuser_desc', ['montant_total' => $montant_total, 'frais' => $fee->name, 'student_name' => $student->name]),
                                'grouped_users' => json_encode([$requestData['idStudent'], $student->idParent])
                            ]);
                            return FeeUserResource::collection($tabPen);
                            break;
                    }

                    break;
            }

        } catch (\Throwable $th) {
            throw new ServiceException('Error Service StoreFeeUser '. $th->getMessage());
        }
    }

    public function calculateBalanceFeeUser($requestData)
    {
        try {
            $student = User::find($requestData['idStudent']);

            $fee = Fee::select('fees.id as id', 'fees.name as name', 'fees.price as price')
                ->join('fee_has_level', 'fee_has_level.fee_id', '=', 'fees.id')
                ->join('levels', 'levels.id', '=', 'fee_has_level.level_id')
                ->where('fee_has_level.level_id', $student->idLevel)
                ->where('fees.idSchool', $student->idSchool)
                ->where('fees.idSection', $student->idSection)
                ->where('fees.id', $requestData['idFee'])
                ->get();

            $sumstudentFeeUser = FeeUser::where('idStudent', $requestData['idStudent'])
                ->where('idFee', $requestData['idFee'])
                ->sum('advancePayment');
            $montantRestant = $fee[0]['price'] - $sumstudentFeeUser;

            return ['montantRestant' => $montantRestant];
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service BalanceFeeUser '. $th->getMessage());
        }
    }

    public function showFeeUser($id)
    {
        try {
            $feeUser = FeeUser::find($id);
            return new FeeUserResource($feeUser);
        } catch (\Throwable $th) {
            throw new ServiceException('Error Service showFeeUser '. $th->getMessage());
        }
    }

    public static function deleteFeeUser($id)
    {
        try {
            DB::beginTransaction();
            $feeUser = FeeUser::findOrFail($id);

            $feeUser->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id,
            ]);

            //Sauvegarder dans la table des archives
            FeeUserArchive::create($feeUser->toArray());

            $feeUser->delete();

            DB::commit();
            return response(null, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServiceException('Error Service deleteFeeUser '. $th->getMessage());
        }
    }

    public function archiveOrRestore(array $request)
    {
        try {
            $action = $request['action'];
            $idPensionUser = $request['idFeeUser'];
            $reason = $request['reason'] ?? null;

            if($action == 'restore'){
                $feeUser = FeeUser::withoutGlobalScope('isDeleted')->findOrFail($idPensionUser);
            }
            else if($action == 'archive'){
                $feeUser = FeeUser::findOrFail($idPensionUser);
            }

            $feeUser->update([
                'deleted' => ($action == 'restore') ? false : true,
                'reason' => $reason,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json("FeeUser $action avec succès.", 200);
        } catch (\Throwable $th) {
            throw new ServiceException( "Error Service $action FeeUser --- ". $th->getMessage());
        }
    }

    public function solvablesOuInsolvables(array $request)
    {
        try {
            $type = $request['type'];
            $idSchool = $request['idSchool'];
            $idSection = $request['idSection'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idStudent = $request['idStudent'] ?? null;
            $idFee = $request['idFee'] ?? null;

            $fee = Fee::find($idFee);

            $users = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
                ->join('classes', 'classes.id', "=", "users.idClasse")
//                    ->join('option_level','option_level.id','=','users.idOptionLevel')
                ->where([
                    'roles.id' => 8,
                    'users.deleted' => 0,
                    'users.idSchool' => $idSchool,
                ])
                ->when($idSection !== null, function ($query) use ($idSection) {
                    $query->where('users.idSection', $idSection);
                })
                ->when($idClasse !== null, function ($query) use ($idClasse) {
                    $query
                        ->where('users.idClasse', $idClasse);
                })
                ->when($idLevel !== null, function ($query) use ($idLevel) {
                    $query
                        ->join('levels', 'levels.id', "=", "classes.idLevel")
                        ->where('levels.id', $idLevel);
                })
                ->orderBy('users.name')
                ->select('users.*')
                ->get();

            $results = array();

            $totalToPay = $fee->price;
            $totalDejaPayeFrais = 0;
            $montantRestantFrais = 0;

            foreach ($users as $user) {
                $alreadyPaid = FeeUser::where('idStudent', $user->id)
                    ->where('idFee', $idFee)
                    ->sum('advancePayment');

                // Si on veut les solvables, alors la condition sera que le student ait tout payé, sinon le contraire (cad il lui doit encore verser de l'argent)
                $condition = (($type == "solvables"))
                    ? ($totalToPay == $alreadyPaid)
                    : ($totalToPay != $alreadyPaid);

                if(($type == "solvables") && ($totalToPay == $alreadyPaid)){
                    $results[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'matricule' => $user->matricule,
                        'classe' => ClassesSimpResource::make($user->classe),
                        'totalDejaPaye' => $alreadyPaid,
                        'resteAPayer' => $totalToPay- $alreadyPaid
                    ];
                }else if(!($type == "solvables") && ($totalToPay != $alreadyPaid) ){
                    $results[] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'matricule' => $user->matricule,
                        'classe' => ClassesSimpResource::make($user->classe),
                        'totalDejaPaye' => $alreadyPaid,
                        'resteAPayer' => $totalToPay- $alreadyPaid
                    ];
                }

                $totalDejaPayeFrais += $alreadyPaid;
                $montantRestantFrais += ($totalToPay- $alreadyPaid);

            }

            return [
                'data' => $results,
                'totalAPayer' => $fee->price * count($users),
                'totalDejaPaye' => $totalDejaPayeFrais,
                'montantRestantTranche' => $montantRestantFrais
            ];
        } catch (\Throwable $th) {
            throw new ServiceException( "Error Service FeeUser-$type --- ". $th->getMessage());
        }
    }
}
