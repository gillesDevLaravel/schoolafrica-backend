<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'type' => $this->type,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'permissions' => $this->permissions->pluck('id'),
            'permissions_description' => $this->permissions->pluck('description'),
        ];
    }
}
