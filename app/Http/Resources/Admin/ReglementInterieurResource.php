<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ReglementInterieurResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'image' => $this->image,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted' => (bool) $this->deleted,
            'deleted_by' => $this->deleted_by,
        ];
    }
}
