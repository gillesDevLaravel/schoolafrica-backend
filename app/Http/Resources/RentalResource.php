<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
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

            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'article_id'      => $this->article_id,
            'description'     => $this->description,
            'reason'          => $this->reason,
            'exit_quantity'   => $this->exit_quantity,
            'exit_date'       => $this->exit_date,
            'exit_condition'  => $this->exit_condition,
            'exit_image'      => $this->exit_image,
            'entry_quantity'  => $this->entry_quantity,
            'entry_date'      => $this->entry_date,
            'entry_condition' => $this->entry_condition,
            'entry_image'     => $this->entry_image,

            // relations (optionnelles)
            'article' => ArticleSimpResource::make($this->article),
            'user'    => UserSimpResource::make($this->user),

            // audit
            'createdBy'      => UserSimpResource::make($this->createdBy),
            'updatedBy'      => UserSimpResource::make($this->updatedBy),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
