<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentalMonitoringResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'comment' => $this->comment,
            'answer' => $this->answer,
            'idParent' => $this->idParent,
            'idStudent' => $this->idStudent,
            'idClasse' => $this->idClasse,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
        ];
    }
}
