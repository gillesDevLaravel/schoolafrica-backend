<?php

namespace App\Http\Resources\StudentSolvability;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
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
//            'idLevel' => $this->idLevel,
//            'idSchool' => $this->idSchool,
//            'idSection' => $this->idSection,
//            //'idTeacher' => $this->idTeacher,
        ];
    }
}
