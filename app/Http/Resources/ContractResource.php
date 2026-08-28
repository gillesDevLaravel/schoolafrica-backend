<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'reference' => $this->reference,
            'user' => $this->user ? $this->user->only(['id', 'name']) : null,
            'userApprove' => UserSimpResource::make($this->userApprove),
            'type' => $this->type,
            'description' => $this->description,
            'start_date' => $this->start_date->format('d-m-Y'), // Formatage de la date
            'duration' => $this->duration, //en mois
            'working_hours' => $this->horaire,
            'position' => $this->position,
            'gross_salary' => (float) $this->gross_salary, // Conversion en float
            'status' => $this->status,
            'service_benefits' => $this->service_benefits,
            'bonus' => $this->bonus,
            'number_days_off' => $this->number_days_off,
            'file' => $this->file_link,
            'created_by' => $this->createdBy ? $this->createdBy->only(['id', 'name']) : null,
            'updated_by' => $this->updatedBy ? $this->updatedBy->only(['id', 'name']) : null,
            'deleted_by' => $this->deletedBy ? $this->deletedBy->only(['id', 'name']) : null,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
