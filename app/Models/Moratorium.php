<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moratorium extends Model
{
    use SoftDeletes;

    protected $table = 'moratoriums';

    protected $fillable = [
        'idUser',
        'startDate',
        'endDate',
        'reason',
        'note_comptable',
        'note_fondatrice',
        'status',
        'idUserApprove',
        'createdBy',
        'updatedBy'
    ];

    /**
     * L'utilisateur qui a demandé le moratoire
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }


    /**
     * L'utilisateur qui a demandé le moratoire
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    /**
     * L'utilisateur qui doit approuver le moratoire
     */
    public function userApprove()
    {
        return $this->belongsTo(User::class, 'idUserApprove');
    }
}
