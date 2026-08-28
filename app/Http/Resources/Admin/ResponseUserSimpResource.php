<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseUserSimpResource extends JsonResource
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
            'idUser' => $this->idUser,
            'idQuestionnaire' => $this->idQuestionnaire,
            'idAssessment' => $this->idAssessment,
            'response' => $this->response,
            'note' => $this->note,
            'status' => $this->status,
        ];
    }
}
