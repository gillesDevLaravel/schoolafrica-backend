<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'remark',
        'description',
        'amount_month',
        'amount_terms1',
        'amount_terms2',
        'amount_terms3',
        'amount',
    ];

    protected $casts = [
        'amount_month'   => 'float',
        'amount_terms1'  => 'float',
        'amount_terms2'  => 'float',
        'amount_terms3'  => 'float',
        'amount'         => 'float',
    ];

    public function users()
    {
        return $this->hasMany(TransportUser::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentTransportUser::class);
    }
}
