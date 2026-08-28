<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            'nationality' => $this->nationality,
            'city' => $this->city,
            'adresse' => $this->adresse,
            'mother' => $this->mother,
            'tutor' => $this->tutor,
            'phone_2' => $this->phone_2,
            'phone_3' => $this->phone_3,
            'phone_4' => $this->phone_4,
            'phone_5' => $this->phone_5,
            'phone_6' => $this->phone_6,
            'observation' => $this->observation,
            'photo' => $this->photo,
            'country' => $this->country,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp_number' => $this->whatsapp_number,
            'gender' => $this->gender,
            'adresse_2' => $this->adresse_2,
            'adresse_tutor' => $this->adresse_tutor,
            'gender_2' => $this->gender_2,
            'gender_tutor' => $this->gender_tutor,
            'scholar_level' => $this->scholar_level,
            'username' => $this->username,
            'birthday' => $this->birthday,
//            'password' => $this->password,
            'cni' => $this->cni,
            'idRole' => $this->idRole,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'niu' => $this->niu,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }
}
