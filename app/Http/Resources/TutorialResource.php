<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorialResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'content'      => $this->content,
            'video_url'    => $this->video_url,
            'image'        => $this->image,
            'document'     => $this->document,
            'category'     => $this->category,
            'target_role'  => $this->target_role,
            'order'        => $this->order,
            'is_published' => $this->is_published,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'created_by'   => $this->created_by,
            'creator'      => $this->whenLoaded('createdBy'),
        ];
    }
}
