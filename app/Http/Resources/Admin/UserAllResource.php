<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Bourse;
use App\Models\Classes;
use App\Models\MobileBuildVersion;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $key = "bulletin.{$this->annualDecision}";
        $translated = __($key);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'scholar_type' => $this->scholar_type,
            'firstname' => $this->firstname,
            'placeofbirth' => $this->placeofbirth,
            'situation' => $this->situation,
            'repeater' => $this->repeater,
            'email' => $this->email,
            'whatsapp_number' => $this->whatsapp_number,
            //'password' => $this->password,
            'username' => $this->username,
            'phone' => $this->phone,
            'adresse' => $this->adresse,
            'gender' => $this->gender,
            'adresse_2' => $this->adresse_2,
            'adresse_tutor' => $this->adresse_tutor,
            'gender_2' => $this->gender_2,
            'gender_tutor' => $this->gender_tutor,
            'country' => $this->country,
            'city' => $this->city,
            'fit' => $this->fit,
            'desease' => $this->desease,
            'matricule' => $this->matricule,
            'photo' => $this->photo,
            'signature' => $this->signature,
            'profession' => $this->profession,
            'bank_name' => $this->bank_name,
            'bank_rib' => $this->bank_rib,
//            'number_days_off' => $this->number_days_off,
            'birthday' => $this->birthday,
            'device_key' => $this->device_key,
            'cni' => $this->cni,
            'build_number' => $this->build_number,
            'nationality' => $this->nationality,
            'codeun' => $this->codeun,
            'codedeux' => $this->codedeux,
            'salary' => $this->salary,
            'hourlyPrice' => $this->hourlyPrice,
            'grade' => $this->grade,
            'anciennete' => $this->anciennete,
            'num_cnps' => $this->num_cnps,
            'niu' => $this->niu,
            'agence' => $this->agence,
            'service' => $this->service,
            'categorie' => $this->categorie,
            'num_dipe' => $this->num_dipe,
            'date_embauche' => $this->date_embauche,
            'idMatter' => $this->idMatter,
            'idParent' => $this->idParent,
            'idLevel' => $this->idLevel,
            'idOptionLevel' => $this->idOptionLevel,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'idCycle' => $this->idCycle,
            'idClasse' => $this->idClasse,
            'idClasse2' => $this->idClasse2,
            'old_classe' => $this->old_classe,
            'classe2' => new  ClassesSimpResource(Classes::find($this->idClasse2)),
            'idClassePrincipal' => $this->idClassePrincipal,
            'bourse' => BourseResource::make(Bourse::find($this->idBourse)),
            'isBourseUsed' => (bool)$this->isBourseUsed,
            'deleted' => $this->deleted,
            'mother' => $this->mother,
            'tutor' => $this->tutor,
            'phone_2' => $this->phone_2,
            'phone_3' => $this->phone_3,
            'phone_4' => $this->phone_4,
            'phone_5' => $this->phone_5,
            'phone_6' => $this->phone_6,
            'observation' => $this->observation,
            'idRole' => $this->idRole,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'permissions' => User::find($this->id)->getPermissionsViaRoles()->pluck('name'), // je sais pas pourquoi mais $this out simplement n'a pas la méthode getPermissionsViaRoles
            'annualDecision' => $translated !== $key ? $translated : $this->annualDecision,
        ];
    }
}
