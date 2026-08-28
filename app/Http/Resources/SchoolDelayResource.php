<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolDelayResource extends JsonResource
{
    /**
     * Transforme la ressource en tableau.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'hour'        => $this->hour,
            'date'        => $this->date,
            'description' => $this->description,
            'type'        => $this->type,

            // Relations
            'student'     =>  UserSimpResource::make($this->user),    // relation user() dans ton modèle
            'course'      =>  UserSimpResource::make($this->course),  // relation course() dans ton modèle

            // Tracking
            'created_by'  => $this->createdBy ? UserSimpResource::make($this->createdBy) : null,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
