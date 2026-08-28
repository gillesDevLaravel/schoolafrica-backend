<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Trimestre
 *
 * @property int $id
 * @property string $name
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Trimestre extends Model
{
	use SoftDeletes;

	protected $table = 'trimestre';

	protected $casts = [
		'idSchool' => 'int',
		'idSection' => 'int',
		'idSemestre' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'numbering',
		'idSchool',
		'idSection',
		'idSemestre',
        'takenIntoAccount',
		'created_by',
		'updated_by'
	];

    public function assessmentTypes()
    {
        return $this->hasMany(AssessmentType::class, 'idTrimestre');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'idSemestre');
    }
}
