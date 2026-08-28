<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Http\Resources\AdminSimp\SectionSimpResource;
use App\Http\Resources\StaffsSimp\TeacherSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Level;
use App\Models\Section;
use App\Models\User;

class ClassesResource extends JsonResource
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
            'style' => $this->style,
            'photo' => @$this->photo,
            'teacher' => $this->idTeacher,
            'teacherTitulaire' => new TeacherSimpResource(User::find($this->idTeacher)),
            'idSchool' => $this->idSchool,
            'idSection' => new SectionSimpResource(Section::find($this->idSection)),
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'teacherslist' => $this->users()->get(),
            'teachers' => $this->users()->pluck('users.id'),
            'idOptionLevel' => $this->idOptionLevel,
            'nextClasses' => ClassesSimpResource::collection($this->nextClasses),
            'previousClasses' => ClassesSimpResource::collection($this->previousClasses),
        ];
    }
}
