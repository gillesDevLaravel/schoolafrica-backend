<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnualDecisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $key = "bulletin.{$this->decision}";
        $translated = __($key);

        return [
            "idOptionLevel" => $this->idOptionLevel,
            "idUser" => $this->idUser,
            "decision" => $translated !== $key ? $translated : $this->decision,
        ];
    }
}
