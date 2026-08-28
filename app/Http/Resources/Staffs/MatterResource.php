<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\OptionLevelResource;
use App\Models\OptionLevel;

class MatterResource extends JsonResource
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
            'code' => $this->code,
            'libelle' => $this->libelle,
            'name' => $this->name,
            'assessment' => $this->assessment,
            'description' => $this->description,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'levels' => $this->levels()->pluck('levels.id'),
            'optionLevel' => new OptionLevelResource(OptionLevel::find($this->idOptionLevel))
        ];
    }
}
