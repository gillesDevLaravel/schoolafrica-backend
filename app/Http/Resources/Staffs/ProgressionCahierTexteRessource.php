<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Classes;

class ProgressionCahierTexteRessource extends JsonResource
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
            'nbrModules' => $this->nbrModules,
            'status' => $this->status,
            'idClasse' => $this->idClasse,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'classes' => $this->classes()->pluck('classes_id')
        ];
    }
}