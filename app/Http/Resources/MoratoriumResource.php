<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoratoriumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'reason' => $this->reason,
            'note_comptable' => $this->note_comptable,
            'note_fondatrice' => $this->note_fondatrice,
            'status' => $this->status,

            // Relations
            'user' => UserSimpResource::make($this->user),
            'author' => UserSimpResource::make($this->author),
            'userApprove' => UserSimpResource::make($this->userApprove),

            // dates
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
