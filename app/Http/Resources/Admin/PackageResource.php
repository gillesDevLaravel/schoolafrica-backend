<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;


class PackageResource extends JsonResource
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
            'level' => $this->level,
            'price' => $this->price,
            'duration' => $this->duration,
            'description' => $this->description,
            'website' => $this->website,
            'mail_pro' => $this->mail_pro,
            'status' => $this->status,
        ];
    }
}
