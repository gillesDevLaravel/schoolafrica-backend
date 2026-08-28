<?php

namespace App\Http\Resources\StaffsSimp;

use Illuminate\Http\Resources\Json\JsonResource;

class CoefficientResourceSimple extends JsonResource
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
            'value' => $this->value
        ];
    }
}
