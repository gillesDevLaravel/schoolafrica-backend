<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OptionLevel
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $idLevel
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OptionLevel extends Model
{
	use SoftDeletes;

	protected $table = 'option_level';

	public function levels()
    {
        return $this->belongsToMany('App\Models\Level', 'level_option_level', 'option_level_id', 'level_id');
    }

	protected $casts = [
		'idLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'lang',
		'idLevel',
		'idSchool',
		'idSection',
		'idFiliere',
		'created_by',
		'updated_by'
	];

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class);
    }
}
