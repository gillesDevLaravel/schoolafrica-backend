<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageLivre extends Model
{
    protected $table = 'page_livres';

    protected $fillable = [
        'idBook',
        'titre',
        'sous_titre',
        'description',
        'created_by',
        'deleted',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('page_livres.deleted', false);
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'idBook');
    }
}
