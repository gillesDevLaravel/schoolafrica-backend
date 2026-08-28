<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
	use SoftDeletes;

    protected $fillable=[
        'idUser',
        'idBook',
        'date_sortie',
        'date_retour',
        'reason',
        'status',
        'observation',
        'idSchool',
        'idSection',
        'created_by',
        'updated_by',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, "idBook");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "idUser");
    }
}
