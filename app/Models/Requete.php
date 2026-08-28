<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requete extends Model
{
    use SoftDeletes;
    
    protected $fillable=[
        'categorie',
        'description',
        'statut',
        'idTypeRequete',
        'reponse',
        'idUser',
        'idSection',
        'idSchool',
        'created_by',
        'updated_by',
    ];

    public function typeRequete()
    {
        return $this->belongsTo(TypeRequete::class, "idTypeRequete");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "idUser");
    }
}
