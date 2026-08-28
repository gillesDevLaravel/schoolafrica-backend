<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use SoftDeletes;

    protected $fillable=[
        'name',
        'photo',
        'status',
        'auteur',
        'editeur',
        'date_publication',
        'idSchool',
        'idSection',
        'idLevel',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class, "idBook");
    }

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('books.deleted', false);
        });
    }

    public function pages()
    {
        return $this->hasMany(PageLivre::class, "idBook");
    }
}
