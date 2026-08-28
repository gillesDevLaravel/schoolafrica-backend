<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ProjectSimpResource;
use App\Http\Resources\StaffsSimp\StaffSimpResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'due_date' => $this->due_date,
            'priority' => $this->priority,
            'status' => $this->status,
            'duree_mise' => $this->duree_mise,
            'estimation' => $this->estimation,
            'observation' => $this->observation,
            'idProject' => $this->idProject,
//            'project' => ProjectSimpResource::make(Project::find($this->idProject)),
            'user' => new StaffSimpResource(User::find($this->idUser)),
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
        ];
    }
}
