<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'type'        => $this->type,
            'description' => $this->description,
            'date'        => $this->date,
            'participants' => $this->participants,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'created_by'  => UserSimpResource::make($this->createdBy),
        ];
    }
}
