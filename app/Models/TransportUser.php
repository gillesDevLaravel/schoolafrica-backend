<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transport_id',
        'student_id',
        'type',
        'amount',
        'reduction',
        'reduction_amount',
        'reason',
    ];

    protected $casts = [
        'amount'   => 'float',
        'reduction_amount'  => 'float',
        'reduction' => 'boolean',
    ];

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentTransportUser::class, 'transport_user_id');
    }
}
