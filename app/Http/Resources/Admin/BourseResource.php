<?php

namespace App\Http\Resources\Admin;

use App\Models\School;
use App\Models\Section;
use Illuminate\Http\Resources\Json\JsonResource;

class BourseResource extends JsonResource
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
            'description' => $this->description,
            'amount' => $this->amount,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
        ];
    }
}
