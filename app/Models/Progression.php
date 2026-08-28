<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Progression
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $nbrModules
 * @property string|null $status
 * @property int|null $idClasse
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Progression extends Model
{
	use SoftDeletes;

	protected $table = 'progressions';

	public function classes(){
		return $this->belongsToMany('App\Models\Classes','progressions_has_classes');
	}

	protected $casts = [
		'nbrModules' => 'int',
		'idClasse' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'nbrModules',
		'status',
		'idClasse',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];
}
