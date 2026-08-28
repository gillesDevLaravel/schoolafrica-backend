<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\ClassesSimpResource;
use App\Models\Classes;
use Illuminate\Http\Resources\Json\JsonResource;

class FeeUserSolvableResource extends JsonResource
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
            'classe' => ClassesSimpResource::make(Classes::find($this->idClasse)),
            'totalDejaPaye' => $this->totalDejaPaye,
            "resteAPayer" => $this->resteAPayer
        ];
    }
}
