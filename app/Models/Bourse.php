<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bourse extends Model
{
    protected $fillable=[
        'name',
        'description',
        'amount',
        'idSchool',
        'idSection',
        'created_by',
        'updated_by',
    ];
}
