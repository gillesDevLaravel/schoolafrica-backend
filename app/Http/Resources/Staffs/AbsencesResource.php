<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsencesResource extends JsonResource
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
            'image' => $this->image,
            'type' => $this->type,
            'date' => $this->date,
            'periode' => $this->periode,
            'justification' => $this->justification,
            'idClasse' => $this->idClasse,
            'course' => new CourseResource($this->whenLoaded('course', $this->course)),
            'is_justified' => $this->is_justified,
            'idAssessmentType' => $this->idAssessmentType,
            'teacher' => new TeacherSimpResource($this->whenLoaded('teacher', $this->teacher)),
            'student' => new InscriptionSimpResource($this->whenLoaded('student', $this->student)),
            'created_at' => $this->created_at,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'sum_duration_justifie' => $this->sum_duration_justifie,
            //'sum_duration_not_justifie' => $this->sum_duration_not_justifie,
        ];
    }
}
