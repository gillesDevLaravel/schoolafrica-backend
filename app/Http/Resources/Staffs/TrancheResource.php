<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StaffsSimp\PensionSimpResource;
use App\Models\Pension;

class TrancheResource extends JsonResource
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
            'price' => $this->price,
            'deadline' => $this->deadline,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'pension' => new PensionSimpResource(Pension::find($this->idPension)),
        ];
    }
}
