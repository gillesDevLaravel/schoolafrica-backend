<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
//            'password' => $this->pass,
            'country' => $this->country,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'nationality' => $this->nationality,
               'status' => $this->status,      
            'repeater' => $this->repeater,   
        ];
    }
}
