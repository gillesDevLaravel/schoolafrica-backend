<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
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
            'montant_retrait_brut' => $this->montant_retrait_brut,
            'montant_retrait_net' => $this->montant_retrait_net,
            'frais_bancaire' => $this->frais_bancaire,
            'status' => $this->status,
            'type' => $this->type,
            'rib' => $this->rib,
            'mode_retrait' => $this->mode_retrait,
            'user' => new UserSimpResource(User::find($this->idUser)),
            'numero_retrait' => $this->numero_retrait,
            'date' => date('d-m-Y', strtotime($this->date)),
            'school' => new SchoolSimpResource(School::find($this->idSchool)),
            'idSection' => $this->idSection
        ];
    }
}
