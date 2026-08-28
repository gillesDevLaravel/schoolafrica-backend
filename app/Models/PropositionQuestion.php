<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PropositionQuestion extends Model
{
    protected $table = 'proposition_questions';

    protected $fillable = [
        'idQuestionnaire',
        'intitule',
        'is_correct',
        'deleted',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('proposition_questions.deleted', false);
        });
    }

//    public function questionnaire(){
//        return $this->belongsTo(Questionnaire::class, 'idQuestionnaire')->select(['id', 'idAssessment', 'idAssessmentType', 'intitule']);
//    }
}
