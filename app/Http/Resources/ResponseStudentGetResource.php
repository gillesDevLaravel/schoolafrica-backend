<?php

namespace App\Http\Resources;

use App\Models\Matter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseStudentGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $assessmentType = $this->question->assessment->assessmentTypes->first();
        $assessment = $this->question->assessment;
        $user = $this->user;
        $question = $this->question;

        return [
            'id' => $this->id,
            'response' => $this->response,
            'note' => $this->note,

            'assessment' => [
                'idAssessment' => $assessment->id,
                'matiere' => Matter::find($assessment->idMatter)["name"] ?? null,
            ],
            'assessment_type' => [
                'id' => $assessmentType->id ?? null,
                'name' => $assessmentType->name ?? null,
            ],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'question' => [
                'id' => $question->id,
                'intitule' => $question->intitule,
            ],
        ];
    }
}
