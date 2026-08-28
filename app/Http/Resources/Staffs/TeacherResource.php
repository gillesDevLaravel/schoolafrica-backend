<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Http\Resources\StaffsSimp\MatterSimpResource;
use App\Models\Classes;
use App\Models\Matter;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'country' => $this->country,
            'city' => $this->city,
            'salary' => $this->salary,
            'hourlyPrice' => $this->hourlyPrice,
            'grade' => $this->grade,
            'anciennete' => $this->anciennete,
            'cnps' => $this->num_cnps,
            'scholar_level' => $this->scholar_level,
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
            'classes' => $this->classes()->pluck('classes.id'),
            'classesName' => $this->classes()->pluck('classes.name'),
            'email' => $this->email,
            'phone' => $this->phone,
            'phone2' => $this->phone_2,
//            'whatsapp_number' => $this->whatsapp_number,
            'username' => $this->username,
//            'password' => $this->password,
            'photo' => $this->photo,
            'signature' => $this->signature,
            'profession' => $this->profession,
            'adresse' => $this->adresse,
            'birthday' => $this->birthday,
            'cni' => $this->cni,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'bank_name' => $this->bank_name,
            'bank_rib' => $this->bank_rib,
            'cat' => $this->cat,
            'ech' => $this->ech,
            'hiring_date' => $this->hiring_date,
            'niu' => $this->niu,
            'idClassePrincipal' => ClassesSimpResource::make(Classes::find($this->idClassePrincipal)),
        ];
    }
}
