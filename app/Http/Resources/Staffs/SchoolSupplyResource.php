<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolSupplyResource extends JsonResource
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
            'image' => $this->image,
            'description' => $this->description,
            'supply' => $this->supply,
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'idOptionLevel' => $this->idOptionLevel,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'classes' => ClassesSimpResource::collection($this->classes),
        ];
    }
}
