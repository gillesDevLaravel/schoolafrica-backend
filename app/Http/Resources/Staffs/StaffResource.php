<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\CycleSimpResource;
use App\Http\Resources\AdminSimp\LevelSimpResource;
use App\Http\Resources\AdminSimp\RoleSimpResource;
use App\Models\Cycle;
use App\Models\Level;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class StaffResource extends JsonResource
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
            'role' => new RoleSimpResource(Role::find($this->idRole)),
            'nationality' => $this->nationality,
            'city' => $this->city,
            'adresse' => $this->adresse,
            'photo' => $this->photo,
            'signature' => $this->signature,
            'profession' => $this->profession,
            'bank_name' => $this->bank_name,
            'bank_rib' => $this->bank_rib,
//            'number_days_off' => $this->number_days_off,
            'country' => $this->country,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone2' => $this->phone_2,
            'whatsapp_number' => $this->whatsapp_number,
            'gender' => $this->gender,
            'cnps' => $this->num_cnps,
            'cat' => $this->cat,
            'ech' => $this->ech,
            'hiring_date' => $this->hiring_date,
            'anciennete' => $this->anciennete,
            'niu' => $this->niu,
            'scholar_level' => $this->scholar_level,
            'username' => $this->username,
            'birthday' => $this->birthday,
//            'password' => $this->password,
            'grade' => $this->grade,
            'anciennete' => $this->anciennete,
            'level' => new LevelSimpResource(Level::find($this->idLevel)),
            'cycle' => new CycleSimpResource(Cycle::find($this->idCycle)),
            'cni' => $this->cni,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }
}
