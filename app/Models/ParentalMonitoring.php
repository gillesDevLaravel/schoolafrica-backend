<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParentalMonitoring
 * 
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $comment
 * @property string $answer
 * @property int $idParent
 * @property int $idStudent
 * @property int $idClasse
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ParentalMonitoring extends Model
{
	protected $table = 'parental_monitoring';

	protected $casts = [
		'idParent' => 'int',
		'idStudent' => 'int',
		'idClasse' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'type',
		'comment',
		'answer',
		'idParent',
		'idStudent',
		'idClasse',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];
}
