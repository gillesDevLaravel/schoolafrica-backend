<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransportUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transport_user_id',
        'advance_payment',
        'balance_payment',
        'payment_date',
        'payment_mode',
        'scan_receipt',
        'solvable',
        'photo',
        'reason',
        'receipt_number',
        'telephone',
        'reference',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'advance_payment'  => 'float',
        'balance_payment'  => 'float',
        'payment_date'     => 'date',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
        'deleted_at'       => 'datetime',
    ];

    /**
     * Relations
     */
    public function transportUser(): BelongsTo
    {
        return $this->belongsTo(TransportUser::class);
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
}
