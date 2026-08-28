<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sanction
 *
 * @property int $id
 * @property string $type
 * @property string $description
 * @property string $reasons
 * @property int $idUser
 * @property int $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Sanction extends Model
{
	use SoftDeletes;

	protected $table = 'sanctions';

	protected $casts = [
		'idUser' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'type',
		'description',
		'reasons',
		'idUser',
		'idSchool',
		'idSection',
		'created_by',
		'updated_by'
	];

    public function user()
    {
        return $this->belongsTo(User::class, "idUser");
    }
    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
