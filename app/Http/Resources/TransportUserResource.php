<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransportUserResource extends JsonResource
{
    public function toArray($request)
    {
        // Récupérer tous les paiements
        $payments = $this->payments()->get();

        // Calculer le reste à payer : dernier balance_payment ou montant total si aucun paiement
        $lastPayment = $payments->sortByDesc('payment_date')->first();
        $remaining = ($lastPayment !== null)
            ? $lastPayment->balance_payment
            : $this->amount - ($this->reduction ? $this->reduction_amount : 0);

        // Calculer le total déjà payé : somme de toutes les avances uniquement
        $totalPaid = $payments->sum('advance_payment');

        return [
            'id'               => $this->id,
            'transport'        => $this->transport,
            'student'          => $this->student,
            'type'             => $this->type,
            'amount'           => $this->amount,
            'reduction'        => $this->reduction,
            'reduction_amount' => $this->reduction_amount,
            'reason'           => $this->reason,
            'remaining_amount' => $remaining,   // Reste à payer
            'total_paid'       => $totalPaid,   // Somme des avances
            'created_at'       => $this->created_at,
        ];
    }
}
