<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'type' => $this->type,
            'image' => @$this->image,
            'adresse' => $this->adresse,
            'website' => $this->website,
            'niu' => $this->niu,
            'rc' => @$this->rc,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'cni' => $this->cni,
            'country' => $this->country,
            'city' => $this->city,
        ];
    }
}
