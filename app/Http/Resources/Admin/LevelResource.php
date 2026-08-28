<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\CycleSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Cycle;

class LevelResource extends JsonResource
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
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'cycle' => new CycleSimpResource(Cycle::find($this->idCycle)),
        ];
    }
}
