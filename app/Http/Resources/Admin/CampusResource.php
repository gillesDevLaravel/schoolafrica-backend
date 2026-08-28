<?php

namespace App\Http\Resources\Admin;

use App\Models\School;
use Illuminate\Http\Resources\Json\JsonResource;

class CampusResource extends JsonResource
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
            'adresse' => $this->adresse,
            'school' => new SchoolResource(School::find($this->idSchool))
        ];
    }
}
