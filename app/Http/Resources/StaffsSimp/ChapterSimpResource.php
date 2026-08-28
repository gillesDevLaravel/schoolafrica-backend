<?php

namespace App\Http\Resources\StaffsSimp;

use App\Http\Resources\Staffs\ModuleResource;
use App\Models\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterSimpResource extends JsonResource
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
//            'module' => ModuleSimpResource::make($this->module), //new ModuleSimpResource(Module::find($this->idModule)),
            'matter_name' => $this->module->matter->name ?? null,
            'classe_name' => $this->module->matter->courses[0]->classe->name ?? null,
        ];
    }
}
