<?php

namespace App\Http\Resources\AdminSimp;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientSimpResource extends JsonResource
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
            'name' => $this->name,
            'adresse' => $this->adresse,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
