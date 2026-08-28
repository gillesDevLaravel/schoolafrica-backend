<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use  App\Models\User;
use  App\Models\Package;

class EstablishmentResource extends JsonResource
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
            'ministry' => $this->ministry,
            'region' => $this->region,
            'department' => $this->department,
            'rib' => $this->rib,
            'banque' => $this->banque,
            'om' => $this->om,
            'cnps' => $this->cnps,
            'phone' => $this->phone,
            'mobile_money_number' => $this->mobile_money_number,
            'email' => $this->email,
            'website' => $this->website,
            'logo' => $this->logo,
            'cle' => $this->cle,
            'route' => $this->route,
            'pay_om_fees' => (boolean)$this->pay_om_fees,
            'code_couleur' => $this->code_couleur,
            'country' => $this->country,
            'founders' => $this->users()->pluck('user_id'),
            'administrative_status' => $this->administrative_status,
            'religious_status' => $this->religious_status,
            'founder' => new UserResource(User::find($this->idFounder)),
            'prefetetude' => new UserResource(User::find($this->idPrefetEtude)),
            'secretaire' => new UserResource(User::find($this->idSecretaire)),
            'package' => new PackageResource(Package::find($this->idPackage)),
        ];
    }
}
