<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'name',
        'description',
        'comments',
        'user_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
