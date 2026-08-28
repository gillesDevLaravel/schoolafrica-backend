<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\LevelResource;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'type' => $this->type,
            'parentalContribution' => $this->parentalContribution,
            'budget' => $this->budget,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'classes' => !is_null($this->classes) ? array_map('intval', explode(',', $this->classes)) : null,
            'levels' => !is_null($this->levels) ? array_map('intval', explode(',', $this->levels)) : null,
//            'levels' => LevelResource::collection(Level::whereIn('id', explode(',', $this->levels))->get()),
        ];
    }
}
