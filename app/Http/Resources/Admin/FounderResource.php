<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FounderResource extends JsonResource
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
            'nationality' => $this->nationality,
            'city' => $this->city,
            'adresse' => $this->adresse,
            'photo' => $this->photo,
            'signature' => $this->signature,
            'country' => $this->country,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'scholar_level' => $this->scholar_level,
            'username' => $this->username,
            'birthday' => $this->birthday,
            'password' => $this->password,
            'cni' => $this->cni,
            'idRole' => $this->idRole,
            'idBourse' => $this->idBourse,
            'isBourseUsed' => (bool)$this->isBourseUsed,
            'niu' => $this->niu,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }
}
