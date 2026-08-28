<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MatterGroupHasMatter
 * 
 * @property int $id
 * @property int $matter_id
 * @property int $matter_group_id
 *
 * @package App\Models
 */
class MatterGroupHasMatter extends Model
{
	protected $table = 'matter_group_has_matter';
	public $timestamps = false;

	protected $casts = [
		'matter_id' => 'int',
		'matter_group_id' => 'int'
	];

	protected $fillable = [
		'matter_id',
		'matter_group_id'
	];
}
