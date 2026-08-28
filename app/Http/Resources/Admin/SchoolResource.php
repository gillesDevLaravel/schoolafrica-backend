<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'logo' => $this->logo,
            'matricule_code' => $this->matricule_code,
            'city' => $this->city,
            'section' => $this->section,
            'scholar_level' => $this->scholar_level,
            'email' => $this->email,
            'website' => $this->website,
            'land_title' => $this->land_title,
            'building_permit' => $this->building_permit,
            'creation_authorization' => $this->creation_authorization,
            'opening_authorization' => $this->opening_authorization,
            'nui' => $this->nui,
            'cnps' => $this->cnps,
            'location_plan' => $this->location_plan,
            'information_sheets' => $this->information_sheets,
            'principal' => new UserResource(User::find($this->idPrincipal)),
            'adjoint' => new UserResource($this->adjoint),
            'assistant' => $this->idAssistant,
            'secretary' => UserSimpResource::make($this->secretary),
            'establishment' => new EstablishmentResource(Establishment::find($this->idEstablishment))
        ];
    }
}
