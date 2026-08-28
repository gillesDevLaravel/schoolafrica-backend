<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrimestreResource extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'numbering' => $this->numbering,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'semestre' => $this->semestre,
            'takenIntoAccount' => (bool) $this->takenIntoAccount,
        ];
    }
}
