<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\SalaryDeduction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryDeductionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => (float) $this->amount,
            'reason' => $this->reason,
            'date' => $this->date,
            'user' => UserSimpResource::make($this->user),
            'userApprove' => UserSimpResource::make($this->userApprove),
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ];
    }
}
