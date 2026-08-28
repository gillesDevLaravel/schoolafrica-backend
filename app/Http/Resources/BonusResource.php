<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\UserAllResource;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Http\Resources\Staffs\InscriptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BonusResource extends JsonResource
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
            'bonus_type' => $this->bonus_type,
            'amount' => $this->amount,
            'reason' => $this->reason,
            'status' => $this->status,
            'is_used' => (boolean) $this->is_used,
            'user' => ($this->bonus_type === "student") ? InscriptionResource::make($this->user) : UserAllResource::make($this->user),
            'userApprove' => UserSimpResource::make($this->userApprove),
            'created_at' => $this->created_at,
        ];
    }
}
