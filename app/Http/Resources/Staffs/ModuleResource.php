<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Staffs\ProgressionResource;
use App\Models\Matter;
use App\Models\Progression;
use App\Models\User;

class ModuleResource extends JsonResource
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
            'nbrChapters' => $this->nbrChapters,
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
            'matter' => new MatterResource(Matter::find($this->idMatter)),
            'teacher' => new TeacherResource(User::find($this->idTeacher)),
            'progression' => new ProgressionResource(Progression::find($this->idProgression)),
            'idTranche' => $this->idTranche
        ];
    }
}
