<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tranche
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property Carbon $deadline
 * @property int $idPension
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Tranche extends Model
{
	protected $table = 'tranches';

	protected $casts = [
		'price' => 'int',
		'idPension' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'deadline'
	];

	protected $fillable = [
		'name',
		'price',
		'deadline',
		'idPension',
		'idSchool',
		'idSection',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    /**
     * Relation : Une tranche appartient à une pension.
     */
    public function pension()
    {
        return $this->belongsTo(Pension::class, 'idPension');
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('tranches.deleted', false);
        });
    }
}
