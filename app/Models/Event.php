<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon $startDate
 * @property Carbon $endDate
 * @property string $type
 * @property int|null $parentalContribution
 * @property int|null $budget
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Event extends Model
{
    use SoftDeletes;

	protected $table = 'events';

	protected $casts = [
		'parentalContribution' => 'int',
		'budget' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'startDate',
		'endDate',
		'deleted_at'
	];

	protected $fillable = [
		'name',
		'description',
		'startDate',
		'endDate',
		'type',
		'parentalContribution',
		'budget',
		'idSchool',
		'idSection',
		'classes',
		'levels',
		'created_by',
		'updated_by',
	];
}
