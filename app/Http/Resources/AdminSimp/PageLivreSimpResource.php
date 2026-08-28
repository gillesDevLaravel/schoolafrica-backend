<?php

namespace App\Http\Resources\AdminSimp;

use App\Http\Resources\Admin\BookResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PageLivreSimpResource extends JsonResource
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
            'titre' => $this->titre,
            'sous_titre' => $this->sous_titre,
            'book' => BookResource::make($this->book),
        ];
    }
}
