<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\UserAllResource;
use App\Http\Resources\Admin\SchoolResource;
use App\Http\Resources\Admin\SectionResource;
use App\Models\School;
use App\Models\Section;
use App\Models\User;

class SchoolFolderResource extends JsonResource
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
            'medicalCertificate' => $this->medicalCertificate,
            'lastBulletin' => $this->lastBulletin,
            'lastDiploma' => $this->lastDiploma,
            'birthCertificate' => $this->birthCertificate,
            'student' => new UserAllResource(User::find($this->idStudent)),
            'school' => new SchoolResource(School::find($this->idSchool)),
            'section' => new SectionResource(Section::find($this->idSection)),
        ];
    }
}
