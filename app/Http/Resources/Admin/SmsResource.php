<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AdminSimp\SchoolSimpResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SmsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $users = explode(',', $this->idUsers);

        return [
            'id' => $this->id,
            'message' => $this->message,
            'status' => $this->status,
            'users' => UserSimpResource::collection(User::whereIn('id', $users)->get()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => UserSimpResource::make($this->author),
            'school' => SchoolSimpResource::make($this->school),
            'section' => SchoolSimpResource::make($this->section),
        ];
    }
}
