<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeOfRecipeProgressResource extends JsonResource
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
            "id" => $this['id'],
            "name" => $this['name'],
            "code" => $this['code'],
            "sub_total_amount" => $this['sub_total_amount'],
        ];
    }
}
