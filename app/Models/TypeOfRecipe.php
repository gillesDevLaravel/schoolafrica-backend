<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfRecipe extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'code',
        'category',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function school(){
        return $this->belongsTo(School::class, 'school_id');
    }
}
