<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'validation_date' => $this->validation_date,
            'order_received_date' => $this->order_received_date,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'payment_statut' => $this->payment_statut,
            'priority' => $this->priority,
            'quotation_file' => $this->quotation_file,

            'supplier' => UserSimpResource::make($this->supplier),
            'responsible' => UserSimpResource::make($this->responsible),
//            'articles' => $this->articles,
            'articles' => $this->articles->map(function ($article) {
                return [
                    'id' => $article->id,
                    'name' => $article->name,
                    'type' => $article->type,
//                    'description' => $article->description,
                    'unit_price' => (float) $article->pivot->unit_price,
                    'quantity' => (float) $article->pivot->quantity,
                ];
            }),
            'total_amount' => $this->total_amount, // Accessor du modèle
            'total_amount_paid' => $this->total_amount_paid,
            'total_rest' => $this->total_amount - $this->total_amount_paid,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
