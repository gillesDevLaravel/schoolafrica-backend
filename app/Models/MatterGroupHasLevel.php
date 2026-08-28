<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MatterGroupHasLevel
 * 
 * @property int $id
 * @property int $matter_group_id
 * @property int $level_id
 *
 * @package App\Models
 */
class MatterGroupHasLevel extends Model
{
	protected $table = 'matter_group_has_level';
	public $timestamps = false;

	protected $casts = [
		'matter_group_id' => 'int',
		'level_id' => 'int'
	];

	protected $fillable = [
		'matter_group_id',
		'level_id'
	];
}
