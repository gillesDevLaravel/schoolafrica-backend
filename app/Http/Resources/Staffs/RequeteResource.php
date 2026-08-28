<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\SchoolResource;
use App\Http\Resources\Admin\SectionResource;
use App\Http\Resources\Admin\UserAllResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\School;
use App\Models\Section;
use App\Models\TypeRequete;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RequeteResource extends JsonResource
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
            'categorie' => $this->categorie,
            'description' => $this->description,
            'typeRequete' => TypeRequeteResource::make(TypeRequete::find($this->idTypeRequete)),
            'statut' => $this->statut,
            'reponse' => $this->reponse,
            'user' => UserSimpResource::make(User::find($this->idUser)),
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_at' => $this->created_at,
//            'section' => SectionResource::make(Section::find($this->idSection)),
//            'school' => SchoolResource::make(School::find($this->idSchool)),
        ];
    }
}
