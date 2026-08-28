<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTransportUserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'transport_user'  => TransportUserResource::make($this->transportUser),
            'advance_payment' => $this->advance_payment,
            'balance_payment' => $this->balance_payment,
            'payment_date'    => $this->payment_date,
            'payment_mode'    => $this->payment_mode,
            'solvable'        => $this->solvable,
            'scan_receipt'    => $this->scan_receipt,
            'photo'           => $this->photo,
            'reason'          => $this->reason,
            'receipt_number'  => $this->receipt_number,
            'telephone'       => $this->telephone,
            'reference'       => $this->reference,
            'created_by'      => UserSimpResource::make($this->created_by),
            'updated_by'      => UserSimpResource::make($this->updated_by),
            'deleted_by'      => UserSimpResource::make($this->deleted_by),
        ];
    }
}
