<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkDoneResource extends JsonResource
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
            'description' => $this->description,
            'idStudent' => $this->idStudent,
            'idHomework' => $this->idHomework,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_at' => $this->created_at->format('Y-m-d'),
            'student' => InscriptionSimpResource::make($this->student),
            'homework' => HomeworkResource::make($this->homework)
        ];
    }
}
