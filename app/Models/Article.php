<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $stock_quantity
 * @property mixed $pivot
 */
class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'idSchool',
        'idSection',
        'name',
        'unit_of_measurement',
        'description',
        'alert_quantity',
//        'service_id',
        'price',
        'type',
        'image',
        'expiry_date',
        'container',
        'container_unit',
        'container_quantity',
        'detail',
        'created_by',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function getStockQuantityAttribute(): int
    {
        $lastMovement = $this->movements()
            ->orderByDesc('created_at')
            ->first();

        return $lastMovement->stock ?? 0;
    }

//    public function getArticleImageAttribute(): ?string
//    {
//        return ! empty($this->attributes['image'])
//            ? asset('storage/'.$this->attributes['image'])
//            : null;
//    }

    // Relation avec le service (si tu as une table 'services')
//    public function service(): BelongsTo
//    {
//        return $this->belongsTo(Service::class);
//    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relation avec les produits
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'article_product', 'article_id', 'product_id')->withPivot('quantity');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(ArticleMovement::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_supplier', 'article_id', 'supplier_id');
    }
}
