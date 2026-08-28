<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReglementInterieur extends Model
{
    protected $table = 'reglement_interieurs';

    protected $fillable = [
        'title',
        'description',
        'type',
        'image',
        'idSchool',
        'idSection',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('reglement_interieurs.deleted', false);
        });
    }
}
