<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;

class PensionSimpResource extends JsonResource
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
            'level' => new LevelSimpResource(Level::find($this->idLevel))
        ];
    }
}
