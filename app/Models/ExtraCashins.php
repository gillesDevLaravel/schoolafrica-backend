<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraCashins extends Model
{
    protected $table = 'extra_cashins';

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
}
