<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MatterHasLevel
 * 
 * @property int $id
 * @property int $matter_id
 * @property int $level_id
 *
 * @package App\Models
 */
class MatterHasLevel extends Model
{
	protected $table = 'matter_has_level';
	public $timestamps = false;

	protected $casts = [
		'matter_id' => 'int',
		'level_id' => 'int'
	];

	protected $fillable = [
		'matter_id',
		'level_id'
	];
}
