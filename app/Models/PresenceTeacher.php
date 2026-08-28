<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PresenceTeacher
 *
 * @property int $id
 * @property int $idTeacher
 * @property Carbon|null $date
 * @property Carbon|null $hour
 * @property Carbon|null $arrivalTime
 * @property Carbon|null $departureTime
 * @property int|null $idCourse
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PresenceTeacher extends Model
{
    use SoftDeletes;
    
    protected $table = 'presence_teacher';

	protected $casts = [
		'idTeacher' => 'int',
		'idCourse' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'date',
		'hour',
		'arrivalTime',
		'departureTime'
	];

	protected $fillable = [
		'idTeacher',
		'date',
		'hour',
		'arrivalTime',
		'departureTime',
		'idCourse',
		'idSchool',
		'idSection',
		'idClasse',
		'type',
		'scanPerCourse',
		'raison',
		'savingType',
		'created_by',
		'updated_by'
	];

    public function teacher()
    {
        return $this->belongsTo(User::class, "idTeacher");
    }

    public function course()
    {
        return $this->belongsTo(Course::class, "idCourse");
    }

    public function matter()
    {
        return $this->course()->matter;
    }
}
