<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamStudentResource extends JsonResource
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
            'idAssessmentType' => $this->idAssessmentType,
            'idUser' => $this->idUser,
            'statut' => $this->statut,
            'finished' => $this->finished,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'deleted' => $this->deleted,
        ];
    }
}
