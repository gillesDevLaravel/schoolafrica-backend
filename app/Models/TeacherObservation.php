<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TeacherObservation
 *
 * @property int $id
 * @property string $description
 * @property int|null $idAssessment
 * @property int|null $idStudent
 * @property int|null $idClasse
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $idTeacher
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TeacherObservation extends Model
{
	protected $table = 'teacher_observation';

	protected $casts = [
		'idAssessment' => 'int',
		'idStudent' => 'int',
		'idClasse' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idTeacher' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'description',
		'answer',
		'idAssessment',
		'idStudent',
		'idClasse',
		'idSchool',
		'idSection',
		'idTeacher',
		'created_by',
		'updated_by'
	];

    public function student()
    {
        return $this->belongsTo(User::class, "idStudent");
    }
}
