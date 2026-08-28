<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Campus
 * 
 * @property int $id
 * @property string $name
 * @property string $adresse
 * @property int|null $idSchool
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Campus extends Model
{
	use SoftDeletes;

	protected $table = 'campus';

	protected $casts = [
		'idSchool' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'adresse',
		'idSchool',
		'created_by',
		'updated_by'
	];
}
