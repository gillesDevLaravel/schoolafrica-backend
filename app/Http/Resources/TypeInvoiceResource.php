<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\SchoolSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeInvoiceResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'category' => $this->category,
            'school_id' => SchoolSimpResource::make($this->school)
        ];
    }
}
