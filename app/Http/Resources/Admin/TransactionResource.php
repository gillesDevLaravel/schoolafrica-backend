<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\InvoiceSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\Invoice;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'payment_mode' => $this->payment_mode,
            'reference' => $this->reference,
            'payment_date' => $this->payment_date,
            'status' => $this->status,
            'type' => $this->type,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'idFee' => $this->idFee,
            'tnxid' => $this->tnxid,
            'compteEmeteur' => $this->compteEmeteur,
            'idStudent' => $this->idStudent,
            'student' => UserSimpResource::make($this->student),
            'idInscription' => $this->idInscription,
            'idPension' => $this->idPension,
            'idTranche' => $this->idTranche,
            'idEnseignant' => $this->idEnseignant,
            'invoice' => new InvoiceSimpResource(Invoice::find($this->idInvoice)),
            'created_at' => $this->created_at,
        ];
    }
}
