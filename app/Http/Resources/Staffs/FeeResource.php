<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\TypeOfRecipeResource;
use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $section = Section::select('name')->whereId($this->idSection)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'deadline' => $this->deadline,
            'order' => $this->order,
            'required' => $this->required,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'section_name' => $section? $section->name : null,
            'idOptionLevel' => $this->idOptionLevel,
            'typeOfRecipe' => TypeOfRecipeResource::make($this->typeOfRecipe),
            'levels' => $this->levels()->pluck('levels.id'),
            'levels_name' => $this->levels()->pluck('levels.name'),
        ];
    }
}
