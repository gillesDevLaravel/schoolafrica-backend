<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAdvance extends Model
{
    protected $fillable = [
        'idUser',
        'idUserApprove',
        'amount',
        'status',
        'reason',
        'approval_date',
        'comments',
        'deleted',
        'updated_by',
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
