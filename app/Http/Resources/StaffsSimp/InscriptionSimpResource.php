<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Classes;
use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionSimpResource extends JsonResource
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
            'matricule' => $this->matricule,
            'idLevel' => $this->idLevel,
            'classe' => new ClassesSimpResource(Classes::find($this->idClasse))
        ];
    }
}
