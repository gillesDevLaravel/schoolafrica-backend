<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FeeHasLevel
 * 
 * @property int $id
 * @property int $fee_id
 * @property int $level_id
 *
 * @package App\Models
 */
class FeeHasLevel extends Model
{
	protected $table = 'fee_has_level';
	public $timestamps = false;

	protected $casts = [
		'fee_id' => 'int',
		'level_id' => 'int'
	];

	protected $fillable = [
		'fee_id',
		'level_id'
	];
}
