<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\BookResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Staffs\MatterResource;
use App\Http\Resources\Admin\ClassesResource;
use App\Models\Classes;
use App\Models\Matter;
use App\Models\User;

class HomeworkResource extends JsonResource
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
            'deadline' => $this->deadline,
            'description' => $this->description,
            'canSubmitHomework' => ($this->deadline > NOW()),
            'answer' => $this->answer,
            'status' => $this->status,
            'classe' => new ClassesResource(Classes::find($this->idClasse)),
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'matter' => new MatterResource(Matter::find($this->idMatter)),
            'teacher' => new TeacherResource(User::find($this->idTeacher)),
            'book' => BookResource::make($this->book)
        ];
    }
}
