<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 *
 * @property int $id
 * @property Carbon $hour
 * @property int $duration
 * @property string $day
 * @property Carbon|null $date
 * @property string|null $document
 * @property int $idMatter
 * @property int $idClasse
 * @property int $idTeacher
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $idLevel
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Course extends Model
{
    use SoftDeletes;
    
    protected $table = 'courses';

	protected $casts = [
		'date' => 'datetime',
		'hour' => 'datetime',
		'duration' => 'int',
		'idMatter' => 'int',
		'idClasse' => 'int',
		'idTeacher' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'idLevel' => 'int',
		'idPiece' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'hour',
		'duration',
		'day',
		'date',
		'document',
		'idMatter',
		'idClasse',
		'idTeacher',
		'idSchool',
		'idSection',
		'idLevel',
		'idPiece',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];


    public function matter()
    {
        return $this->belongsTo(Matter::class, "idMatter");
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, "idTeacher");
    }
    public function classe()
    {
        return $this->belongsTo(Classes::class, "idClasse");
    }
    public function piece()
    {
        return $this->belongsTo(Piece::class, "idPiece");
    }
}
