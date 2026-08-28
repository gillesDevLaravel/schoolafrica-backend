<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminSimp\UserSimpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'idSchool' => $this->idSchool,
            'idSection' => $this->idSection,
            'name' => $this->name,
            'type' => $this->type,
            'image' => $this->image,
            'price' => $this->price,
            'quantity' => $this->stock_quantity,
            'container_stock' => ($this->container_quantity > 0)
                ? [(int)($this->stock_quantity / $this->container_quantity), $this->stock_quantity % $this->container_quantity]
                : [0, 0],
            'description' => $this->description,
            'unit_of_measurement' => $this->unit_of_measurement,
            'alert_quantity' => $this->alert_quantity,
            'expiry_date' => $this->expiry_date,

            'container' => $this->container,
            'container_unit' => $this->container_unit,
            'container_quantity' => $this->container_quantity,
            'detail' => $this->detail,

            'suppliers' => $this->suppliers ? $this->suppliers->map(function($supplier) {
                return $supplier->only(['id', 'name', 'phone']);
            }) : null,


            //            TODO: decommenter lorsque la ressource simple sera disponible
            'author' => UserSimpResource::make($this->creator),
//            'service' => ServiceResource::make($this->service),
            //            'suppliers' => UserSimpResource::make($this->suppliers),
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
