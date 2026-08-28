<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryDeduction extends Model
{
    protected $fillable=[
        'idUser',
        'idUserApprove',
        'amount',
        'reason',
        'date',
        'status',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'idUser');
    }
    public function userApprove()
    {
        return $this->belongsTo(User::class,'idUserApprove');
    }
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
