<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon $due_date
 * @property string $priority
 * @property string $status
 * @property int $idUser
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Task extends Model
{
	protected $table = 'tasks';

	protected $casts = [
		'idUser' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'due_date'
	];

	protected $fillable = [
		'name',
		'description',
		'due_date',
		'priority',
		'status',
		'duree_mise',
		'estimation',
		'observation',
		'idProject',
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
}
