<?php

namespace App\Models;

use App\Enums\PurchaseOrderPaymentStatusEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Collection|Article[] $articles
 * @property-read float $total_amount
 */
class PurchaseOrder extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_orders';

    // Définir les champs qui peuvent être assignés en masse
    protected $fillable = [
        'reference',
        'supplier_id',
        'responsible_id',
        'description',
        'validation_date',
        'order_received_date',
        'status',
        'payment_method',
        'payment_status',
        'priority',
        'quotation_file',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'validation_date' => 'datetime',
        'order_received_date' => 'datetime',
    ];

    /**
     * @property Pivot $pivot
     */
    public function getTotalAmountAttribute()
    {
        return $this->articles->sum(function ($article) {
            /** @var Article $article */
            // Si l'article a un pivot, on peut l'utiliser.
            return $article->pivot->unit_price * $article->pivot->quantity;
        });
    }

    public function getPaymentStatutAttribute(): string
    {
        $totalAmount = (float) ($this->total_amount ?? 0);
        if ($totalAmount <= 0) {
            return PurchaseOrderPaymentStatusEnum::COMPLETED;
        }

        $totalPaid = $this->relationLoaded('invoices')
            ? (float) $this->invoices->sum('amount')
            : (float) $this->invoices()->sum('amount');

        if ($totalPaid <= 0) {
            return PurchaseOrderPaymentStatusEnum::NONE;
        }

        if ($totalPaid < $totalAmount) {
            return PurchaseOrderPaymentStatusEnum::ADVANCE;
        }

        return PurchaseOrderPaymentStatusEnum::COMPLETED;
    }

    public function getTotalAmountPaidAttribute()
    {
        return $this->relationLoaded('invoices')
            ? (float) $this->invoices->sum('amount')
            : (float) $this->invoices()->sum('amount');
    }


//    public function getQuotationFileAttribute(): ?string
//    {
//        return ! empty($this->attributes['quotation_file'])
//            ? asset('uploads/'.$this->attributes['quotation_file'])
//            : null;
//    }

    // Relations avec d'autres modèles
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    /**
     * Relation many-to-many avec l'article via la table pivot
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_purchase_order', 'purchase_order_id', 'article_id')
            ->withPivot('unit_price', 'quantity');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'purchase_order_id');
    }

    /**
     * Vérifie que tous les articles ont un prix unitaire et une quantité valides.
     */
    public function hasValidArticles(): bool
    {
        return $this->articles->every(function ($article) {
            return $article->pivot->unit_price !== null && $article->pivot->quantity > 0;
        });
    }

    

//    public function disbursement(): HasOne
//    {
//        return $this->hasOne(Disbursement::class, 'purchase_order_id');
//    }
}
