<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\PropositionQuestionSimpResource;
use App\Http\Resources\StaffsSimp\AssessmentSimpResource;
use App\Http\Resources\StaffsSimp\AssessmentTypeSimpResource;
use App\Models\Assessment;
use App\Models\AssessmentType;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireSimpResource extends JsonResource
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
            'idAssessment' => $this->idAssessment,
            'assessment' => AssessmentSimpResource::make(Assessment::find($this->idAssessment)),
            'idAssessmentType' => $this->idAssessmentType,
            'assessmentType' => AssessmentTypeSimpResource::make(AssessmentType::find($this->idAssessmentType)),
            'intitule' => $this->intitule,
            'notemax' => $this->notemax,
            'propositions' => PropositionQuestionSimpResource::collection($this->propositions)
        ];
    }
}
