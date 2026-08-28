<?php

namespace App\Http\Resources\Staffs;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryAdvanceResource extends JsonResource
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
            'amount' => $this->amount,
            'status' => $this->status,
            'reason' => $this->reason,
            'user' => $this->user,
            'userApprove' => $this->userApprove,
            'created_at' => $this->created_at,//->format("d M Y"),
            'approval_date' => (!is_null($this->approval_date)) ? $this->approval_date : $this->approval_date,
        ];
    }
}
