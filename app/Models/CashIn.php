<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashIn extends Model
{
    use SoftDeletes;

    protected $table = 'cash_ins';

    protected $fillable = [
        'idClient',
        'amount_to_receive',
        'amount_received',
        'reason',
        'payment_method',
        'irpp',
        'payment_date',
        'receipt_number',
        'operator',
        'type_of_recipe_id',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    protected $casts = [
        'amount_to_receive' => 'float',
        'amount_received' => 'float',
        'amount_remaining' => 'float',
        'irpp' => 'boolean',
    ];

    protected $appends=[
        'amount_remaining',
    ];

    public function getAmountRemainingAttribute()
    {
        // Le reste ne peut pas être négatif donc ...
        return max(0, $this['amount_to_receive'] - $this['amount_received']);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'idClient');
    }

    public function typeOfRecipe()
    {
        return $this->belongsTo(TypeOfRecipe::class, 'type_of_recipe_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
