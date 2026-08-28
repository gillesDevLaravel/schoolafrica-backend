<?php

namespace App\Http\Resources\AdminSimp;

use Illuminate\Http\Resources\Json\JsonResource;

class CashInSimpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
