<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property double $stock
 * @property Article $article
 * @property Product|null $product
 */
class ArticleMovement extends Model
{
    use SoftDeletes;

    protected $table = 'article_movements';

    protected $fillable = [
        'stock',
        'quantity',
        'reason',
        'date',
        'description',
        'operation_type',
        'article_id',
        'user_id',
        'purchase_order_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Relations
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
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

    // Todo : Decommenter apres la fusion de purchase order avec le main
    //    public function purchaseOrder()
    //    {
    //        return $this->belongsTo(PurchaseOrder::class);
    //    }

    /**
     * Scopes
     */
    public function scopeEntry($query)
    {
        return $query->where('operation_type', 'entry');
    }

    public function scopeExit($query)
    {
        return $query->where('operation_type', 'exit');
    }
}
