<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeInvoice extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
        'code',
        'type',
        'category',
        'school_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, "school_id");
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'idTypeInvoice');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
