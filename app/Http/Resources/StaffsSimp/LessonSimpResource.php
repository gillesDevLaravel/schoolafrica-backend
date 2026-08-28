<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\Staffs\ChapterResource;
use App\Models\Chapter;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonSimpResource extends JsonResource
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
            'description' => $this->description,
//            'nbrSections' => $this->nbrSections,
//            'startDate' => $this->startDate,
//            'endDate' => $this->endDate,
            //'startDate' => date('d-m-Y', strtotime($this->startDate)),
            //'endDate' => date('d-m-Y', strtotime($this->endDate)),
//            'duration' => $this->duration,
//            'image' => $this->image,
//            'status' => $this->status,
//            'observation' => $this->observation,
//            'idSchool' => $this->idSchool,
//            'idSection' => $this->idSection,
            'chapter' => ChapterSimpResource::make(Chapter::find($this->idChapter)),
        ];
    }
}
