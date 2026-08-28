<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Reliese\Coders\Model\Relations\HasMany;

/**
 * Class Pension
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $nbrTranche
 * @property int $idLevel
 * @property int|null $idOptionLevel
 * @property int $idSchool
 * @property int $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Pension extends Model
{
	protected $table = 'pensions';

	protected $casts = [
		'price' => 'int',
		'nbrTranche' => 'int',
		'idLevel' => 'int',
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'price',
		'nbrTranche',
		'idLevel',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'type_of_recipe_id',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    /**
 * Relation : Une pension possède plusieurs tranches.
 */
    public function tranches(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tranche::class, 'idPension');
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('pensions.deleted', false);
        });
    }

    public function typeOfRecipe(){
        return $this->belongsTo(TypeOfRecipe::class, 'type_of_recipe_id');
    }
}
