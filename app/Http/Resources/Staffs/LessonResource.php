<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Staffs\ChapterResource;
use App\Models\Chapter;

class LessonResource extends JsonResource
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
            'nbrSections' => $this->nbrSections,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            //'startDate' => date('d-m-Y', strtotime($this->startDate)),
            //'endDate' => date('d-m-Y', strtotime($this->endDate)),
            'duration' => $this->duration,
            'image' => $this->image,
            'status' => $this->status,
            'observation' => $this->observation,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'chapter' => new ChapterResource(Chapter::find($this->idChapter)),
        ];
    }
}
