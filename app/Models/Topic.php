<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $duration
 * @property Carbon $startDate
 * @property Carbon $endDate
 * @property string $status
 * @property string|null $observation
 * @property int $idLesson
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Topic extends Model
{
	protected $table = 'topics';

	protected $casts = [
		'duration' => 'int',
		'idLesson' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'startDate',
		'endDate'
	];

	protected $fillable = [
		'name',
		'description',
		'duration',
		'startDate',
		'endDate',
		'status',
		'observation',
		'idLesson',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];
}
