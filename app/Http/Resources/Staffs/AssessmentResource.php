<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\StaffsSimp\CoefficientResourceSimple;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StaffsSimp\MatterSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use App\Models\Classes;
use App\Models\Coefficient;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Str;

class AssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $object = $this;
        return [
            'id' => $this->id,
            'hour' => $this->hour,
            'libelle' => $this->libelle,
            'day' => $this->day,
            'notemax' => $this->notemax,
            'oral' => $this->oral,
            'orale' => $this->orale,
            'ecrit' => $this->ecrit,
            'written' => $this->written,
            'attitude' => $this->attitude,
            'savoir_etre' => $this->savoir_etre,
            'pratical' => $this->pratical,
            'pratique' => $this->pratique,
            'percentage' => $this->percentage,
            'is_qcm' => (boolean) $this->is_qcm,
            'duration' => $this->duration,
            'date' => $this->date,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'coefficient' => new CoefficientResourceSimple(Coefficient::find($this->idCoeficient)),
            'typeevaluations' => $this->typeEvaluations()->orderBy('type_evaluation.id')->pluck('type_evaluation.id'),
            'typeevaluationsName' => $this->typeEvaluations()->orderBy('type_evaluation.id')->pluck('type_evaluation.name'),
            'typeevaluationsLibelle' => $this->typeEvaluations()->orderBy('type_evaluation.id')->pluck('type_evaluation.libelle'),
            'typeevaluationsValues' => array_map(function($type) use ($object) {
                $type = Str::slug($type, "_");
                return $object->$type;
            }, $this->typeEvaluations()->orderBy('type_evaluation.id')->pluck('type_evaluation.name')->toArray()), //$this->typeEvaluations()->orderBy('type_evaluation.id')->pluck('type_evaluation.libelle'),
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
            'assessmentTypes' => $this->assessmentTypes()->pluck('assessment_type.id'),
            'teacher' => new TeacherSimpResource(User::find($this->idTeacher)),
        ];
    }
}
