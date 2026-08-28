<?php

namespace App\Http\Resources\AdminSimp;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSimpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $annualDecision = isset($this->annualDecision) ? $this->annualDecision : null;
        $translated = $annualDecision ? __("bulletin.{$annualDecision}") : null;

        // Vérification sécurisée des rôles
        $roleId = null;
        if (isset($this->roles) && $this->roles && method_exists($this->roles, 'first')) {
            $firstRole = $this->roles->first();
            $roleId = $firstRole ? $firstRole->id : null;
        }

        return [
            'id' => $this->id ?? null,
            'name' => $this->name ?? null,
            'photo' => $this->photo ?? null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'device_key' => $this->device_key ?? null,
            'cni' => $this->cni ?? null,
            'idBourse' => $this->idBourse ?? null,
            'isBourseUsed' => isset($this->isBourseUsed) ? (bool)$this->isBourseUsed : false,
            'idRole' => $roleId,
            'annualDecision' => $translated ?: $annualDecision,
        ];
    }
}

