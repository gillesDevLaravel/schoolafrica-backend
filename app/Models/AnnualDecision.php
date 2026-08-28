<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnualDecision extends Model
{
    use SoftDeletes;

    protected $table = 'annual_decisions';

    // Les colonnes qui peuvent être assignées massivement
    protected $fillable = [
        'idOptionLevel',
        'idUser',
        'decision',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
