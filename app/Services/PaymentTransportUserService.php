<?php
namespace App\Services;

use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Http\Resources\PaymentTransportUserResource;
use App\Models\Notification;
use App\Models\PaymentTransportUser;
use App\Models\PurchaseOrder;
use App\Models\TransportUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentTransportUserService
{
    public function createPayment(array $requestData)
    {
        try {
            $montant_total = number_format($requestData['advance_payment']);

            // Dernier paiement existant
            $transportPayment = PaymentTransportUser::where('transport_user_id', $requestData['transport_user_id'])
                ->latest('created_at')->first();

            // Vérification étudiant
            $transportUser = TransportUser::findOrFail($requestData['transport_user_id']);
            $student = User::findOrFail($transportUser->student_id);

            // Détails du transport
            $transport = TransportUser::select('transport_users.id as id', 'transport_users.amount as amount')
                ->where('transport_users.id', $requestData['transport_user_id'])
                ->where('transport_users.student_id', $student->id)
                ->firstOrFail();

            // Vérifications
            if (is_null($requestData['advance_payment'])) {
                return [false, __('transport_payment.advance_payment_null')];
            }
            if ($requestData['advance_payment'] == 0) {
                return [false, __('transport_payment.advance_payment_zero')];
            }

            // Nouveau paiement
            $payment = new PaymentTransportUser();
            $payment->transport_user_id = $requestData['transport_user_id'];
            $payment->receipt_number = $requestData['receipt_number'] ?? null;
            $payment->scan_receipt = $requestData['scan_receipt'] ?? null;
            $payment->payment_date = $requestData['payment_date'] ?? null;
            $payment->telephone = $requestData['telephone'] ?? null;
            $payment->reference = $requestData['reference'] ?? null;
            $payment->created_by = Auth::id();

            if (!$transportPayment) {
                // Premier paiement
                if ($requestData['advance_payment'] < 0) {
                    return [false, __('transport_payment.advance_payment_negative')];
                }
                if ($requestData['advance_payment'] > $transport->amount) {
                    return [false, __('transport_payment.advance_payment_exceeds')];
                }

                if ($requestData['advance_payment'] < $transport->amount) {
                    $payment->advance_payment = $requestData['advance_payment'];
                    $payment->balance_payment = $transport->amount - $requestData['advance_payment'];
                    $payment->payment_mode = $requestData['payment_mode'];
                    $payment->solvable = 'avancé';
                } else {
                    $payment->advance_payment = $transport->amount;
                    $payment->balance_payment = 0;
                    $payment->payment_mode = $requestData['payment_mode'];
                    $payment->solvable = 'terminé';
                }

                $payment->save();
                $payment->remaining_fees = $transport->amount;
            } else {
                // Paiement existant
                if ($transportPayment->balance_payment == 0) {
                    return [false, __('transport_payment.fully_paid')];
                }
                if ($requestData['advance_payment'] < 0) {
                    return [false, __('transport_payment.advance_payment_negative')];
                }
                if ($requestData['advance_payment'] > $transportPayment->balance_payment) {
                    return [false, __('transport_payment.advance_payment_exceeds_remaining')];
                }

                if ($requestData['advance_payment'] < $transportPayment->balance_payment) {
                    $payment->advance_payment = $requestData['advance_payment'];
                    $payment->balance_payment = $transportPayment->balance_payment - $requestData['advance_payment'];
                    $payment->payment_mode = $requestData['payment_mode'];
                    $payment->solvable = 'avancé';
                } else {
                    $payment->advance_payment = $requestData['advance_payment'];
                    $payment->balance_payment = 0;
                    $payment->payment_mode = $requestData['payment_mode'];
                    $payment->solvable = 'terminé';
                }

                $payment->save();
                $payment->remaining_fees = $transportPayment->balance_payment;
            }

            // Préparation ressource
            $tabPayment['PaymentTransport'] = new PaymentTransportUserResource($payment);

            // Notification
            Notification::create([
                'notificationable_type' => PaymentTransportUser::class,
                'notificationable_id' => $payment->id,
                'title' => __('notifs.transport_payment_title', [
                    'montant_total' => $montant_total,
                    'transport' => $transport->id
                ]),
                'description' => __('notifs.transport_payment_desc', [
                    'montant_total' => $montant_total,
                    'transport' => $transport->id,
                    'student_name' => $student->name
                ]),
                'grouped_users' => json_encode([$student->id, $student->idParent])
            ]);

            return [true, $tabPayment];
        } catch (\Throwable $th) {
            Log::error('Erreur Service Paiement Transport : ' . $th->getMessage());
            return [false, __('app.error_occured')];
        }
    }
}
