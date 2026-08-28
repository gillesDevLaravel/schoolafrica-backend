<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $fillable=[
        'idUser',
        'reason',
        'date',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'idUser');
    }
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
