<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $idSchool
 * @property int|null $idPrincipal
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Section extends Model
{
	use SoftDeletes;

	protected $table = 'section';

	protected $casts = [
		'idSchool' => 'int',
		'idPrincipal' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'lang',
		'idSchool',
		'idPrincipal',
		'created_by',
		'updated_by'
	];
}
