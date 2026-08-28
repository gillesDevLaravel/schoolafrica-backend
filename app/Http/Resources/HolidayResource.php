<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
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
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'days_taken' => $this->days_taken,
            'reason' => $this->reason,
            'user' => UserSimpResource::make($this->user),
            'userApprove' => UserSimpResource::make($this->userApprove),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_by' => $this->updatedBy,
            'deleted_by' => $this->deletedBy,
        ];
    }
}
