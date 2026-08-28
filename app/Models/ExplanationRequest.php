<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExplanationRequest extends Model
{
    use SoftDeletes;

    protected $table = 'explanation_requests';

    protected $fillable = [
        'name',
        'description',
        'date',
        'idUser',
        'idResponsable',
        'image',
        'comments',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idResponsable');
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
