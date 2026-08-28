<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\Staffs\MatterResource;
use App\Http\Resources\Staffs\ProgressionResource;
use App\Http\Resources\Staffs\TeacherResource;
use App\Models\Matter;
use App\Models\Progression;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleSimpResource extends JsonResource
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
            'matter' => new MatterSimpResource(Matter::find($this->idMatter)),
//            'teacher' => new TeacherSimpResource(User::find($this->idTeacher)),
//            'progression' => new ProgressionResource(Progression::find($this->idProgression)),
//            'idTranche' => $this->idTranche
        ];
    }
}
