<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable =[
        'name',  'type',  'adresse',  'image',  'website',  'niu',  'type',  'rc',  'phone',  'mobile',  'email', 'created_by', 'updated_by', 'cni', 'country', 'city',
    ];
//
//    public function invoices()
//    {
//        return $this->hasMany(Invoice::class, 'idCustomer');
//    }

    public function getImageAttribute()
    {
        return (!is_null($this->attributes['image'])) ? asset("public/customers/" . $this->attributes['image']) : null;
    }
//    public function getRcAttribute()
//    {
//        return (!is_null($this->attributes['rc'])) ? asset("public/customers/rc/" . $this->attributes['rc']) : null;
//    }
}
