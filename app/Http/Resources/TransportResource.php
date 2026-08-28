<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'remark'          => $this->remark,
            'description'   => $this->description,
            'amount_month'  => $this->amount_month,
            'amount_terms1' => $this->amount_terms1,
            'amount_terms2' => $this->amount_terms2,
            'amount_terms3' => $this->amount_terms3,
            'amount'        => $this->amount,
            'created_at'    => $this->created_at,
        ];
    }
}
