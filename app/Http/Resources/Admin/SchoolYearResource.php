<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolYearResource extends JsonResource
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
            'label' => $this->label,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'previousAcademicYear' => $this->previousAcademicYear,
            'created_at' => $this->created_at ? $this->created_at->format("Y-m-d") : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format("Y-m-d") : null,
            'created_by' => UserSimpResource::make($this->createdBy),
            'updated_by' => UserSimpResource::make($this->updatedBy),
            'deleted_by' => UserSimpResource::make($this->deletedBy)
        ];
    }
}
