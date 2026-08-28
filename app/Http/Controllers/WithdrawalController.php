<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Jobs\SendSMSJob;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Http\Requests\Staffs\WithdrawalRequest;
use App\Http\Resources\Staffs\WithdrawalResource;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\WithdrawalConfirmRequest;
use App\Mail\ConfirmationWithdrawalMail;
use App\Models\FeeUser;
use App\Models\PensionUser;
use App\Mail\RemboursementMail;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Withdrawal
 */
class WithdrawalController extends BaseController
{
    /**
     * Afficher la liste des retraits
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'];
            $idSection = $request['idSection'];

            $withdrawals = Withdrawal::query();

            if(!is_null($idSchool)) $withdrawals = $withdrawals->where('idSchool',$request['idSchool']);
            if(!is_null($idSection)) $withdrawals = $withdrawals->where('idSection',$request['idSection']);

            $filter_value = $request['filter_value'];
            if(!is_null($filter_value)){
                $withdrawals->where(function($query) use ($filter_value) {
                    $query->where('mode_retrait', 'like', "%$filter_value%")
                        ->orWhere('numero_retrait', 'like', "%$filter_value%")
                        ->orWhere('status', 'like', "%$filter_value%");
                });
            }

            $total = $withdrawals->sum('montant_retrait_net');

            return [
                'data' => WithdrawalResource::collection(
                    $withdrawals
                        ->orderBy("id", "desc")
                        ->get()
                ),
                'sommes' => $total,
            ];

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer un nouveau retrait
     *
     * @param  \Illuminate\Http\Request  $request
     * @return WithdrawalResource
     */
    public function store(WithdrawalRequest $request)
    {
        try {
            if(!$request['idUser']){
                return $this->sendError("idUser est obligatoire");
            }else if (!$request['mode_retrait']) {
                return $this->sendError("mode_retrait est obligatoire");
            }else if (!$request['idSchool']) {
                return $this->sendError("idSchool est obligatoire");
            }else if (!$request['date']) {
                return $this->sendError("date est obligatoire");
            }else if (!$request['montant_retrait_net']) {
                return $this->sendError("montant_retrait_net est obligatoire");
            }

            DB::beginTransaction();
            $withdrawal = Withdrawal::where('idSchool',$request['idSchool'])
                ->where('type', $request['type'])
                ->where('status','pending')
                ->sum('montant_retrait_brut');

            $pensionUsersAmount = PensionUser::where('idSchool',$request['idSchool'])
                ->where('payment_mode', $request['type'])
                ->sum('advancePayment');

            $feeUsersAmount = FeeUser::where('idSchool',$request['idSchool'])
                ->where('payment_mode', $request['type'])
                ->sum('advancePayment');

            $totalAmount = $pensionUsersAmount + $feeUsersAmount;
            $sommeEnCaisse = $totalAmount - $withdrawal;
            $sommeTotalDisponible = $sommeEnCaisse; //* 0.98;

            if($request['montant_retrait_net'] > $sommeTotalDisponible){
                return $this->sendError("Impossible d'effectuer ce retrait. Le montant en caisse est de ".$sommeTotalDisponible);
            }

            if($request['montant_retrait_net'] <= 0){
                return $this->sendError("Le montant à retirer ne peut pas être négatif ou égale à 0");
            }

            $withdrawal = new Withdrawal();
            $withdrawal->montant_retrait_brut = $request['montant_retrait_net']; /// 0.98;
            $withdrawal->montant_retrait_net = $request['montant_retrait_net'];
            $withdrawal->frais_bancaire = $request['frais_bancaire'] ?? null;
            $withdrawal->type = $request['type'];
            $withdrawal->status = "initiated";
            $withdrawal->code = mt_rand(100000, 999999);
            $withdrawal->mode_retrait = $request['mode_retrait'];
            $withdrawal->rib = $request['rib'] ?? null;
            $withdrawal->idUser = $request['idUser'];
            $withdrawal->numero_retrait = $request['numero_retrait'] ?? null;
            $withdrawal->date = $request['date'] ?? null;
            $withdrawal->idSchool = $request['idSchool'];
            $withdrawal->idSection = $request['idSection'] ?? null;
            $withdrawal->created_by = auth()->user()->id;
            $withdrawal->save();

            DB::commit();
            Log::info("Retrait initié à l'instant depuis la plateforme MS-School, d'un montant de {$withdrawal->montant_retrait_net} F.");

            //TODO: Notifier le user par SMS & Mail. DÉCOMMENTEZ LES LIGNES SUIVANTES
            $user = User::select('id', 'name', 'phone', 'email')->find($request['idUser']);

            if(!is_null($user->phone)){
                dispatch(new SendSMSJob(
                        [$user->phone],
                        "Retrait initié à l'instant depuis la plateforme MS-School, d'un montant de {$withdrawal->montant_retrait_net} F. Code: {$withdrawal->code}",
                        'remboursement'
                    )
                );
            }

            if(!is_null($user->email)){
                $this->sendWithdrawalConfirmationEmail($withdrawal,"confirmation");
            }

            return new WithdrawalResource($withdrawal);
        }catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    protected function sendWithdrawalConfirmationEmail($withdrawal,$type)
    {
        $user = User::find($withdrawal->idUser);
        $school = School::select('schools.name as school', 'establishments.name as establishments')
                        ->join('establishments', 'schools.idEstablishment', '=', 'establishments.id')
                        ->where('schools.id',$withdrawal->idSchool)
                        ->first();

        switch ($type) {
            case 'remboursement':
                $mailable = new RemboursementMail(
                    $withdrawal->montant_retrait_net,
                    $withdrawal->mode_retrait,
                    $withdrawal->rib,
                    $withdrawal->numero_retrait,
                    $withdrawal->date,
                    $user->name,
                    $school->school . ' / ' . $school->establishments
                );
                $recipients = [
//                    'ducoduco21@gmail.com',
                    'remboursement@ms-school.net',
                    'houbadesire@gmail.com'
                ];

                SendMailJob::dispatch($mailable, $recipients, 'smtp2');
                break;

            case 'confirmation':
                $mailable = new ConfirmationWithdrawalMail(
                    $withdrawal->montant_retrait_net,
                    $withdrawal->mode_retrait,
                    $withdrawal->rib,
                    $withdrawal->numero_retrait,
                    $withdrawal->date,
                    $user->name,
                    $school->school . ' / ' . $school->establishments,
                    $withdrawal->code
                );
                $recipients = [$user->email];

                SendMailJob::dispatch($mailable, $recipients, 'smtp2');
                break;
            default:
                $mailable = new RemboursementMail(
                    $withdrawal->montant_retrait_net,
                    $withdrawal->mode_retrait,
                    $withdrawal->rib,
                    $withdrawal->numero_retrait,
                    $withdrawal->date,
                    $user->name,
                    $school->school . ' / ' . $school->establishments
                );
                $recipients = [
//                    'ducoduco21@gmail.com',
                    'remboursement@ms-school.net',
                    'houbadesire@gmail.com'
                ];
                SendMailJob::dispatch($mailable, $recipients, 'smtp2');

                // Je sais pas pourquoi y'a 2 envois de mails ici mais bon ...
//                $mailable = new ConfirmationWithdrawalMail(
//                    $withdrawal->montant_retrait_net,
//                    $withdrawal->mode_retrait,
//                    $withdrawal->rib,
//                    $withdrawal->numero_retrait,
//                    $withdrawal->date,
//                    $user->name,
//                    $school->school . ' / ' . $school->establishments,
//                    $withdrawal->code
//                );
//                $recipients = [
////                    'leducboyo@gmail.com',
//                    $user->email
//                ];
//                SendMailJob::dispatch($mailable, $recipients);
                break;
        }
    }

    /**
     * Afficher les informations d'un retrait
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $withdrawal = Withdrawal::findOrFail($id);

            return new WithdrawalResource($withdrawal);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un retrait
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $withdrawal = Withdrawal::find($id);

            $withdrawal->montant_retrait_brut = $request['montant_retrait_brut'] ?? $withdrawal['montant_retrait_brut'];
            $withdrawal->montant_retrait_net = $withdrawal['montant_retrait_net']; //($request['montant_retrait_net'] * 0.98) ?? $withdrawal['montant_retrait_net'];
            $withdrawal->frais_bancaire = $request['frais_bancaire'] ?? $withdrawal['frais_bancaire'];
            $withdrawal->mode_retrait = $request['mode_retrait'] ?? $withdrawal['mode_retrait'];
            $withdrawal->status = $request['status'] ?? $withdrawal['status'];
            $withdrawal->rib = $request['rib'] ?? null;
            $withdrawal->idUser = $request['idUser'] ?? $withdrawal['idUser'];
            $withdrawal->type = $request['type'] ?? $withdrawal['type'];
            $withdrawal->numero_retrait = $request['numero_retrait'] ?? null;
            $withdrawal->date = $request['date'] ?? null;
            $withdrawal->reference = $request['reference'] ?? $withdrawal->reference;
            $withdrawal->details = $request['details'] ?? $withdrawal->details;
            $withdrawal->idSchool = $request['idSchool'] ?? $withdrawal['idSchool'];
            $withdrawal->idSection = $request['idSection'] ?? null;
            $withdrawal->updated_by = auth()->user()->id;
            $withdrawal->save();

            return new WithdrawalResource($withdrawal);
        } catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }

    }

    public function confirmcode(WithdrawalConfirmRequest $request)
    {
        try {
            $request = $request->validated();

            $withdrawal = Withdrawal::find($request['idwithdrawal']);

            $withdrawalSum = Withdrawal::where('idSchool',$withdrawal['idSchool'])
                ->where('type', $withdrawal->type)
                ->where('status','pending')
                ->sum('montant_retrait_brut');

            $pensionUsersAmount = PensionUser::where('idSchool',$withdrawal['idSchool'])
                                    ->where('payment_mode', $withdrawal->type)
                                    ->sum('advancePayment');

            $feeUsersAmount = FeeUser::where('idSchool',$withdrawal['idSchool'])
                                ->where('payment_mode', $withdrawal->type)
                                ->sum('advancePayment');



            $totalAmount = $pensionUsersAmount + $feeUsersAmount;

            $sommeEnCaisse = $totalAmount - $withdrawalSum;
            $sommeTotalDisponible = ($totalAmount - $withdrawalSum); //* 0.98;

            if($request['code'] == $withdrawal['code']){
                if($withdrawal['montant_retrait_net'] > $sommeTotalDisponible){
                    return $this->sendError("Impossible, le montant en caisse est de ".$sommeTotalDisponible);
                }

                $withdrawal->status = "pending";
                $withdrawal->updated_by = auth()->user()->id;
                $withdrawal->save();

                $this->sendWithdrawalConfirmationEmail($withdrawal,"remboursement");

                //TODO: Notifier MH-tech d'un retrait en attente de validation
                $school = School::select('name')->find($withdrawal->idSchool);

                $sms_content = "Retrait en attente de validation initié à l'instant par l'école {$school->name} d'un montant de {$withdrawal->montant_retrait_net} F.";

                $this->dispatch(new SendSMSJob(["237691773680"], $sms_content, 'remboursement'));

                return new WithdrawalResource($withdrawal);
            }else{
                return $this->sendError("Le code de confirmation est incorrect");
            }
        } catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    /**
     * Supprimer un retrait
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $withdrawal = Withdrawal::findOrFail($id);

            $withdrawal->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }

    }
}
