<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherObservationResource extends JsonResource
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
            'description' => $this->description,
            'answer' => $this->answer,
            'idAssessment' => $this->idAssessment,
            'idStudent' => new InscriptionSimpResource(User::find($this->idStudent)),
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'idTeacher' => new TeacherSimpResource(User::find($this->idTeacher)),
            'created_at' => $this->created_at
        ];
    }
}
