<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SanctionResource extends JsonResource
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
            'type' => $this->type,
            'typeUser' => $this->typeUser,
            'description' => $this->description,
            'reasons' => $this->reasons,
            'student' => new InscriptionSimpResource(User::find($this->idUser)),
            'classe' => ClassesSimpResource::make(Classes::find(User::find($this->idUser)->idClasse)),
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_at' => $this->created_at,
            'creator' => UserSimpResource::make($this->creator),
        ];
    }
}
