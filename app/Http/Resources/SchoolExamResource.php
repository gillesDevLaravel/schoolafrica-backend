<?php

namespace App\Http\Resources;

use App\Models\AssessmentType;
use App\Models\Matter;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolExamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'description' => $this->description,
            'answer' => $this->answer,
            'idOptionLevel' => $this->idOptionLevel,
            'matter' => Matter::find($this->idMatter),
            'assessmentType' => AssessmentType::find($this->idAssessmentType),
            'classes' => $this->classes()->pluck('classes.id'),
            'classesName' => $this->classes()->pluck('classes.name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
           
        ];
    }
}
