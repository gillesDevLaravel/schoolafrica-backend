<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PermissionUserResource extends JsonResource
{
    /**
     * Transforme la ressource en tableau.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        // Convertir les dates en objets Carbon
        $depart = Carbon::parse($this->depart);
        $retour = Carbon::parse($this->retour);

        // Calculer la durée entre les deux dates
        $duree = $depart->diff($retour);

        // Retourner les données
        return [
            "id" => $this->id,
            "raison" => $this->raison,
            "depart" => $this->depart,
            "retour" => $this->retour,
            "duration" => $this->duration,
            "user" => User::select('id', 'name')->find($this->idUser),
            "userApprove" => User::select('id', 'name')->find($this->idUserApprove),
            "updated_by" => $this->updated_by ? User::select('id', 'name')->find($this->updated_by) : null,
            "deleted_by" => $this->deleted_by ? User::select('id', 'name')->find($this->deleted_by) : null,
            "status" => $this->statut,
            "comments" => $this->comments,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

            // Durée calculée sous forme de chaîne lisible
            //"duree" => $duree->format('%d jours %h heures %i minutes') // Format lisible : jours, heures, minutes
        ];
    }
}
