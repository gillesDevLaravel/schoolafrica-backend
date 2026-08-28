<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cycle
 *
 * @property int $id
 * @property string $name
 * @property int|null $idCampus
 * @property int $idSchool
 * @property int $idSection
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Cycle extends Model
{
	use SoftDeletes;

	protected $table = 'cycles';

	protected $casts = [
		'idCampus' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'idCampus',
		'idSchool',
		'idSection',
		'description',
		'created_by',
		'updated_by'
	];

    public function filieres()
    {
        return $this->belongsToMany(Filiere::class);
    }
}
