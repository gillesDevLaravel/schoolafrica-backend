<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Google\Service\Classroom\Student;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HomeworkDone
 *
 * @property int $id
 * @property string $description
 * @property int $idStudent
 * @property int $idHomework
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class HomeworkDone extends Model
{
	protected $table = 'homework_dones';

	protected $casts = [
		'idStudent' => 'int',
		'idHomework' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'description',
		'idStudent',
		'idHomework',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function student()
    {
        return $this->belongsTo(User::class, 'idStudent');
    }
    public function homework()
    {
        return $this->belongsTo(Homework::class, 'idHomework');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'idSchool');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'idSection');
    }
}
