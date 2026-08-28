<?php

namespace App\Http\Resources\Staffs;

use App\Models\Trimestre;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentTypeResource extends JsonResource
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
            'numbering' => $this->numbering,
            'pourcentage' => $this->pourcentage,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'notes_completed' => (bool) $this->notes_completed,
            'trimestre' => new TrimestreResource(Trimestre::find($this->idTrimestre)),
            'idSchool' => $this->idSchool,
            'takenIntoAccount' => (bool) $this->takenIntoAccount,
            'idSection' => $this->idSection,
        ];
    }
}
