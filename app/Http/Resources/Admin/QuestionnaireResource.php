<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\StaffsSimp\AssessmentSimpResource;
use App\Http\Resources\StaffsSimp\AssessmentTypeSimpResource;
use App\Models\Assessment;
use App\Models\AssessmentType;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireResource extends JsonResource
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
            'intitule' => $this->intitule,
            'reponse' => $this->reponse,
            'notemax' => $this->notemax,
            'deleted' => $this->deleted,
            'assessment' => AssessmentSimpResource::make(Assessment::find($this->idAssessment)),
            'assessmentType' => AssessmentTypeSimpResource::make(AssessmentType::find($this->idAssessmentType)),
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
