<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseUser extends Model
{
    protected $table = 'response_users';

    protected $fillable = [
        'idUser',
        'idQuestionnaire',
        'idAssessment',
        'response',
        'note',
        'status',
        'deleted',
        'updated_by',
        'deleted_by',
    ];

    public function question()
    {
        return $this->belongsTo(Questionnaire::class, 'idQuestionnaire');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUser');
    }
}
