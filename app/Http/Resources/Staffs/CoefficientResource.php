<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Http\Resources\StaffsSimp\MatterSimpResource;
use App\Models\Level;
use App\Models\Matter;

class CoefficientResource extends JsonResource
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
            'value' => $this->value,
            'description' => $this->description,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'levels' => $this->levels()->pluck('levels.id'),
            'idOptionLevel' => $this->idOptionLevel
        ];
    }
}
