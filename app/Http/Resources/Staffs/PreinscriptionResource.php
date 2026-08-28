<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;

class PreinscriptionResource extends JsonResource
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
            'idRole' => $this->idRole,
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'birthday' => $this->birthday,
            'adresse' => $this->adresse,
            'scholar_level' => $this->scholar_level,
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'idOptionLevel' => $this->idOptionLevel,
            'idParent' => $this->idParent,
            'username' => $this->username,
            'password' => $this->password,
            'photo' => $this->photo,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
        ];
    }
}
