<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\SectionSimpResource;
use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginGetResource extends JsonResource
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
            'scholar_type' => $this->scholar_type,
            'phone' => $this->phone,
            'role' => $this->role,
            'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            'typeRole' => $this->typeRole,
            'adresse' => $this->adresse,
            'photo' => $this->photo,
            'scholar_level' => $this->scholar_level,
            'idCycle' => $this->idCycle,
            'idClasse' => $this->idClasse,
            'idLevel' => $this->idLevel,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'section' => SectionSimpResource::make(Section::find($this->idSection)),
            'classes' => $this->classes()->get(),
            'idBourse' => $this->idBourse,
            'isBourseUsed' => (bool)$this->isBourseUsed,
            'registrationPaid' => $this->registrationPaid,
            'build_number' => $this->build_number,
            'pay_om_fees' => (boolean)$this->pay_om_fees,
            'observation' => $this->observation,
            'build_number_verified' => (boolean)$this->build_number_verified,
        ];
    }
}
