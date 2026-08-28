<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Trimestre
 *
 * @property int $id
 * @property string $name
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @package App\Models
 */
class Semestre extends Model
{
	use SoftDeletes;

	protected $casts = [
		'idSchool' => 'int',
		'idSection' => 'int',
		'idSemestre' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'name',
		'created_by',
		'updated_by',
		'deleted_by'
	];

    public function trimestres()
    {
        return $this->hasMany(Trimestre::class, 'idSemestre');
    }
}
