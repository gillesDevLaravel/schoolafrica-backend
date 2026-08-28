<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\StaffsSimp\CourseSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use App\Models\Classes;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PresenceTeacherResource extends JsonResource
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
            'teacher' => new TeacherSimpResource($this->teacher),
//            'teacher' => new TeacherSimpResource(User::find($this->idTeacher)),
            'date' => $this->date,
            'hour' => $this->hour,
            'type' => $this->type,
            'arrivalTime' => $this->arrivalTime,
            'departureTime' => $this->departureTime,
            'course' => new CourseSimpResource(Course::find($this->idCourse)),
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'raison' => $this->raison,
            'savingType' => $this->savingType,
            'total_hours_individual' => $this->total_hours_individual ?? null,
            'total_hours_global' => $this->total_hours_global ?? null,
            'scanPerCourse' => (bool) $this->scanPerCourse
        ];
    }
}
