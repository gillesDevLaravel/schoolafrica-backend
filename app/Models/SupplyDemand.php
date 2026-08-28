<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\SupplyDemandPriorityEnum;
use App\Enums\SupplyDemandStatusEnum;

class SupplyDemand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'name',
        'description',
        'responsible_id',
        'status',
        'priority',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Relations (à adapter selon ton projet)
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Relation many-to-many avec l'article via la table pivot
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_supply_demand', 'supply_demand_id', 'article_id')
            ->withPivot('unit_price', 'quantity', 'supplier_id');
    }
}
