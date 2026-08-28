<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Assessment
 *
 * @property int $id
 * @property Carbon|null $hour
 * @property int|null $duration
 * @property string|null $day
 * @property Carbon|null $date
 * @property int|null $notemax
 * @property int|null $oral
 * @property int|null $orale
 * @property int|null $ecrit
 * @property int|null $written
 * @property int|null $attitude
 * @property int|null $savoir_etre
 * @property int|null $pratical
 * @property int|null $pratique
 * @property int|null $idMatter
 * @property int|null $idClasse
 * @property int|null $idTeacher
 * @property int|null $idCoeficient
 * @property int|null $idAssessmentType
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Assessment extends Model
{
	protected $table = 'assessments';

	public function typeEvaluations(){
		return $this->belongsToMany('App\Models\TypeEvaluation','assessments_has_type_evaluation');
	}

	public function assessmentTypes(){
		return $this->belongsToMany('App\Models\AssessmentType','assessments_has_assessment_type');
	}

	protected $casts = [
		'hour' => 'datetime',
		'duration' => 'int',
		'date' => 'datetime',
		'notemax' => 'int',
		'oral' => 'int',
		'orale' => 'int',
		'ecrit' => 'int',
		'written' => 'int',
		'attitude' => 'int',
		'savoir_etre' => 'int',
		'pratical' => 'int',
		'pratique' => 'int',
		'idMatter' => 'int',
		'idClasse' => 'int',
		'idTeacher' => 'int',
		'idCoeficient' => 'int',
		'idAssessmentType' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'libelle',
		'hour',
		'duration',
		'day',
		'date',
		'notemax',
		'oral',
		'orale',
		'ecrit',
		'written',
		'attitude',
		'savoir_etre',
		'pratical',
		'pratique',
		'is_qcm',
		'percentage',
		'idMatter',
		'idClasse',
		'idTeacher',
		'idCoeficient',
		'idAssessmentType',
		'idSchool',
		'idSection',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    protected $with = [
        'assessmentTypes'
    ];

    public function classe()
    {
        return $this->belongsTo(Classes::class, "idClasse");
    }

    public function matter()
    {
        return $this->belongsTo(Matter::class, "idMatter");
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, "idTeacher");
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            if (!app()->runningInConsole()) { // Ou tout autre mécanisme pour conditionner
                $builder->where('assessments.deleted', false);
            }
        });
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, "idAssessment");
    }
}
