<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificatTransfertResource extends JsonResource
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
            'user' => UserSimpResource::make(User::find($this->idStudent)),
            'to' => $this->to,
            'on' => $this->on,
            'academic_year' => $this->academic_year,
            'created_by' => $this->created_by,
//            'author' => UserSimpResource::make(User::find($this->created_by)),
        ];
    }
}
