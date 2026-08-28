<?php

namespace App\Http\Resources;

use App\Enums\SupplyDemandStatusEnum;
use App\Http\Resources\AdminSimp\UserSimpResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplyDemandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'responsible_id' => $this->responsible_id,
            'responsible' => UserSimpResource::make($this->responsible),
            'creator' => UserSimpResource::make($this->creator),
            'updater' => UserSimpResource::make($this->updater),
            'articles' => $this->articles->map(function ($article) {
                return [
                    'id' => $article->id,
                    'name' => $article->name,
                    'description' => $article->description,
                    'unit_price' => (int) $article->pivot->unit_price,
                    'quantity' => $article->pivot->quantity,
                    'supplier_id' => $article->pivot->supplier_id,
                    'supplier' => UserSimpResource::make(User::find($article->pivot->supplier_id)),
                ];
            }),
            'validation_date' => ($this->status === SupplyDemandStatusEnum::ACCEPTED) ? $this->updated_at->format('Y-m-d') : null,
            'created_at' => $this->created_at
        ];
    }
}
