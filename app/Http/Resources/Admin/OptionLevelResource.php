<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Models\Filiere;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Level;

class OptionLevelResource extends JsonResource
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
            'lang' => $this->lang,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'levels' => $this->levels()->pluck('levels.id'),
            'filiere' => FiliereResource::make(Filiere::find($this->idFiliere)),
        ];
    }
}
