<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyReportResource extends JsonResource
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
            'date' => $this->date ? date('Y-m-d', strtotime($this->date)) : null,
            'description' => $this->description,
            'comments' => $this->comments,
            'user' => $this->user,
            'creator' => $this->creator,
            'created_at' => $this->created_at ? date('Y-m-d H:i:s', strtotime($this->created_at)) : null,
        ];
    }
}
