<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuggestionResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'answer' => $this->answer,
            'user'        => $this->is_anonymous ? null : UserSimpResource::make($this->user),
            'value'        => $this->created_by,
            'created_at' => $this->created_at,
        ];
    }
}
