<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Level
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $idCycle
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Level extends Model
{
	use SoftDeletes;

	protected $table = 'levels';

	public function optionLevels()
    {
        return $this->belongsToMany('App\Models\OptionLevel', 'level_option_level', 'level_id', 'option_level_id');
    }

	public function coefficients()
    {
        return $this->belongsToMany('App\Models\Coefficient', 'level_coefficient', 'level_id', 'coefficient_id');
    }

    // Relation Many to Many avec Fee
    public function fees(){
        return $this->belongsToMany(Fee::class, 'fee_has_level');
    }

    public function pensions()
    {
        return $this->hasMany(Pension::class, 'idLevel');
    }


    protected $casts = [
		'idCycle' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'idCycle',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];
}
