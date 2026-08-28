<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClasseHasUser
 * 
 * @property int $id
 * @property int $classes_id
 * @property int $user_id
 *
 * @package App\Models
 */
class ClasseHasUser extends Model
{
	protected $table = 'classe_has_user';
	public $timestamps = false;

	protected $casts = [
		'classes_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'classes_id',
		'user_id'
	];
}
