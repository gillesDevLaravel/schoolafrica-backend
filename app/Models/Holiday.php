<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable=[
        'idUser',
        'idUserApprove',
        'type',
        'start_date',
        'end_date',
        'days_taken',
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

    /**
     * Get the user who created the holiday.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the holiday.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted the holiday.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
