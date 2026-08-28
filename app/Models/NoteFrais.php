<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NoteFrais extends Model
{
    protected $table = 'note_frais';

    protected $fillable = [
        'idUser',
        'libelle',
        'amount',
        'status',
        'description',
        'idUserApprove',
        'date',
        'created_by',
        'updated_by',
        'deleted',
        'deleted_by',
    ];

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('note_frais.deleted', false);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
