<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseUserMarkExamResource extends JsonResource
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
            'intitule' => $this->intitule,
            'reponse' => $this->reponse,
            'notemax' => $this->notemax,
            'proposition_user' => ResponseUserSimpResource::make($this->proposition_user),
            'propositions' => PropositionQuestionResource::make($this->propositions),
        ];
    }
}
