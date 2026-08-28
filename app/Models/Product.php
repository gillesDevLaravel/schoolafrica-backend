<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'idProduct');
    }
}
