<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Package
 * 
 * @property int $id
 * @property string $name
 * @property string $level
 * @property int $price
 * @property string $duration
 * @property string $description
 * @property bool $website
 * @property bool $mail_pro
 * @property bool $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Package extends Model
{
    use SoftDeletes;
    
	protected $table = 'packages';

	protected $casts = [
		'price' => 'int',
		'website' => 'bool',
		'mail_pro' => 'bool',
		'status' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'level',
		'price',
		'duration',
		'description',
		'website',
		'mail_pro',
		'status',
		'created_by',
		'updated_by'
	];
}
