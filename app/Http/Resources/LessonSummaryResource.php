<?php

namespace App\Http\Resources;

use App\Http\Resources\Staffs\LessonResource;
use App\Http\Resources\StaffsSimp\LessonSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonSummaryResource extends JsonResource
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
            'date' => $this->date,
            'created_at' => $this->created_at,
            'images' => $this->images ? explode('|', $this->images) : [],
            'lesson' => LessonSimpResource::make($this->lesson),
            'teacher' => TeacherSimpResource::make($this->teacher),
        ];
    }
}
