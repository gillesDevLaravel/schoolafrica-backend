<?php

namespace App\Http\Resources\Staffs;

use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteFraisResource extends JsonResource
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
            'idUser' => $this->idUser,
            'user' => UserSimpResource::make($this->user),
            'libelle' => $this->libelle,
            'description' => $this->description,
            'idUserApprove' => $this->idUserApprove,
            'userApprove' => UserSimpResource::make(User::find($this->idUserApprove)),
            'date' => $this->date,
            'amount' => $this->amount,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted' => (bool) $this->deleted,
            'deleted_by' => $this->deleted_by,
        ];
    }
}
