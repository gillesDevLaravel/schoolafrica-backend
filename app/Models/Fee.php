<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fee
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property Carbon $deadline
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
class Fee extends Model
{
	protected $table = 'fees';

	public function levels(){
		return $this->belongsToMany(Level::class,'fee_has_level');
	}

	protected $casts = [
		'price' => 'int',
		'order' => 'int',
		'idOptionLevel' => 'int',
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
		'description',
		'price',
		'deadline',
        'order',
        'required',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'type_of_recipe_id',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    protected static function booted(){
        //Je veux que, par défaut, toutes les requêtes prennent les résultats qui ne sont pas 'deleted'
        static::addGlobalScope('isDeleted', function(Builder $builder){
            $builder->where('fees.deleted', false);
        });
    }

    public function typeOfRecipe(){
        return $this->belongsTo(TypeOfRecipe::class, 'type_of_recipe_id');
    }
}
