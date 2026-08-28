<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\TypeOfRecipeResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Models\Level;

class PensionResource extends JsonResource
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
            'price' => $this->price,
            'nbrTranche' => $this->nbrTranche,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'typeOfRecipe' => TypeOfRecipeResource::make($this->typeOfRecipe),
            'level' => new LevelSimpResource(Level::find($this->idLevel))
        ];
    }
}
