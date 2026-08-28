<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable =[
        'name',
        'type',
        'adresse',
        'image',
        'website',
        'niu',
        'type',
        'rc',
        'phone',
        'cni',
        'country',
        'city',
        'mobile',
        'email',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted',
    ];

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('clients.deleted', false);
        });
    }

    public function cash_ins()
    {

    }
}
