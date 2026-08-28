<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Absence
 *
 * @property int $id
 * @property string $cle
 * @property string $route
 * @property string|null $logo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Key extends Model
{
    protected $table = 'key';

    protected $connection = 'mysql2';

    protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int'
	];

    protected $fillable = [
		'cle',
		'route',
		'logo',
		'qr_key',
		'created_by',
		'updated_by'
	];
}
