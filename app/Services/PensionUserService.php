<?php

namespace App\Services;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\Staffs\FeeUserResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Models\Bourse;
use App\Models\Classes;
use App\Models\FeeUser;
use App\Models\Level;
use App\Models\Moratorium;
use App\Models\Notification;
use App\Models\Pension;
use App\Models\PensionUser;
use App\Models\PensionUserArchive;
use App\Models\Sanction;
use App\Models\Tranche;
use App\Models\User;
use App\Http\Resources\Staffs\PensionUserResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Staffs\InscriptionResource;
use App\Exceptions\ServiceException;
use App\Traits\ErrorHandlingTrait;

class PensionUserService
{
    use ErrorHandlingTrait;
    public function getPensionUsers(array $requestData, $archives = false)
    {
        try {
            $idSchool = $requestData['idSchool'] ?? null;
            $idSection = $requestData['idSection'] ?? null;
            $idPension = $requestData['idPension'] ?? null;
            $idTranche = $requestData['idTranche'] ?? null;
            $idStudent = $requestData['idStudent'] ?? null;
            $idClasse = $requestData['idClasse'] ?? null;
            $date = $requestData['date'] ?? null;
            $date_start = $requestData['date_start'] ?? null;
            $date_end = $requestData['date_end'] ?? null;
            $payment_mode = $requestData['payment_mode'] ?? null;
            $telephone = $requestData['telephone'] ?? null;
            $reference = $requestData['reference'] ?? null;
            $operator = $requestData['operator'] ?? null;


            //   $pensionUsers = PensionUser::where('pension_users.idSchool', $idSchool);
            $pensionUsers = PensionUser::query();
            if($archives){
                $pensionUsers
                    ->withoutGlobalScope('isDeleted')
                    ->where('pension_users.deleted', 1);
            }
            if(!is_null($idSchool)) $pensionUsers = $pensionUsers->where('pension_users.idSchool', $idSchool);
            if(!is_null($idSection)) $pensionUsers = $pensionUsers->where('pension_users.idSection', $idSection);
            if(!is_null($idTranche)) $pensionUsers = $pensionUsers->where('pension_users.idTranche', $idTranche);
            if(!is_null($telephone)) $pensionUsers = $pensionUsers->where('pension_users.telephone', $telephone);
            if(!is_null($reference)) $pensionUsers = $pensionUsers->where('pension_users.reference', $reference);
            if (!is_null($operator)) {
                $pensionUsers = $pensionUsers->where('pension_users.operator', 'LIKE', '%' . $operator . '%');
            }

            if ($idClasse != null && $idTranche != null) {
                $pensionUsers = $pensionUsers->select('pension_users.id as id', 'pension_users.advancePayment as advancePayment', 'pension_users.balancePayment as balancePayment', 'pension_users.payment_mode as payment_mode', 'pension_users.solvable as solvable', 'pension_users.idTranche as idTranche', 'pension_users.idPension as idPension', 'pension_users.idStudent as idStudent', 'pension_users.idSchool as idSchool', 'pension_users.idSection as idSection', 'pension_users.created_at as created_at')
                    ->join('users', 'pension_users.idStudent', '=', 'users.id')
                    ->where('users.idClasse', $requestData['idClasse'])
                    ->where('pension_users.idTranche', $requestData['idTranche']);
            }
            else if ($idClasse != null && $date != null) {
                $pensionUsers = $pensionUsers->select('pension_users.id as id', 'pension_users.advancePayment as advancePayment', 'pension_users.balancePayment as balancePayment', 'pension_users.payment_mode as payment_mode', 'pension_users.solvable as solvable', 'pension_users.idTranche as idTranche', 'pension_users.idPension as idPension', 'pension_users.idStudent as idStudent', 'pension_users.idSchool as idSchool', 'pension_users.idSection as idSection', 'pension_users.created_at as created_at')
                    ->join('users', 'pension_users.idStudent', '=', 'users.id')
                    ->where('users.idClasse', $requestData['idClasse'])
                    ->whereDate('pension_users.created_at', $requestData['date']);
            }
            else if ($idClasse != null && $date_start != null && $date_end != null) {
                $date_start = Carbon::createFromFormat('Y-m-d', $requestData['date_start'])->format('Y-m-d 0:0:0');
                $date_end = Carbon::createFromFormat('Y-m-d', $requestData['date_end'])->format('Y-m-d 23:59:59');
                
                $pensionUsers = $pensionUsers->select('pension_users.id as id', 'pension_users.advancePayment as advancePayment', 'pension_users.balancePayment as balancePayment', 'pension_users.payment_mode as payment_mode', 'pension_users.solvable as solvable', 'pension_users.idTranche as idTranche', 'pension_users.idPension as idPension', 'pension_users.idStudent as idStudent', 'pension_users.idSchool as idSchool', 'pension_users.idSection as idSection', 'pension_users.created_at as created_at')
                    ->join('users', 'pension_users.idStudent', '=', 'users.id')
                    ->where('users.idClasse', $requestData['idClasse'])
                    ->whereRaw('DATE(pension_users.created_at) BETWEEN ? AND ?', [ $date_start, $date_end ]);
            }
            else if ($idClasse != null) {
                $pensionUsers = $pensionUsers->select('pension_users.id as id', 'pension_users.advancePayment as advancePayment', 'pension_users.balancePayment as balancePayment', 'pension_users.payment_mode as payment_mode', 'pension_users.solvable as solvable', 'pension_users.idTranche as idTranche', 'pension_users.idPension as idPension', 'pension_users.idStudent as idStudent', 'pension_users.idSchool as idSchool', 'pension_users.idSection as idSection', 'pension_users.created_at as created_at')
                    ->join('users', 'pension_users.idStudent', '=', 'users.id')
                    ->where('users.idClasse', $requestData['idClasse']);
            }
            else if($date != null){
                $pensionUsers = $pensionUsers->whereDate('created_at', $requestData['date']);
            }
            else if($date_start != null && $date_end != null){
                $date_start = Carbon::createFromFormat('Y-m-d', $requestData['date_start'])->format('Y-m-d 0:0:0');
                $date_end = Carbon::createFromFormat('Y-m-d', $requestData['date_end'])->format('Y-m-d 23:59:59');

                if($idStudent != null){
                    $pensionUsers = $pensionUsers->where('idStudent', $requestData['idStudent'])
                        ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [ $date_start, $date_end ]);
                }else if($payment_mode != null){
                    $pensionUsers = $pensionUsers->where('payment_mode',$requestData['payment_mode'])
                        ->whereRaw('DATE(created_at) BETWEEN ? AND ?', [ $date_start, $date_end ]);
                }else{
                    $pensionUsers = $pensionUsers->whereRaw('DATE(created_at) BETWEEN ? AND ?', [ $date_start, $date_end ]);
                }
            }
            else if($payment_mode != null){
                $pensionUsers = $pensionUsers->where('payment_mode',$requestData['payment_mode']);
            }
            else if($idStudent != null){
                $pensionUsers = $pensionUsers->where('idStudent', $requestData['idStudent']);
            }

            $filter_value = $requestData['filter_value'] ?? null;
            if(!is_null($filter_value)){
                $pensionUsers = $pensionUsers->where(function($query) use ($filter_value) {
                    $query->where('payment_mode', 'like', "%$filter_value%")
                        ->orWhere('telephone', 'like', "%$filter_value%")
                        ->orWhere('reference', 'like', "%$filter_value%")
                        ->orWhere('created_at', 'like', "%$filter_value%")
                        ->orWhereHas('tranche', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            $meta = [
                'current_page' => 0,
                'last_page' => 0,
                'to' => 0,
                'total' => 0,
            ];

            $pensionUsers = $pensionUsers
                ->orderBy("pension_users.id", "desc")
                ->get();

            $totalAdvancePayment = $pensionUsers->sum('advancePayment');
            $totalAdvancePaymentOM = $pensionUsers->where('payment_mode','Orange Money')->sum('advancePayment');
            $totalAdvancePaymentMOMO = $pensionUsers->whereIn('payment_mode', ['Mobile Money', 'MOMO'])->sum('advancePayment');
            $totalAdvancePaymentCash = $pensionUsers->where('payment_mode','Cash')->sum('advancePayment');
            $totalAdvancePaymentBank = $pensionUsers->where('payment_mode','Bank')->sum('advancePayment');
//            $totalAdvancePaymentMoMo = $pensionUsers->where('payment_mode','MTN Money')->sum('advancePayment');


            if(count($pensionUsers) != 0){
                $pageItems = $requestData['pageItems'] ?? 1; // page de pagination
                $nbreItems = $requestData['nbreItems'] ?? 1000000; // nbre de résultats de la page

                $pensionUsers = $pensionUsers
                    ->toQuery()
                    ->orderBy("pension_users.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems);

                $meta = [
                    'current_page' => $pensionUsers->currentPage(),
                    'last_page' => $pensionUsers->lastPage(),
                    'to' => $pensionUsers->lastItem(),
                    'total' => $pensionUsers->total(),
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
                // 1. Groupement réel
                $grouped = $pensionUsers->groupBy(function ($item) use ($group_by) {
                    $date = $item->paymentDate ?? $item->created_at;
                    $date = $date instanceof Carbon ? $date : Carbon::parse($date);

                    if ($group_by === 'day') {
                        return $date->toDateString(); // "Y-m-d"
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

                // 3. Compléter les données manquantes
                $pensionUsers = collect();

                foreach ($allPeriods as $periodKey => $label) {
                    $items = isset($grouped[$periodKey]) ? $grouped[$periodKey] : collect();

                    $pensionUsers->push([
                        'period' => $label,
                        'pensionUsers' => PensionUserResource::collection($items->values()),
                        'total_advancePayment' => $items->sum('advancePayment'),
                    ]);
                }
            }

            return [
                'data' => $group_by == null
                    ? PensionUserResource::collection($pensionUsers)
                    : $pensionUsers,
                'meta' => $meta,
                'sommes' => number_format($totalAdvancePayment),
                'om' => number_format($totalAdvancePaymentOM),
                'momo' => number_format($totalAdvancePaymentMOMO),
                'cash' => number_format($totalAdvancePaymentCash),
                'bank' => number_format($totalAdvancePaymentBank),
//                'momo' => number_format($totalAdvancePaymentMoMo),
            ];
        } catch (\Throwable $th) {
            throw new ServiceException('Error getPensionUser'. $th->getMessage());
        }
    }

    protected function hasPaidRequiredFee($userId,  $classId): bool
    {
        $requiredFees =   Classes::find($classId)->level->fees()
            ->where('required', true)->get();

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

    public function storePensionUser(array $requestData)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | 1. PRÉPARATION DES DONNÉES DE BASE
            |--------------------------------------------------------------------------
            */

            // Montant avancé formaté uniquement pour les notifications (AFFICHAGE)
            $formattedAdvanceAmount = number_format($requestData['advancePayment']);

            // Données de travail (sera modifié durant le traitement)
            $pensionUserData = $requestData;

            // Étudiant concerné (source de vérité pour école, section, classe)
            $student = User::findOrFail($pensionUserData['idStudent']);

            /*
            |--------------------------------------------------------------------------
            | 2. VÉRIFICATION MÉTIER BLOQUANTE
            |--------------------------------------------------------------------------
            */

            // Un étudiant ne peut payer une pension que s’il a réglé les frais obligatoires
            if (!$this->hasPaidRequiredFee($student->id, $student->idClasse)) {
                return __('pension_user.unpaid_fees');
            }

            /*
            |--------------------------------------------------------------------------
            | 3. RÉSOLUTION DE LA PENSION À PARTIR DE LA CLASSE
            |--------------------------------------------------------------------------
            */

            // On rattache explicitement l’école et la section de l’étudiant
            $pensionUserData['idSchool']  = $student->idSchool;
            $pensionUserData['idSection'] = $student->idSection;

            // Le niveau est déterminé par la classe
            $levelId = Classes::find($student->idClasse)->idLevel;

            // Chaque niveau correspond à une pension unique
            $pensionUserData['idPension'] = Pension::where('idLevel', $levelId)
                ->firstOrFail()
                ->id;

            /*
            |--------------------------------------------------------------------------
            | 4. CONTEXTE DE PAIEMENT
            |--------------------------------------------------------------------------
            */

            // Dernier paiement effectué pour cette pension (permet de savoir s’il y a un historique)
            $lastPensionPayment = PensionUser::where('idStudent', $student->id)
                ->where('idPension', $pensionUserData['idPension'])
                ->latest('created_at')
                ->first();

            // Tranches de la pension (ordre chronologique)
            $tranches = Tranche::where('idPension', $pensionUserData['idPension'])
                ->where('idSchool',  $student->idSchool)
                ->where('idSection', $student->idSection)
                ->orderBy('name')
                ->get(['id', 'price']);

            // Montant TOTAL de la pension (somme de toutes les tranches)
            $totalPensionAmount = $tranches->sum('price');

            /*
            |--------------------------------------------------------------------------
            | 5. VARIABLES DE CONTRÔLE
            |--------------------------------------------------------------------------
            */

            // Solde disponible à répartir (argent réellement payé uniquement)
            $remainingCash = $pensionUserData['advancePayment'];

            // Tableau de retour API
            $createdPayments = [];

            /*
            |--------------------------------------------------------------------------
            | 6. CAS 1 — PREMIER PAIEMENT (AUCUN HISTORIQUE)
            |--------------------------------------------------------------------------
            */
            $scholarshipAmount = 0;
            $BourseId = null ;

            if (isset($requestData['idBourse']) && !$student->isBourseUsed) {
                $scholarship = Bourse::find($requestData['idBourse']);
                $scholarshipAmount = $scholarship->amount;
                $BourseId = $scholarship->id;
                $student->isBourseUsed = true;
                $student->save();
            }

            // Capacité réelle de paiement sur cette tranche
            $availableToPay = $remainingCash + $scholarshipAmount;

            if ($lastPensionPayment === null) {

                // Sécurité : on ne peut pas avancer plus que la pension totale
                if ($remainingCash > $totalPensionAmount) {
                    return $this->sendError('Le montant dépasse la pension totale');
                }

                foreach ($tranches as $index => $tranche) {

                    /*
                    |--------------------------------------------------------------------------
                    | 6.1 GESTION DE LA BOURSE (NON COMPTABLE)
                    |--------------------------------------------------------------------------
                    |
                    | La bourse :
                    | - n’est PAS enregistrée comme advancePayment
                    | - sert UNIQUEMENT à réduire le reste à payer
                    | - ne doit être utilisée qu’une seule fois
                    */



                    // Si plus rien à appliquer, on stoppe
                    if ($availableToPay <= 0) {
                        break;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | 6.2 CRÉATION DU PAIEMENT DE TRANCHE
                    |--------------------------------------------------------------------------
                    */

                    $payment = new PensionUser();
                    $payment->fill([
                        'idStudent'    => $student->id,
                        'idPension'    => $pensionUserData['idPension'],
                        'idTranche'    => $tranche->id,
                        'idSchool'     => $student->idSchool,
                        'idSection'    => $student->idSection,
                        'idBourse'     => $BourseId,
                        'payment_mode' => $pensionUserData['payment_mode'],
                        'created_by'   => Auth::id(),
                        'telephone'    => $requestData['telephone'] ?? null,
                        'reference'    => $requestData['reference'] ?? null,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | 6.3 RÉPARTITION DU PAIEMENT SUR LA TRANCHE
                    |--------------------------------------------------------------------------
                    */

                    if ($availableToPay < $tranche->price) {

                        // Paiement partiel
                        $payment->advancePayment = $remainingCash;
                        $payment->balancePayment = $tranche->price - $availableToPay;
                        $payment->solvable = 'avancé';
                        $availableToPay = 0 ;
                        $remainingCash = 0;

                    } else {

                        // Paiement total de la tranche
                        $payment->advancePayment = min($remainingCash, $tranche->price);
                        $payment->balancePayment = 0;
                        $payment->solvable = 'terminé';

                        if ($remainingCash < $tranche->price) {
                            $remainingCash = 0;
                        } else {
                            $remainingCash = $remainingCash - $tranche->price;
                        }

                        $availableToPay = $availableToPay - $tranche->price;
                    }

                    $payment->save();
                    $createdPayments[] = new PensionUserResource($payment);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 7. CAS 2 — PAIEMENT AVEC HISTORIQUE EXISTANT
            |--------------------------------------------------------------------------
            |
            | Principe :
            | - On complète les tranches non soldées
            | - On ne recrée jamais une tranche déjà terminée
            */

            else {

                foreach ($tranches as $index => $tranche) {

                    if ($availableToPay <= 0) {
                        break;
                    }


                    // Dernier état de paiement pour cette tranche
                    $existingPayment = PensionUser::where('idStudent', $student->id)
                        ->where('idPension', $pensionUserData['idPension'])
                        ->where('idTranche', $tranche->id)
                        ->latest('created_at')
                        ->first();

                    // Si la tranche est déjà totalement soldée, on saute
                    if ($existingPayment && $existingPayment->balancePayment == 0) {
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Complément de paiement
                    |--------------------------------------------------------------------------
                    */

                    $balanceToPay = $existingPayment
                        ? $existingPayment->balancePayment
                        : $tranche->price;

                    $payment = new PensionUser();
                    $payment->fill([
                        'idStudent'    => $student->id,
                        'idPension'    => $pensionUserData['idPension'],
                        'idTranche'    => $tranche->id,
                        'idBourse'     => $BourseId,
                        'idSchool'     => $student->idSchool,
                        'idSection'    => $student->idSection,
                        'payment_mode' => $pensionUserData['payment_mode'],
                        'created_by'   => Auth::id(),
                    ]);

                    if ($availableToPay < $balanceToPay) {

                        $payment->advancePayment = $remainingCash;
                        $payment->balancePayment = $balanceToPay - $availableToPay;
                        $payment->solvable = 'avancé';
                        $remainingCash = 0;
                        $availableToPay = 0;

                    } else {

                        $payment->advancePayment = min($remainingCash, $balanceToPay);
                        $payment->balancePayment = 0;
                        $payment->solvable = 'terminé';
                        if ($remainingCash < $balanceToPay) {
                            $remainingCash = 0;
                        } else {
                            $remainingCash = $remainingCash - $balanceToPay;
                        }
                        $availableToPay = $availableToPay - $balanceToPay;
                    }

                    $payment->save();
                    $createdPayments[] = new PensionUserResource($payment);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 8. NOTIFICATION
            |--------------------------------------------------------------------------
            */

            Notification::create([
                'notificationable_type' => PensionUser::class,
                'notificationable_id'   => end($createdPayments)['id'] ?? null,
                'title'       => __('notifs.pensionuser_title', ['montant_total' => $formattedAdvanceAmount]),
                'description' => __('notifs.pensionuser_desc', [
                    'montant_total' => $formattedAdvanceAmount,
                    'student_name'  => $student->name
                ]),
                'grouped_users' => json_encode([$student->id, $student->idParent])
            ]);

            return PensionUserResource::collection($createdPayments);

        } catch (\Throwable $e) {
            throw new ServiceException('Erreur storePensionUser : ' . $e->getMessage());
        }
    }

    /*
    public function storePensionUser(array $requestData)
    {
        try {
            //return $requestData;
            $studentPension = PensionUser::where('idStudent', $requestData['idStudent'])
                ->where('idPension', $requestData['idPension'])
                ->latest('created_at')->first();

            $tranches = Tranche::select('id', 'name', 'price', 'deadline')
                ->where('idPension', $requestData['idPension'])
                ->where('idSchool', $requestData['idSchool'])
                ->where('idSection', $requestData['idSection'])
                ->get();

            $totalTranchePrice = $tranches->sum('price');
            $advancePayment = $requestData['advancePayment'];

            if ($studentPension === null) {
                // Nouvelle inscription de pension
                if ($advancePayment > $totalTranchePrice) {
                    return $this->sendError('Le montant dépasse la pension');
                }

                $pensionUsers = [];
                foreach ($tranches as $tranche) {
                    $paymentAmount = min($tranche->price, $advancePayment);

                    $pensionUser = new PensionUser();
                    $pensionUser->fill([
                        'idStudent' => $requestData['idStudent'],
                        'idPension' => $requestData['idPension'],
                        'idTranche' => $tranche->id,
                        'idSchool' => $requestData['idSchool'],
                        'idSection' => $requestData['idSection'],
                        'advancePayment' => $paymentAmount,
                        'balancePayment' => $tranche->price - $paymentAmount,
                        'payment_mode' => $requestData['payment_mode'],
                        'solvable' => $paymentAmount < $tranche->price ? 'avancé' : 'terminé',
                        'created_by' => Auth::id(),
                    ]);
                    $pensionUser->save();

                    $pensionUsers[] = new PensionUserResource($pensionUser);

                    $advancePayment -= $paymentAmount;
                    if ($advancePayment <= 0) {
                        break;
                    }
                }

                return PensionUserResource::collection($pensionUsers);
            } else {
                // Mise à jour d'une inscription existante
                $remainingPayment = $totalTranchePrice - $studentPension->sum('advancePayment');

                if ($advancePayment > $remainingPayment) {
                    return $this->sendError('Le montant dépasse le reste de la pension');
                }

                $pensionUsers = [];
                foreach ($tranches as $tranche) {
                    $paymentAmount = min($tranche->price, $advancePayment);

                    $pensionUser = new PensionUser();
                    $pensionUser->fill([
                        'idStudent' => $requestData['idStudent'],
                        'idPension' => $requestData['idPension'],
                        'idTranche' => $tranche->id,
                        'idSchool' => $requestData['idSchool'],
                        'idSection' => $requestData['idSection'],
                        'advancePayment' => $paymentAmount,
                        'balancePayment' => $tranche->price - $paymentAmount,
                        'payment_mode' => $requestData['payment_mode'],
                        'solvable' => $paymentAmount < $tranche->price ? 'avancé' : 'terminé',
                        'created_by' => Auth::id(),
                    ]);
                    $pensionUser->save();

                    $pensionUsers[] = new PensionUserResource($pensionUser);

                    $advancePayment -= $paymentAmount;
                    if ($advancePayment <= 0) {
                        break;
                    }
                }

                return PensionUserResource::collection($pensionUsers);
            }
        } catch (\Throwable $th) {
            throw new ServiceException('Error store PensionUser'. $th->getMessage());
        }
    }
    */

    public function balancePensionUser($requestData)
    {
        try {
            /*
             * TODO: On récupère la bonne pension en se servant de idLevel sur le student
             */

            $student = User::find($requestData['idStudent']);

            $requestData['idPension'] = Pension::select('pensions.id')
                ->join('users', 'users.idLevel', '=', 'pensions.idLevel')
                ->where('users.id', $requestData['idStudent'])
                ->firstOrFail()
                ->id;

            $sumtranche = Tranche::select('id','name','price')
                ->where('idPension', $requestData['idPension'])
                ->where('idSchool', $student['idSchool'])
                ->where('idSection', $student['idSection'])
                ->sum('price');

            $sumstudentPensionUser = PensionUser::where('idStudent', $requestData['idStudent'])
                ->where('idPension', $requestData['idPension'])
                ->sum('advancePayment');
            $montantRestant = $sumtranche - $sumstudentPensionUser;

            return json_encode([
                'message' => $montantRestant,
                'total' => $sumtranche,
                'alreadyPaid' => $sumstudentPensionUser
            ]);
        } catch (\Throwable $th) {
            throw new ServiceException('Error balance users'. $th->getMessage());
        }
    }

    public function balancePensionWithBourse($requestData)
    {
        try {
            $student = User::find($requestData['idStudent']);

//            $classe = Classes::find($student->idClasse);
//
//            $level = Level::find($classe->idLevel);

//            $requestData['idPension'] = Pension::where('idLevel', $level->id)->firstOrFail()->id;
            $requestData['idPension'] = Pension::select('pensions.id as id')
                ->join('levels', 'levels.id', '=', 'pensions.idLevel')
                ->join('classes', 'classes.idLevel', '=', 'levels.id')
                ->join('users', 'users.idClasse', '=', 'classes.id')
                ->where('users.id', $requestData['idStudent'])
                ->firstOrFail()
                ->id;

//            $requestData['idPension'] = Pension::select('pensions.id')
//                ->join('users', 'users.idLevel', '=', 'pensions.idLevel')
//                ->where('users.id', $requestData['idStudent'])
//                ->firstOrFail()
//                ->id;

//            dd($requestData['idPension']);

            $sumtranche = Tranche::select('id','name','price')
                ->where('idPension', $requestData['idPension'])
                ->where('idSchool', $student['idSchool'])
                ->where('idSection', $student['idSection'])
                ->sum('price');

            $sumstudentPensionUser = PensionUser::where('idStudent', $requestData['idStudent'])
                ->where('idPension', $requestData['idPension'])
                ->sum('advancePayment');
            $montantRestant = $sumtranche - $sumstudentPensionUser;

            // Si il a une bourse déjà utilisée, on déduit celà du reste à payer
            if($student->idBourse != null && $student->isBourseUsed){
                $scholarshipAmount = Bourse::find($student->idBourse)->amount;

                $montantRestant -= $scholarshipAmount;
            }

            return [
                'message' => $montantRestant, //Pourquoi ça s'appelle 'message'
                'total' => (float)$sumtranche,
                'alreadyPaid' => $sumstudentPensionUser
            ];
        } catch (\Throwable $th) {
            throw new ServiceException('Error balance users'. $th->getMessage());
        }
    }

    public function showPensionUser($id)
    {
        try {
            $pensionUser = PensionUser::find($id);
            return new PensionUserResource($pensionUser);
        } catch (\Throwable $th) {
            throw new ServiceException('Error show users'. $th->getMessage());
        }
    }

    /**
     * Retourner la liste des insolvables de la tranche/pension
     *
     * @param array $requestData
     * @return array
     * @throws ServiceException
     */
    public function insolvablePensionUser(array $requestData)
    {
        return $this->pensionUserSituation($requestData, false);
    }

    /**
     * Retourner la liste des solvablesde la tranche/pension
     *
     * @param array $requestData
     * @return array
     * @throws ServiceException
     */
    public function solvablePensionUser(array $requestData)
    {
        try {
            return $this->pensionUserSituation($requestData, true);
        } catch (\Throwable $th) {
            throw new ServiceException('Error fetching insolvable users'. $th->getMessage());
        }
    }

    /**
     * Retourner la sitation (solvable/insolvables) des students pour la pension/tranche souhaitée ou même l'école / section
     *
     * @param array $requestData
     * @param $isSolvable
     * @return array
     * @throws ServiceException
     */
//    public function pensionUserSituation(array $requestData, $isSolvable){
//        try {
//            $nameTranche = $requestData['nameTranche'] ?? null; // il veut check les insolvables de la cette tranche ci
//            $idSection = $requestData['idSection'] ?? null;
//            $idClasse = $requestData['idClasse'] ?? null;
//
//            // On va lier chaque utilisateur avec sa tranche ou sa pension (dépendant du cas dans le quel on se trouve) et faire les opérations donc
//
//            $users = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
//                ->join('roles','model_has_roles.role_id','=','roles.id')
//                ->join('schools','schools.id','=','users.idSchool')
//                ->join('classes', 'classes.id', "=", "users.idClasse")
//                ->join('levels', 'levels.id', "=", "users.idLevel")
//                ->join('pensions', 'pensions.idLevel', "=", "levels.id")
////                    ->join('option_level','option_level.id','=','users.idOptionLevel')
//                ->where([
//                    'roles.id' => 8,
//                    'users.deleted' => 0,
//                    'users.idSchool' => $requestData['idSchool'],
//                ])
//                ->when($idSection !== null, function ($query) use ($idSection) {
//                    $query->where('users.idSection', $idSection);
//                })
//                ->when($idClasse !== null, function ($query) use ($idClasse) {
//                    $query->where('users.idClasse', $idClasse);
//                })
//                ->when($nameTranche !== null, function ($users) use ($nameTranche) {
//                    $users->join('tranches', 'tranches.idPension', '=', 'pensions.id')
//                        ->where('tranches.name', $nameTranche)
//                        ->select('users.id as id','users.name as name','users.matricule as matricule','users.idClasse as idClasse','users.idLevel as idLevel','users.idParent as idParent','tranches.id as idTranche');
//                })
//                ->when($nameTranche == null, function ($users) use ($nameTranche) {
//                    $users->select('users.id as id','users.name as name','users.matricule as matricule','users.idClasse as idClasse','users.idLevel as idLevel','users.idParent as idParent','pensions.id as idPension');
//                })
//                ->orderBy('users.name')
//                ->get();
//
//            if($users->count() == 0){
//                throw new ServiceException(" --- Pas d'élèves pour ces données");
//            }
//
//            // Pour chacun des ces élèves, on élimine ceux qui ont tout payé (pension_users.solvable=terminé pour idTranche / idPension).
//            // Pour ceux qui restent, on voit combien ils devaient verser(en fonction de idTranche/idPension) et on détermine ainsi le montant restant
//
//            $results = array();
//
//            $totalToPayTranche = 0;
//            $totalDejaPayeTranche = 0;
//            $montantRestantTranche = 0;
//
//            foreach ($users as $user) {
//                if(!is_null($user->idPension)){
//                    $totalToPay = Pension::find($user->idPension)->price;
//                }else{
//                    $totalToPay = Tranche::find($user->idTranche)->price;
//                }
//
//                $alreadyPaid = PensionUser::where('idStudent', $user->id)
//                    ->when(!is_null($user->idTranche), function($query) use ($user) {
//                        $query->where('idTranche', $user->idTranche);
//                    })
//                    ->when(!is_null($user->idPension), function($query) use ($user) {
//                        $query->where('idPension', $user->idPension);
//                    })
//                    ->sum('advancePayment');
//
//                // à alreadyPaid, on va ajouter le montant de la bourse utilisée si elle existe
//                $scholarshipAmount = 0;
//                if(!is_null($user->idBourse) && $user->isBourseUsed) {
//                    $scholarshipAmount = @Bourse::find($user->idBourse)->price;
//                }
//
//                $alreadyPaid += $scholarshipAmount;
//
//                // Si on veut les solvables, alors la condition sera que le student ait tout payé, sinon le contraire (cad il lui doit encore verser de l'argent)
//                $condition = ($isSolvable) ? ($totalToPay == $alreadyPaid) : ($totalToPay != $alreadyPaid);
//
//                if($isSolvable && ($totalToPay == $alreadyPaid)){
//                    $results[] = [
//                        'id' => $user->id,
//                        'name' => $user->name,
//                        'matricule' => $user->matricule,
//                        'classe' => ClassesSimpResource::make($user->classe),
//                        'idParent' => $user->idParent,
//                        'totalDejaPaye' => $alreadyPaid,
//                        'montantRestant' => $totalToPay- $alreadyPaid
//                    ];
//                }else if(!$isSolvable && ($totalToPay != $alreadyPaid) ){
//                    $results[] = [
//                        'id' => $user->id,
//                        'name' => $user->name,
//                        'matricule' => $user->matricule,
//                        'classe' => ClassesSimpResource::make($user->classe),
//                        'idParent' => $user->idParent,
//                        'totalDejaPaye' => $alreadyPaid,
//                        'montantRestant' => $totalToPay- $alreadyPaid
//                    ];
//                }
//
//                $totalToPayTranche += $totalToPay;
//                $totalDejaPayeTranche += $alreadyPaid;
//                $montantRestantTranche += ($totalToPay- $alreadyPaid);
//
//            }
//
//            return [
//                'data' => $results,
//                'totalAPayer' => $totalToPayTranche,
//                'totalDejaPaye' => $totalDejaPayeTranche,
//                'montantRestantTranche' => $montantRestantTranche
//            ];
//        } catch (\Throwable $th) {
//            throw new ServiceException("Error fetching pension users' situation -- ". $th->getMessage());
//        }
//    }


    public function pensionUserSituation(array $requestData, $isSolvable)
    {
        try {

            /* =====================================================
             * 1. FILTRES
             * ===================================================== */
            $nameTranche = isset($requestData['nameTranche']) ? $requestData['nameTranche'] : null;
            $idSection   = isset($requestData['idSection'])   ? $requestData['idSection']   : null;
            $idClasse    = isset($requestData['idClasse'])    ? $requestData['idClasse']    : null;
            $idSchool    = $requestData['idSchool'];

            /* =====================================================
             * 2. RÉCUPÉRATION DES ÉLÈVES (relations)
             * ===================================================== */
            $query = User::with([
                'classe.level.pensions.tranches'
            ])
                ->whereHas('roles', function ($q) {
                    $q->where('id', 8);
                })
                ->where('users.deleted', 0)
                ->where('users.idSchool', $idSchool);

            if ($idSection) {
                $query->where('users.idSection', $idSection);
            }

            if ($idClasse) {
                $query->where('users.idClasse', $idClasse);
            }

            if ($nameTranche) {
                $query->whereHas('classe.level.pensions.tranches', function ($q) use ($nameTranche) {
                    $q->where('tranches.name', $nameTranche);
                });
            }

            $users = $query->orderBy('users.name')->get();

            if ($users->isEmpty()) {
                throw new ServiceException("Aucun élève trouvé.");
            }

            /* =====================================================
             * 3. TOTAUX GLOBAUX
             * ===================================================== */
            $results = array();
            $totalToPayTranche     = 0;
            $totalDejaPayeTranche  = 0;
            $montantRestantTranche = 0;

            /* =====================================================
             * 4. TRAITEMENT PAR ÉLÈVE
             * ===================================================== */
            foreach ($users as $user) {

                $totalToPay = 0;
                $totalPaid  = 0;
                $restant    = 0;
                $matchCondition = false;

                /* ============================
                 * Pension du niveau (1ère)
                 * ============================ */
                $level   = optional($user->classe)->level;
                $pension = $level ? $level->pensions->first() : null;

                if (!$pension) {
                    continue;
                }

                /* ============================
                 * CAS A : TRANCHE
                 * ============================ */
                if ($nameTranche) {

                    $tranche = $pension->tranches
                        ->where('name', $nameTranche)
                        ->first();

                    if (!$tranche) {
                        continue;
                    }

                    $totalToPay = $tranche->price;

                    $lastPayment = PensionUser::where('idStudent', $user->id)
                        ->where('idTranche', $tranche->id)
                        ->orderByDesc('id')
                        ->first();

                    if (!$lastPayment) {
                        $totalPaid = 0;
                        $restant   = $totalToPay;
                        $isPaid    = false;
                    } else {
                        $restant   = $lastPayment->balancePayment;
                        $totalPaid = $totalToPay - $restant;
                        $isPaid    = ($restant == 0);
                    }

                    $matchCondition = $isSolvable ? $isPaid : !$isPaid;
                }

                /* ============================
                 * CAS B : PENSION COMPLÈTE
                 * ============================ */
                else {

                    foreach ($pension->tranches as $tr) {
                        $totalToPay += $tr->price;
                    }

                    $payments = PensionUser::where('idStudent', $user->id)
                        ->where('idPension', $pension->id)
                        ->get();

                    foreach ($payments as $payment) {
                        $totalPaid += $payment->advancePayment;

                        if (!empty($payment->idBourse)) {
                            $bourse = Bourse::find($payment->idBourse);
                            if ($bourse) {
                                $totalPaid += $bourse->amount;
                            }
                        }
                    }

                    $soldedTranches = PensionUser::where('idStudent', $user->id)
                        ->whereIn('idTranche', $pension->tranches->pluck('id'))
                        ->where('balancePayment', 0)
                        ->distinct()
                        ->pluck('idTranche');

                    $isPaidByTranches = $pension->tranches
                        ->pluck('id')
                        ->diff($soldedTranches)
                        ->isEmpty();

                    $isPaidByAmount = $totalPaid >= $totalToPay;

                    $isPaid = $isPaidByTranches || $isPaidByAmount;

                    $matchCondition = $isSolvable ? $isPaid : !$isPaid;
                    $restant = $totalToPay - $totalPaid;
                }

                /* =================================================
                 * 5. AJOUT AU RÉSULTAT
                 * ================================================= */
                if ($matchCondition) {

                    if ($restant < 0) {
                        $restant = 0;
                    }

                    $moratoriumsData = array();
                    $moratoriums = Moratorium::where('idUser', $user->id)
                        ->orderBy('endDate', 'DESC')
                        ->get();

                    foreach ($moratoriums as $m) {
                        $moratoriumsData[] = array(
                            'id'        => $m->id,
                            'startDate' => $m->startDate,
                            'endDate'   => $m->endDate,
                            'reason'    => $m->reason,
                            'status'    => $m->status,
                        );
                    }

                    $results[] = array(
                        'id'             => $user->id,
                        'name'           => $user->name,
                        'matricule'      => $user->matricule,
                        'classe'         => ClassesSimpResource::make($user->classe),
                        'idParent'       => $user->idParent,
                        'totalDejaPaye'  => $totalPaid,
                        'montantRestant' => $isSolvable ? 0 : $restant,
                        'moratoriums'    => $moratoriumsData,
                    );

                    $totalToPayTranche     += $totalToPay;
                    $totalDejaPayeTranche  += $totalPaid;
                    $montantRestantTranche += (!$isSolvable) ? $restant : 0;
                }
            }

            /* =====================================================
             * 6. RETOUR FINAL
             * ===================================================== */
            return array(
                'data'                  => $results,
                'totalAPayer'           => $totalToPayTranche,
                'totalDejaPaye'         => $totalDejaPayeTranche,
                'montantRestantTranche' => $montantRestantTranche
            );

        } catch (\Throwable $e) {
            throw new ServiceException(
                'Erreur lors du calcul de la situation de pension : ' . $e->getMessage()
            );
        }
    }


    public function destroyPensionUser($id)
    {
        try {
            $pensionUser = PensionUser::findOrFail($id);

            // Si il y'avait une bourse sur cette transaction, on la remet en place chez l'utilisateur
            if(!is_null($pensionUser->idBourse)){
                $user = User::find($pensionUser->idStudent);
                $user->isBourseUsed = false;
                $user->save();
            }

            $pensionUser->update([
                'deleted' => true,
                'deleted_by' => auth()->user()->id,
            ]);

            //Sauvegarder dans la table des archives
            PensionUserArchive::create($pensionUser->toArray());

            $pensionUser->delete();

            return response()->json("PensionUser supprimé avec succès.", 200);
        } catch (\Throwable $th) {
            throw new ServiceException('Error deleting pension user '. $th->getMessage());
        }
    }

    public function archiveOrRestore(array $request)
    {
        $action = $request['action'];
        $idPensionUser = $request['idPensionUser'];
        $reason = $request['reason'] ?? null;

        try {
            if($action == 'restore'){
                $pensionUser = PensionUser::withoutGlobalScope('isDeleted')->findOrFail($idPensionUser);
            }
            else if($action == 'archive'){
                $pensionUser = PensionUser::findOrFail($idPensionUser);
            }

            $pensionUser->update([
                'deleted' => ($action == 'restore') ? false : true,
                'reason' => $reason,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json("PensionUser $action avec succès.", 200);
        } catch (\Throwable $th) {
            throw new ServiceException("Error $action pension user --- ". $th->getMessage());
        }
    }

    public function getSumTransactionPensionUser($requestData)
    {
        try {
            $idStudent = $requestData['idStudent'] ?? null;
            $sumTransac = null;

            switch ($idStudent) {
                case null:
                    $sumTransac = DB::table('pension_users')
                        ->select(DB::raw('SUM(advancePayment) as sumTransaction'))
                        ->where('idSection', $requestData['idSection'])
                        ->where('idSchool', $requestData['idSchool'])
                        ->get();
                    break;

                default:
                    $sumTransac = DB::table('pension_users')
                        ->select(DB::raw('SUM(advancePayment) as sumTransaction'))
                        ->where('idSection', $requestData['idSection'])
                        ->where('idSchool', $requestData['idSchool'])
                        ->where('idStudent', $requestData['idStudent'])
                        ->get();
                    break;
            }

            return $sumTransac;
        } catch (\Throwable $th) {
            throw new ServiceException('Error getting sum of transactions'. $th->getMessage());
        }
    }

    public function getPensionTransaction($requestData)
    {
        try {
            $date = $requestData['date'] ?? null;
            $idSchool = $requestData['idSchool'] ?? null;
            $idSection = $requestData['idSection'] ?? null;

            if (!empty($date) && !empty($idSchool) && !empty($idSection)) {
                $transactions = PensionUser::whereDate('created_at', $date)
                    ->where('idSchool', $idSchool)
                    ->where('idSection', $idSection)
                    ->orderBy("id", "desc")
                    ->get();

                $sommes = PensionUser::select(
                    DB::raw('SUM(CASE WHEN payment_mode = "Mtn Money" THEN advancePayment ELSE 0 END) AS momo_total'),
                    DB::raw('SUM(CASE WHEN payment_mode = "Cash" THEN advancePayment ELSE 0 END) AS cash_total'),
                    DB::raw('SUM(CASE WHEN payment_mode = "Orange Money" THEN advancePayment ELSE 0 END) AS om_total'),
                    DB::raw('SUM(CASE WHEN payment_mode = "Credit card" THEN advancePayment ELSE 0 END) AS creditcard_total')
                )
                    ->whereDate('created_at', $date)
                    ->where('idSchool', $idSchool)
                    ->where('idSection', $idSection)
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

                return $response;
            }
        } catch (\Throwable $th) {
            throw new ServiceException('Error fetching pension transactions'. $th->getMessage());
        }
    }

    /**
     * Récupérer le résumé de pension des élèves avec infos bourse
     *
     * @param array $requestData
     * @return array
     * @throws ServiceException
     */
    public function getStudentsPensionSummary(array $requestData)
    {
     try {
        $idClasse = $requestData['idClasse'] ?? null;
        $idStudent = $requestData['idStudent'] ?? null;
        $idSchool = $requestData['idSchool'] ?? null;
        $idSection = $requestData['idSection'] ?? null;

        if (!$idClasse && !$idSchool && !$idSection && !$idStudent) {
            throw new ServiceException('Au moins un filtre doit être fourni');
        }

        $studentQuery = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.id', 8)
            ->where('users.deleted', 0)
            ->select('users.*')
            ->distinct();

        if ($idStudent) {
            $studentQuery->where('users.id', $idStudent);
        }
        if ($idClasse) {
            $studentQuery->where('users.idClasse', $idClasse);
        }
        if ($idSchool) {
            $studentQuery->where('users.idSchool', $idSchool);
        }
        if ($idSection) {
            $studentQuery->where('users.idSection', $idSection);
        }

        // tri décroissant par id
        $students = $studentQuery->orderByDesc('users.id')->get();

        if ($students->isEmpty()) {
            throw new ServiceException('Aucun élève trouvé');
        }

        $data = [];

        foreach ($students as $student) {

            $pension = Pension::select('pensions.id')
                ->join('levels', 'levels.id', '=', 'pensions.idLevel')
                ->join('classes', 'classes.idLevel', '=', 'levels.id')
                ->where('classes.id', $student->idClasse)
                ->where('pensions.idSchool', $student->idSchool)
                ->where('pensions.idSection', $student->idSection)
                ->first();

            $montantPension = $pension 
                ? Tranche::where('idPension', $pension->id)->sum('price') 
                : 0;

            $dejaPaye = PensionUser::where('idStudent', $student->id)
                ->when($pension, function($q) use ($pension) {
                    $q->where('idPension', $pension->id);
                })
                ->sum('advancePayment');

            $bourse = null;
            $isBourseUser = false;
            $dejaPayes = $dejaPaye;

            if ($student->idBourse) {
                $bourseModel = Bourse::find($student->idBourse);
                $isBourseUser = (bool) $student->isBourseUsed;

                if ($bourseModel && $isBourseUser) {
                   $dejaPayes += $bourseModel->amount;
                    $bourse = [
                        'id' => $bourseModel->id,
                        'name' => $bourseModel->name,
                        'amount' => $bourseModel->amount
                    ];

                }
             // $resteAPayer = max(0, $montantPension - $dejaPayes);
            }
            
                $resteAPayer = max(0, $montantPension - $dejaPayes);
            

            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'montantPension' => (float)$montantPension,
                'dejaPaye' => (float)$dejaPaye,
                'resteAPayer' => (float)$resteAPayer,
                'bourse' => $bourse,
                'isBourseUser' => $isBourseUser
            ];
        }

        // retour propre avec data
        return $data;

    } catch (\Throwable $th) {
        throw new ServiceException('Error getStudentsPensionSummary: ' . $th->getMessage());
    }
  }
}
