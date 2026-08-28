<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coefficient
 * 
 * @property int $id
 * @property int $value
 * @property string|null $description
 * @property int|null $idMatter
 * @property int|null $idLevel
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
class Coefficient extends Model
{
	protected $table = 'coefficients';

	public function levels()
    {
        return $this->belongsToMany('App\Models\Level', 'level_coefficient', 'coefficient_id', 'level_id');
    }

	protected $casts = [
		'value' => 'int',
		'idMatter' => 'int',
		'idLevel' => 'int',
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'value',
		'description',
		'idMatter',
		'idLevel',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];
}
