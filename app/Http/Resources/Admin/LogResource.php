<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'description' => $this->description,
            'date' => $this->created_at->format('d M Y H:i'),
            'idUser' => $this->idUser,
            'user' => UserSimpResource::make($this->user),
            'idStudent' => $this->idStudent,
            'student' => UserSimpResource::make($this->student),
        ];
    }
}
