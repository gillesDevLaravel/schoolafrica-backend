<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class FiliereResource extends JsonResource
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
            'cycles' => $this->cycles()->pluck('cycles.id')->toArray(),
            'cyclesnames' => $this->cycles()->pluck('cycles.name')->toArray(),
            'idSection' => $this->idSection,
            'idSchool' => $this->idSchool,
        ];
    }
}
