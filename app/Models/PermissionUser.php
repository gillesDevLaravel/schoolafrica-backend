<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionUser extends Model
{
    use SoftDeletes;

    // Nom de la table
    protected $table = 'permissions_users';

    // Colonnes qui peuvent être remplies en masse (mass assignable)
    protected $fillable = [
        'raison',
        'depart',
        'retour',
        'duration', //en heure
        'idUser',
        'idUserApprove',
        'updated_by',
        'deleted_by',
        'statut',
        'comments',
    ];

    // Colonnes de type date à traiter avec Carbon
    protected $dates = [
        'depart',
        'retour',
        'deleted_at',
    ];

    // Relations avec l'utilisateur qui a créé la permission
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    // Relations avec l'utilisateur qui a mis à jour la permission
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
