<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScanReceiptResource extends JsonResource
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
            'academicYear' => $this->academicYear,
            'idSchool' => $this->idSchool,
            'student' => $this->student,
            'image_scan' => $this->image_scan,
            'created_at' => $this->created_at,
        ];
    }
}
