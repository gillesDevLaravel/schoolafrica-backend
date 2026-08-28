<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'photo' => $this->photo,
            'status' => $this->status,
            'auteur' => $this->auteur,
            'editeur' => $this->editeur,
            'date_publication' => $this->date_publication,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'idLevel' => $this->idLevel,
        ];
    }
}
