<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Classes;

class ProgressionResource extends JsonResource
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
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
            'classes' => $this->classes()->pluck('classes_id')
        ];
    }
}
