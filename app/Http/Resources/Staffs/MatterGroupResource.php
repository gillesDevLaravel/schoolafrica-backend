<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class MatterGroupResource extends JsonResource
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
            'matter' => $this->matters()->pluck('matter.id'),
            'levels' => $this->levels()->pluck('levels.id'),
            'idOptionLevel' => $this->idOptionLevel
        ];
    }
}
