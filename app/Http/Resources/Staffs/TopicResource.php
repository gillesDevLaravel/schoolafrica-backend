<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Staffs\LessonResource;
use App\Models\Lesson;

class TopicResource extends JsonResource
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
            'startDate' => date('d-m-Y', strtotime($this->startDate)),
            'endDate' => date('d-m-Y', strtotime($this->endDate)),
            'duration' => $this->duration,
            'status' => $this->status,
            'observation' => $this->observation,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'lesson' => new LessonResource(Lesson::find($this->idLesson)),
        ];
    }
}
