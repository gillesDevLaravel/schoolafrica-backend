<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SchoolFolder
 * 
 * @property int $id
 * @property int $idStudent
 * @property int $idSchool
 * @property int $idSection
 * @property string $medicalCertificate
 * @property string $lastBulletin
 * @property string $lastDiploma
 * @property string $birthCertificate
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SchoolFolder extends Model
{
	protected $table = 'school_folders';

	protected $casts = [
		'idStudent' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'idStudent',
		'idSchool',
		'idSection',
		'medicalCertificate',
		'lastBulletin',
		'lastDiploma',
		'birthCertificate',
		'created_by',
		'updated_by'
	];
}
