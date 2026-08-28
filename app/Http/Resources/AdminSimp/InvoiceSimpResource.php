<?php

namespace App\Http\Resources\AdminSimp;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceSimpResource extends JsonResource
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
            'reasons' => $this->reasons,
            'amount' => $this->amount,
            'type_produit' => $this->type_produit,
            'quantite' => $this->quantite,
            'prix_unitaire' => $this->prix_unitaire,
        ];
    }
}
