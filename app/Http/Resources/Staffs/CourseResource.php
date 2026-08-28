<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\PieceResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StaffsSimp\MatterSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use App\Models\Classes;
use App\Models\User;
use App\Models\Matter;

class CourseResource extends JsonResource
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
            'hour' => $this->hour,
            'duration' => $this->duration,
            'day' => $this->day,
            'date' => $this->date,
            'document' => $this->document,
            'idLevel' => $this->idLevel,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
            'teacher' => new TeacherSimpResource(User::find($this->idTeacher)),
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
            'piece' => PieceResource::make($this->piece)
        ];
    }
}
