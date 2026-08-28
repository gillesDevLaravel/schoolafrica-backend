<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MatterGroup
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $idOptionLevel
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MatterGroup extends Model
{
	use SoftDeletes;

	protected $table = 'matter_group';

	public function matters(){
		return $this->belongsToMany('App\Models\Matter','matter_group_has_matter');
	}

	public function levels(){
		return $this->belongsToMany('App\Models\Level','matter_group_has_level');
	}

	protected $casts = [
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];
}
