<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\ClientSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Http\Resources\TypeOfRecipeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtracashinsResource extends JsonResource
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
            'amount_to_receive' => $this->amount_to_receive,
            'amount_received' => $this->amount_received,
            'amount_remaining' => $this->amount_remaining,
            'reason' => $this->reason,
            'client' => UserSimpResource::make($this->client),
            'payment_method' => $this->payment_method,
            'payment_date' => $this->payment_date,
            'receipt_number' => $this->receipt_number,
            'operator' => $this->operator,
            'typeOfRecipe' => TypeOfRecipeResource::make($this->typeOfRecipe),
            'created_at' => $this->created_at
        ];
    }
}
