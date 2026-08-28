<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $nbrSections
 * @property int|null $duration
 * @property string|null $image
 * @property Carbon|null $startDate
 * @property Carbon|null $endDate
 * @property string|null $status
 * @property string|null $observation
 * @property int $idChapter
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Lesson extends Model
{
	protected $table = 'lessons';

	protected $casts = [
		'nbrSections' => 'int',
		'duration' => 'int',
		'startDate' => 'datetime',
		'endDate' => 'datetime',
		'idChapter' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'nbrSections',
		'duration',
		'image',
		'startDate',
		'endDate',
		'status',
		'observation',
		'idChapter',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, "idChapter");
    }

    public function lesson_summaries()
    {
        return $this->hasMany(LessonSummary::class);
    }
}
