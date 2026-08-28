<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemoResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'type'        => $this->type,
            'date'        => $this->date,
            'image'        => $this->image,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'created_by'  => $this->created_by,
        ];
    }
}
