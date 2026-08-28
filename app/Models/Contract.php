<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'reference',
        'idUser',
        'idUserApprove',
        'type',
        'description',
        'start_date',
        'duration',
        'working_hours',
        'position',
        'gross_salary',
        'status',
        'service_benefits',
        'bonus',
        'number_days_off',
        'file_link',
        'deleted',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'gross_salary' => 'decimal:2',
    ];

    /**
     * Get the user associated with the contract.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    /**
     * Get the user who approve the contract
     *
     */
    public function userApprove()
    {
        return $this->belongsTo(User::class,'idUserApprove');
    }

    /**
     * Get the user who created the contract.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the contract.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the user who deleted the contract.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
