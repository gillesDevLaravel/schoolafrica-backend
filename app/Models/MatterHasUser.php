<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MatterHasUser
 * 
 * @property int $id
 * @property int $matter_id
 * @property int $user_id
 *
 * @package App\Models
 */
class MatterHasUser extends Model
{
	protected $table = 'matter_has_user';
	public $timestamps = false;

	protected $casts = [
		'matter_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'matter_id',
		'user_id'
	];
}
