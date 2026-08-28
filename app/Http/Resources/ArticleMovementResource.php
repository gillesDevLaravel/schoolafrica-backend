<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleMovementResource extends JsonResource
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
            'stock' => $this->stock,
            'reason' => $this->reason,
            'date' => $this->date,
            'container_stock' => ($this->article->container_quantity > 0)
                ? [((int)($this->stock / $this->article->container_quantity)),  $this->stock % $this->article->container_quantity]
                :[0,0],
            'quantity' => $this->quantity,
            'container_quantity' => ($this->article->container_quantity > 0)
                ? [((int)($this->quantity / $this->article->container_quantity)),  $this->quantity]
                : [0,0],
            'description' => $this->description,
            'operationType' => $this->operation_type,

            // Relations
            'user' => UserSimpResource::make($this->user),
            'article' => new ArticleResource($this->article),

            'created_by' => UserSimpResource::make($this->createdBy),
            'updated_by' => UserSimpResource::make($this->updatedBy),
            'deleted_by' => UserSimpResource::make($this->deletedBy),

            'created_at' => $this->created_at,
        ];
    }
}
