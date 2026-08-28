<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\StaffsSimp\MatterSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Classes;
use App\Models\Matter;

class CourseSimpResource extends JsonResource
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
            'date' => $this->date,
            'duration' => $this->duration,
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
           // ajouter la classe lier a la course
           'classe' => new ClassesSimpResource(Classes::find($this->idClasse)),
        ];
    }
}
