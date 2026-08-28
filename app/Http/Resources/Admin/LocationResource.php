<?php

namespace App\Http\Resources\Admin;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'idBook' => BookResource::make(Book::find($this->idBook)),
            'idUser' => UserResource::make(User::find($this->idUser)),
            'date_sortie' => $this->date_sortie,
            'date_retour' => $this->date_retour,
            'status' => $this->status,
            'reason' => $this->reason,
            'observation' => $this->observation,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
        ];
    }
}
