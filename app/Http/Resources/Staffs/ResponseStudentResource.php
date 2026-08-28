<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseStudentResource extends JsonResource
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
//            'deleted' => $this->deleted,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'updated_by' => $this->updated_by,
//            'deleted_by' => $this->deleted_by,
        ];
    }
}
