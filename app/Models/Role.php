<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string|null $description
 * @property string|null $type
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';

	protected $casts = [
		'idSchool' => 'int',
		'idSection' => 'int'
	];

	protected $fillable = [
		'name',
		'guard_name',
		'description',
		'type',
		'idSchool',
		'idSection'
	];
}
