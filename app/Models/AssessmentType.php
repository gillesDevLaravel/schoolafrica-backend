<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AssessmentType
 *
 * @property int $id
 * @property string $name
 * @property int|null $idTrimestre
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AssessmentType extends Model
{
	use SoftDeletes;

	protected $table = 'assessment_type';

	protected $casts = [
		'idTrimestre' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'pourcentage' => 'float',
		'start_date' => 'date',
		'end_date' => 'date',
		'notes_completed' => 'boolean'
	];

	protected $fillable = [
		'name',
		'numbering',
		'idTrimestre',
		'idSchool',
		'idSection',
		'takenIntoAccount',
		'pourcentage',
		'start_date',
		'end_date',
		'notes_completed',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    public function trimestre()
    {
        return $this->belongsTo(Trimestre::class, 'idTrimestre');
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('assessment_type.deleted', false);
        });
    }
}
