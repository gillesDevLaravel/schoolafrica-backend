<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Chapter
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $nbrLessons
 * @property int|null $duration
 * @property string|null $image
 * @property Carbon|null $startDate
 * @property Carbon|null $endDate
 * @property string|null $status
 * @property string|null $observation
 * @property int $idModule
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Chapter extends Model
{
	protected $table = 'chapters';

	protected $casts = [
		'nbrLessons' => 'int',
		'duration' => 'int',
		'startDate' => 'datetime',
		'endDate' => 'datetime',
		'idModule' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'nbrLessons',
		'duration',
		'image',
		'startDate',
		'endDate',
		'status',
		'observation',
		'idModule',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function module()
    {
        return $this->belongsTo(Module::class, "idModule");
    }
}
