<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Classes;
use App\Models\Coefficient;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AssessmentSimpResource extends JsonResource
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
            'libelle' => $this->libelle,
            'notemax' => $this->notemax,
            'is_qcm' => (boolean) $this->is_qcm,
            'duration' => $this->duration,
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
            'date' => $this->date,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'coefficient' => new CoefficientResourceSimple(Coefficient::find($this->idCoeficient)),
            'teacher' => new TeacherSimpResource(User::find($this->idTeacher)),
        ];
    }
}
