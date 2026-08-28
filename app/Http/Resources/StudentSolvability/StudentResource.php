<?php

namespace App\Http\Resources\StudentSolvability;

use App\Http\Resources\AnnualDecisionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $photoPath = public_path("public/profil/{$this->photo}");

        $key = "bulletin.{$this->annualDecision}";
        $translated = __($key);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'photo' => File::exists($photoPath) ? asset("public/profil/{$this->photo}") : null,
            'matricule' => $this->matricule, // Identifiant unique si disponible
            'situation' => $this->situation, // Statut de l'élève (ex : nouveau, redoublant)
            'bourse' => $this->whenLoaded('bourse'), // Inclure la bourse si chargée
            'annualDecision' => $translated !== $key ? $translated : $this->annualDecision,
            'annualDecisions' => AnnualDecisionResource::collection($this->annualDecisions),
        ];
    }
}
