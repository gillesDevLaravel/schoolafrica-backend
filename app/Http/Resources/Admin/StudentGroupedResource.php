<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentGroupedResource extends JsonResource
{
    protected $groups;

    public function __construct($resource, array $groups = [])
    {
        parent::__construct($resource);
        $this->groups = $groups;
    }

    public function toArray($request)
    {
        return [
            'student' => [
                'id' => $this->id,
                'name' => $this->name ?? null,
                'firstname' => $this->firstname ?? null,
                'lastname' => $this->lastname ?? null,
                'email' => $this->email ?? null,
                'phone' => $this->phone ?? null,
                'idSchool' => $this->idSchool ?? null,
                'idSection' => $this->idSection ?? null,
                'idClasse' => $this->idClasse ?? null,
                'idParent' => $this->idParent ?? null,
            ],
            'groups' => $this->groups,
        ];
    }
}
