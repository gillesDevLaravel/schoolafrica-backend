<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResourceOM extends JsonResource
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
            'access_token' => $this->access_token,
            'expires_in' => $this->expires_in,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'reference' => $this->reference,
            'status' => $this->status,
            'message' => $this->message,
            'pay_token' => $this->pay_token,
            'payment_url' => $this->payment_url,
            'notif_token' => $this->notif_token
        ];
    }
}
