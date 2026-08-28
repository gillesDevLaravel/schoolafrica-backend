<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\School;
use App\Models\User;

class SectionResource extends JsonResource
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
            'lang' => $this->lang,
//            'idPrincipal' => $this->idPrincipal,
            'principal' => new UserResource(User::find($this->idPrincipal)),
            'school' => new SchoolResource(School::find($this->idSchool))
        ];
    }
}
