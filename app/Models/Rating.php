<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 *
 * @property int $id
 * @property double|null $value
 * @property string|null $observation
 * @property int|null $notemax
 * @property int|null $idCoeficient
 * @property int $idMatter
 * @property int $idStudent
 * @property int $idClasse
 * @property int $idAssessment
 * @property int $idAssessmentType
 * @property int|null $idTypeEvaluation
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $idTeacher
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Rating extends Model
{
	protected $table = 'ratings';

	protected $casts = [
		'value' => 'double',
		'notemax' => 'int',
		'idCoeficient' => 'int',
		'idMatter' => 'int',
		'idStudent' => 'int',
		'idClasse' => 'int',
		'idAssessment' => 'int',
		'idAssessmentType' => 'int',
		'idTypeEvaluation' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idTeacher' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'value',
		'observation',
		'notemax',
		'idCoeficient',
		'idMatter',
		'idStudent',
		'idClasse',
		'idAssessment',
		'idAssessmentType',
		'idTypeEvaluation',
		'idSchool',
		'idSection',
		'idTeacher',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    public function user()
    {
        return $this->belongsTo(User::class, "idStudent");
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, "idTeacher");
    }
    public function matter()
    {
        return $this->belongsTo(Matter::class, "idMatter");
    }
    public function typeEvaluation()
    {
        return $this->belongsTo(TypeEvaluation::class, "idTypeEvaluation");
    }
    public function assessmentType()
    {
        return $this->belongsTo(AssessmentType::class, "idAssessmentType");
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, "idAssessment");
    }

    public function coefficient()
    {
        return $this->belongsTo(Coefficient::class, "idCoeficient");
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('ratings.deleted', false);
        });
    }
}
