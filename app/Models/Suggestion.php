<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Suggestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'answer',
        'user_id',
        'is_anonymous',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
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

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notificationable');
    }
}
