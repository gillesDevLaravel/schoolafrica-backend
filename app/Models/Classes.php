<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\ClassStyleEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Class
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $style
 * @property int $idTeacher
 * @property int $idLevel
 * @property int|null $idOptionLevel
 * @property int|null $idSchool
 * @property int|null $idSection
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Classes extends Model
{
	use SoftDeletes;

	protected $table = 'classes';

	public function users(){
		return $this->belongsToMany('App\Models\User','classe_has_user');
	}

	protected $casts = [
		'idTeacher' => 'int',
		'idLevel' => 'int',
		'idOptionLevel' => 'int',
		'idSchool' => 'int',
		'idSection' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'style',
		'photo',
		'idTeacher',
		'idLevel',
		'idOptionLevel',
		'idSchool',
		'idSection',
		'deleted',
		'deleted_by',
		'created_by',
		'updated_by'
	];

    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'idTeacher');
    }

    public function getPhotoAttribute($photo): string
    {
        return asset('public/profil/classes/' . $photo);
    }

    protected static function booted(){
        static::addGlobalScope('isDeleted', function(Builder $builder){
            if (!app()->runningInConsole()) { // Ou tout autre mécanisme pour conditionner
                $builder->where('classes.deleted', false);
            }
        });
    }

    public function nextClasses(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_next_classes', 'class_id', 'next_class_id');
    }

    public function previousClasses(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_next_classes', 'next_class_id', 'class_id');
    }

    public function level(){
        return $this->belongsTo(Level::class, 'idLevel');
    }

    public function school(){
        return $this->belongsTo(School::class, 'idSchool');
    }
}
