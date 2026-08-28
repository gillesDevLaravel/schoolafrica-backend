<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Module
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $nbrChapters
 * @property int|null $duration
 * @property string|null $image
 * @property Carbon|null $startDate
 * @property Carbon|null $endDate
 * @property string|null $status
 * @property string|null $observation
 * @property int $idProgression
 * @property int|null $idMatter
 * @property int|null $idTeacher
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Module extends Model
{
	protected $table = 'modules';

	protected $casts = [
		'nbrChapters' => 'int',
		'duration' => 'int',
		'startDate' => 'datetime',
		'endDate' => 'datetime',
		'idProgression' => 'int',
		'idMatter' => 'int',
		'idTeacher' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'nbrChapters',
		'duration',
		'image',
		'startDate',
		'endDate',
		'status',
		'observation',
		'idProgression',
		'idMatter',
		'idTeacher',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function progression()
    {
        return $this->belongsTo(Progression::class, 'idProgression');
    }

    public function matter()
    {
        return $this->belongsTo(Matter::class, 'idMatter');
    }

    public function getMatterNameAttribute()
    {
        return $this->matter;
    }
}
