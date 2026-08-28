<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = 'questionnaires';

    protected $fillable = [
        'idAssessment',
        'idAssessmentType',
        'intitule',
        'reponse',
        'notemax',
        'deleted',
        'updated_by',
        'deleted_by',
    ];

    protected $with = ['propositions'];

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('questionnaires.deleted', false);
        });
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'idAssessment');
    }

    public function propositions()
    {
        return $this->hasMany(PropositionQuestion::class, 'idQuestionnaire'); //->select(['id', 'intitule', 'idQuestionnaire']);
    }
}
