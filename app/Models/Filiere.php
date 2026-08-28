<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable=[
        'name',
        'description',
        'idSection',
        'idSchool',
        'created_by',
        'updated_by',
    ];

    public function cycles()
    {
        return $this->belongsToMany(Cycle::class);
    }

    public function optionLevels()
    {
        return $this->belongsToMany(OptionLevel::class);
    }
}
