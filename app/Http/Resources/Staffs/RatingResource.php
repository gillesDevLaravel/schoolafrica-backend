<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Assessment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StaffsSimp\AssessmentTypeSimpResource;
use App\Http\Resources\StaffsSimp\CoefficientResourceSimple;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Http\Resources\StaffsSimp\MatterSimpResource;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Coefficient;
use App\Models\Matter;
use App\Models\TypeEvaluation;
use App\Models\User;
use Illuminate\Support\Str;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $classe = Classes::find($this->idClasse);
        $coefficient = Coefficient::find($this->idCoeficient);
        $matter = Matter::find($this->idMatter);
        $typeEvaluation = TypeEvaluation::find($this->idTypeEvaluation);
        $assessmentType = AssessmentType::find($this->idAssessmentType);
        $student = User::find($this->idStudent);

        $ehm = @strtolower($typeEvaluation->name);

        return [
            'id' => $this->id,
            'value' =>  $this->value,
            'observation' => $this->observation,
            'notemax' => @$this->assessment->{Str::slug($typeEvaluation->name, "_")},
            'max' => $this->$ehm,
            'classe' => $classe ? new ClassesSimpResource($classe) : null,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'coeficient' => $coefficient ? new CoefficientResourceSimple($coefficient) : null,
            'matter' => $matter ? new MatterSimpResource($matter) : null,
            'idAssessment' => $this->idAssessment,
            //'assessment' => $this->assessment,
            'typeEvaluation' => $typeEvaluation ? new TypeEvaluationResource($typeEvaluation) : null,
            'assessmentType' => $assessmentType ? new AssessmentTypeSimpResource($assessmentType) : null,
            'student' => $student ? new InscriptionSimpResource($student) : null,
            'idTeacher' => $this->idTeacher
        ];
    }


}
