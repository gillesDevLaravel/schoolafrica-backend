<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\AdminSimp\SectionSimpResource;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserLoginResource extends JsonResource
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
            'username' => $this->username,
            'phone' => $this->phone,
            'whatsapp_number' => $this->whatsapp_number,
            'role' => $this->role,
            'role_description' => $this->role_description,
            'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            'typeRole' => $this->typeRole,
            'adresse' => $this->adresse,
            'observation' => $this->observation,
            'photo' => $this->photo,
            'logoSchool' => $this->logoSchool,
            'scholar_level' => $this->scholar_level,
            'idCycle' => $this->idCycle,
            'idLevel' => $this->idLevel,
            'idClasse' => $this->idClasse,
            'idClasse2' => $this->idClasse2,
            'idBourse' => $this->idBourse,
            'isBourseUsed' => (bool)$this->isBourseUsed,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'classes' => $this->classes()->get(),
            'school' => SchoolSimpResource::make(School::find($this->idSchool)),
            'section' => new SectionSimpResource(Section::find($this->idSection)),
            //'classes' => $this->classes()->pluck('classes.id'),
            'token' => $this->createToken('Api Token of ' . $this->name, $this->getPermissionsViaRoles()->pluck('name')->toArray())->plainTextToken,
            'registrationPaid' => $this->registrationPaid,
            'build_number' => $this->build_number,
            'build_number_verified' => (boolean)$this->build_number_verified,
            'pay_om_fees' => (boolean)$this->pay_om_fees,
            'fees_required' => $this->fees_required ?? false,
            'academicYear' => AcademicYear::getCurrent()
                ? SchoolYearResource::make(AcademicYear::getCurrent())
                : null,
        ];
    }
}
